/**
 * Creates an es.DocumentModelNode object.
 * 
 * es.DocumentModelNode is a simple wrapper around es.ModelNode, which adds functionality for model
 * nodes to be used as nodes in a space partitioning tree.
 * 
 * @class
 * @constructor
 * @extends {es.ModelNode}
 * @param {Integer|Array} contents Either Length of content or array of child nodes to append
 * @property {Integer} contentLength Length of content
 */
es.DocumentModelNode = function( element, contents ) {
	// Extension
	var node = $.extend( new es.ModelNode(), this );
	
	// Observe add and remove operations to keep lengths up to date
	node.addListenerMethods( node, {
		'beforePush': 'onBeforePush',
		'beforeUnshift': 'onBeforeUnshift',
		'beforePop': 'onBeforePop',
		'beforeShift': 'onBeforeShift',
		'beforeSplice': 'onBeforeSplice'
	} );
	
	// Properties
	node.element = element || null;
	node.contentLength = 0;
	if ( typeof contents === 'number' ) {
		if ( contents < 0 ) {
			throw 'Invalid content length error. Content length can not be less than 0.';
		}
		node.contentLength = contents;
	} else if ( $.isArray( contents ) ) {
		for ( var i = 0; i < contents.length; i++ ) {
			node.push( contents[i] );
		}
	}
	
	return node;
};

/* Methods */

es.DocumentModelNode.prototype.onBeforePush = function( childModel ) {
	this.adjustContentLength( childModel.getElementLength() );
};

es.DocumentModelNode.prototype.onBeforeUnshift = function( childModel ) {
	this.adjustContentLength( childModel.getElementLength() );
};

es.DocumentModelNode.prototype.onBeforePop = function() {
	this.adjustContentLength( -this[this.length - 1].getElementLength() );
};

es.DocumentModelNode.prototype.onBeforeShift = function() {
	this.adjustContentLength( -this[0].getElementLength() );
};

es.DocumentModelNode.prototype.onBeforeSplice = function( index, howmany ) {
	var i,
		length,
		diff = 0,
		removed = this.slice( index, index + howmany ),
		added = Array.prototype.slice.call( arguments, 2 );
	for ( i = 0, length = removed.length; i < length; i++ ) {
		diff -= removed[i].getElementLength();
	}
	for ( i = 0, length = added.length; i < length;  i++ ) {
		diff += added[i].getElementLength();
	}
	this.adjustContentLength( diff );
};

/**
 * Sets the content length.
 * 
 * @method
 * @param {Integer} contentLength Length of content
 * @throws Invalid content length error if contentLength is less than 0
 */
es.DocumentModelNode.prototype.setContentLength = function( contentLength ) {
	if ( contentLength < 0 ) {
		throw 'Invalid content length error. Content length can not be less than 0.';
	}
	var diff = contentLength - this.contentLength;
	this.contentLength = contentLength;
	if ( this.parent ) {
		this.parent.adjustContentLength( diff );
	}
};

/**
 * Adjust the content length.
 * 
 * @method
 * @param {Integer} adjustment Amount to adjust content length by
 * @throws Invalid adjustment error if resulting length is less than 0
 */
es.DocumentModelNode.prototype.adjustContentLength = function( adjustment ) {
	this.contentLength += adjustment;
	// Make sure the adjustment was sane
	if ( this.contentLength < 0 ) {
		// Reverse the adjustment
		this.contentLength -= adjustment;
		// Complain about it
		throw 'Invalid adjustment error. Content length can not be less than 0.';
	}
	if ( this.parent ) {
		this.parent.adjustContentLength( adjustment );
	}
};

/**
 * Gets the content length.
 * 
 * @method
 * @returns {Integer} Length of content
 */
es.DocumentModelNode.prototype.getContentLength = function() {
	return this.contentLength;
};

/**
 * Gets the element length.
 * 
 * @method
 * @returns {Integer} Length of content
 */
es.DocumentModelNode.prototype.getElementLength = function() {
	return this.contentLength + 2;
};

/**
 * Gets the element object.
 * 
 * @method
 * @returns {Object} Element object in linear data model
 */
es.DocumentModelNode.prototype.getElement = function() {
	return this.element;
};

