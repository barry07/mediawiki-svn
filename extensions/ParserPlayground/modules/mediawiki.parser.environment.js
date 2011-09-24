var MWParserEnvironment = function(opts) {
	var options = {
		tagHooks: {},
		parserFunctions: {},
		pageCache: {}, // @fixme use something with managed space
		domCache: {}
	};
	$.extend(options, opts);
	this.tagHooks = options.tagHooks;
	this.parserFunctions = options.parserFunctions;
	this.pageCache = options.pageCache;
	this.domCache = options.domCache;
};

$.extend(MWParserEnvironment.prototype, {
	// Does this need separate UI/content inputs?
	formatNum: function( num ) {
		return num + '';
	},

	getVariable: function( varname, options ) {
		//
	},

	/**
	 * @return MWParserFunction
	 */
	getParserFunction: function( name ) {
		if (name in this.parserFunctions) {
			return new this.parserFunctions[name]( this );
		} else {
			return null;
		}
	},

	/**
	 * @return MWParserTagHook
	 */
	getTagHook: function( name ) {
		if (name in this.tagHooks) {
			return new this.tagHooks[name](this);
		} else {
			return null;
		}
	},

	/**
	 * @fixme do this for real eh
	 */
	resolveTitle: function( name, namespace ) {
		// hack!
		if (name.indexOf(':') == 0 && typeof namespace ) {
			// hack hack hack
			name = namespace + ':' + name;
		}
		return name;
	},

	/**
	 * Async.
	 *
	 * @todo make some optimizations for fetching multiple at once
	 *
	 * @param string name
	 * @param function(text, err) callback
	 */
	fetchTemplate: function( title, callback ) {
		this.fetchTemplateAndTitle( title, function( text, title, err ) {
			callback(title, err);
		});
	},

	fetchTemplateAndTitle: function( title, callback ) {
		// @fixme normalize name?
		if (title in this.pageCache) {
			// @fixme should this be forced to run on next event?
			callback( this.pageCache[title] );
		} else {
			// whee fun hack!
			$.ajax({
				url: wgScriptPath + '/api' + wgScriptExtension,
				data: {
					format: 'json',
					action: 'query',
					prop: 'revisions',
					rvprop: 'content',
					titles: name
				},
				success: function(data, xhr) {
					var src = null, title = null;
					$.each(data.query.pages, function(i, page) {
						if (page.revisions && page.revisions.length) {
							src = page.revisions[0]['*'];
							title = page.title;
						}
					});
					if (typeof src !== 'string') {
						callback(null, null, 'Page not found');
					} else {
						callback(src, title);
					}
				},
				error: function(msg) {
					callback(null, null, 'Page/template fetch failure');
				},
				dataType: 'json',
				cache: false // @fixme caching, versions etc?
			}, 'json');
		}
	},

	getTemplateDom: function( title, callback ) {
		var self = this;
		if (title in this.domCache) {
			callback(this.domCache[title], null);
		}
		this.fetchTemplateAndTitle( title, function( text, title, err ) {
			if (err) {
				callback(null, err);
				return;
			}
			self.pageCache[title] = text;
			self.parser.parseToTree( text, function( templateTree, err ) {
				this.domCache[title] = templateTree;
				callback(templateTree, err);
			});
		});
	},

	braceSubstitution: function( templateNode, frame, callback ) {
		// stuff in Parser.braceSubstitution
		// expand/flatten the 'title' piece (to get the template reference)
		frame.flatten(templateNode.name, function(templateName, err) {
			if (err) {
				callback(null, err);
				return;
			}
			var out = {
				type: 'placeholder',
				orig: templateNode,
				contents: []
			};

			// check for 'subst:'
			// check for variable magic names
			// check for msg, msgnw, raw magics
			// check for parser functions

			// resolve template name
			// load template w/ canonical name
			// load template w/ variant names
			// recursion depth check
			// fetch from DB or interwiki
			// infinte loop check
			this.getTemplateDom(templateName, function(dom, err) {
				// Expand in-place!
				var templateFrame = frame.newChild(templateName.params || []);
				templateFrame.expand(dom, 0, function(expandedTemplateNode) {
					out.contents = expandedTemplateNode.contents;
					callback(out);
					return; // done
				});
				return; // wait for async
			});
		});
	},

	argSubstitution: function( argNode, frame, callback ) {
		frame.flatten(argNode.name, function(argName, err) {
			if (err) {
				callback(null, err);
				return;
			}

			var arg = frame.getArgument(argName);
			if (arg === false && 'params' in argNode && argNode.params.length) {
				// No match in frame, use the supplied default
				arg = argNode.params[0].val;
			}
			var out = {
				type: 'placeholder',
				orig: argNode,
				contents: [arg]
			};
			callback(out);
		});
	}


});

function PPFrame(env) {
	this.env = env;
	this.loopCheckHash = [];
	this.depth = 0;
}

// Flag constants
$.extend(PPFrame, {
	NO_ARGS: 1,
	NO_TEMPLATES: 2,
	STRIP_COMMENTS: 4,
	NO_IGNORE: 8,
	RECOVER_COMMENTS: 16
});
PPFrame.RECOVER_ORIG = PPFrame.NO_ARGS
	| PPFrame.NO_TEMPLATES
	| PPFrame.STRIP_COMMENTS
	| PPFrame.NO_IGNORE
	| PPFrame.RECOVER_COMMENTS;