/**
 * Gets the content length.
 * 
 * FIXME: This method makes assumptions that a node with a data property is a DocumentModel, which
 * may be an issue if sub-classes of DocumentModelNode other than DocumentModel have a data property
 * as well. A safer way of determining this would be helpful in preventing future bugs.
 * 
 * @method
 * @param {es.Range} [range] Range of content to get
 * @returns {Integer} Length of content
 */
es.DocumentModelNode.prototype.getContent = function( range ) {
	// Find root
	var root = this.data ? this : ( this.root.data ? this.root : null );
	if ( root ) {
		return root.getContentFromNode( this, range );
	}
	return [];
};

/**
 * Gets plain text version of the content within a specific range.
 * 
 * @method
 * @param {es.Range} [range] Range of text to get
 * @returns {String} Text within given range
 */
es.DocumentModelNode.prototype.getText = function( range ) {
	var content = this.getContent( range );
	// Copy characters
	var text = '';
	for ( var i = 0, length = content.length; i < length; i++ ) {
		// If not using in IE6 or IE7 (which do not support array access for strings) use this..
		// text += this.data[i][0];
		// Otherwise use this...
		text += typeof content[i] === 'string' ? content[i] : content[i][0];
	}
	return text;
};

/**
 * Gets the range within this node that a given child node covers.
 * 
 * @method
 * @param {es.ModelNode} node
 */
es.DocumentModelNode.prototype.getRangeFromNode = function( node ) {
	if ( this.length ) {
		var i = 0,
			length = this.length,
			left = 0;
		while ( i < length ) {
			if ( this[i] === node ) {
				return new es.Range( left, left + this[i].getElementLength() );
			}
			left += this[i].getElementLength() + 1;
			i++;
		}
	}
	return null;
};

/**
 * Gets the first offset within this node of a given child node.
 * 
 * @method
 * @param {es.ModelNode} node
 */
es.DocumentModelNode.prototype.getOffsetFromNode = function( node ) {
	if ( this.length ) {
		var offset = 0;
		for( var i = 0; i < this.length; i++ ) {
			if ( this[i] === node ) {
				return offset;
			}
			offset += this[i].getElementLength() + 1;
		}
	}
	return null;
};

/**
 * Gets the node which a given offset is within.
 * 
 * @method
 * @param {Integer} offset
 */
es.DocumentModelNode.prototype.getNodeFromOffset = function( offset ) {
	if ( this.length ) {
		var i = 0,
			length = this.length,
			left = 0,
			right;
		while ( i < length ) {
			right = left + this[i].getElementLength() + 1;
			if ( offset >= left && offset < right ) {
				return this[i];
			}
			left = right;
			i++;
		}
	}
	return null;
};

/**
 * Gets a list of nodes and their sub-ranges which are covered by a given range.
 * 
 * @method
 * @param {es.Range} range Range to select nodes within
 * @param {Boolean} [off] Whether to include a list of nodes that are not covered by the range
 * @returns {Object} Object with 'on' and 'off' properties, 'on' being a list of objects with 'node'
 * and 'range' properties describing nodes which are covered by the range and the range within the
 * node that is covered, and 'off' being a list of nodes that are not covered by the range
 */
es.DocumentModelNode.prototype.selectNodes = function( range, off ) {
	range.normalize();
	var	result = { 'on': [], 'off': [] };
	for ( var i = 0, length = this.length, left = 0, right; i < length; i++ ) {
		right = left + this[i].getElementLength() + 1;
		if ( range.start >= left && range.start < right ) {
			if ( range.end < right ) {
				result.on.push( {
					'node': this[i],
					'range': new es.Range( range.start - left, range.end - left )
				} );
				if ( !off ) {
					break;
				}
			} else {
				result.on.push( {
					'node': this[i],
					'range': new es.Range( range.start - left, right - left - 1 )
				} );	
			}
		} else if ( range.end >= left && range.end < right ) {
			result.on.push( {
				'node': this[i],
				'range': new es.Range( 0, range.end - left )
			} );
			if ( !off ) {
				break;
			}
		} else if ( left >= range.start && right <= range.end ) {
			result.on.push( {
				'node': this[i],
				'range': new es.Range( 0, right - left - 1 )
			} );
		} else if( off ) {
			result.off.push( this[i] );
		}
		left = right;
	}
	return result;
};