$.extend(PPFrame.prototype, {
	newChild: function(args, title) {
		//
	},

	/**
	 * Using simple recursion for now -- PHP version is a little fancier.
	 *
	 * The iterator loop is set off in a closure so we can continue it after
	 * waiting for an asynchronous template fetch.
	 *
	 * Note that this is inefficient, as we have to wait for the entire round
	 * trip before continuing -- in browser-based work this may be particularly
	 * slow. This can be mitigated by prefetching templates based on previous
	 * knowledge or an initial tree-walk.
	 *
	 * @param {object} tree
	 * @param {number} flags
	 * @param {function(tree, error)} callback
	 */
	expand: function(root, flags, callback) {
		/**
		 * Clone a node, but give the clone an empty contents
		 */
		var cloneNode = function(node) {
			var out = $.extend({}, node);
			out.contents = [];
			return out;
		}
		// stub node to write into
		var rootOut = cloneNode(root);

		var self = this,
			expansionDepth = 0,
			outStack = [{contents: []}, rootOut],
			iteratorStack = [false, root],
			indexStack = [0, 0],
			contextNode = false,
			newIterator = false,
			continuing = false;

		var iteration = function() {
			// This while loop is a tail call recursion optimization simulator :)
			while (iteratorStack.length > 1) {
				var level = outStack.length - 1,
					iteratorNode = iteratorStack[level],
					out = outStack[level],
					index = indexStack[level]; // ????

				if (continuing) {
					// If we're re-entering from an asynchronous data fetch,
					// skip over this part, we've done it before.
					continuing = false;
				} else {
					if ($.isArray(iteratorNode)) {
						if (index >= iteratorNode.length) {
							// All done with this iterator.
							iteratorStack[level] = false;
							contextNode = false;
						} else {
							contextNode = iteratorNode[index];
							indexStack[level]++;
						}
					} else {
						// Copy to contextNode and then delete from iterator stack,
						// because this is not an iterator but we do have to execute it once
						contextNode = iteratorStack[level];
						iteratorStack[level] = false;
					}
				}

				if (contextNode === false) {
					// nothing to do
				} else if (typeof contextNode === 'string') {
					out.contents.push(contextNode);
				} else if (contextNode.type === 'template') {
					// Double-brace expansion
					continuing = true;
					self.env.braceSubstitution(contextNode, self, function(replacementNode, err) {
						out.contents.push(replacementNode);
						// ... and continue on the next node!
						iteration();
					});
					return; // pause for async work...
				} else if (contextNode.type == 'tplarg') {
					// Triple-brace expansion
					continuing = true;
					self.env.argSubstitution(contextNode, self, function(replacementNode, err) {
						out.contents.push(replacementNode);
						// ... and continue on the next node!
						iteration();
					});
					return; // pause for async work...
				} else {
					if ('content' in contextNode && contextNode.content.length) {
						// Generic recursive expansion
						newIterator = contextNode;
					} else {
						// No children; push as-is.
						out.contents.push(contextNode);
					}
				}

				if (newIterator !== false) {
					outStack.push(cloneNode(newIterator));
					iteratorStack.push(newIterator);
					indexStack.push(0);
				} else if ( iteratorStack[level] === false) {
					// Return accumulated value to parent
					// With tail recursion
					while (iteratorStack[level] === false && level > 0) {
						outStack[level - 1].contents.push(out);
						outStack.pop();
						iteratorStack.pop();
						indexStack.pop();
						level--;
					}
				}
			}
			// We've reached the end of the loop!
			--expansionDepth;
			callback(outStack.pop(), null);
		};
		iteration();
	},

	implodeWithFlags: function(sep, flags) {

	},

	implode: function(sep) {

	},

	virtualImport: function(sep) {

	},

	virtualBracketedImplode: function(start, sep, end /*, ... */ ) {

	},

	isEmpty: function() {

	},

	getArguments: function() {

	},

	getNumberedArguments: function() {

	},

	getNamedArguments: function() {

	},

	getArgument: function( name ) {

	},

	loopCheck: function(title) {
	},

	isTemplate: function() {

	}

});



/**
 * @parm MWParserEnvironment env
 * @constructor
 */
MWParserTagHook = function( env ) {
	if (!env) {
		throw new Error( 'Tag hook requires a parser environment.' );
	}
	this.env = env;
};

/**
 * @param string text (or a parse tree?)
 * @param object params map of named parameters (strings or parse frames?)
 * @return either a string or a parse frame -- finalize this?
 */
MWParserTagHook.execute = function( text, params ) {
	return '';
};


MWParserFunction = function( env) {
	if (!env) {
		throw new Error( 'Parser function requires a parser environment.');
	}
	this.env = env;
};

/**
 * @param string text (or a parse tree?)
 * @param object params map of named parameters (strings or parse frames?)
 * @return either a string or a parse frame -- finalize this?
 */
MWParserFunction.execute = function( text, params ) {
	return '';
};

if (typeof module == "object") {
	module.exports.MWParserEnvironment = MWParserEnvironment;
}
