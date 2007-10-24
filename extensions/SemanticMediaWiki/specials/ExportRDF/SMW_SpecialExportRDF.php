<?php
/**
 * @author Markus Krötzsch
 * @author Denny Vrandecic
 *
 * This special page for MediaWiki implements an RDF-export of
 * semantic data, gathered both from the annotations in articles,
 * and from metadata already present in the database.
 */

if (!defined('MEDIAWIKI')) die();


function smwfDoSpecialExportRDF($page = '') {
	global $wgOut, $wgRequest, $wgUser, $smwgAllowRecursiveExport, $smwgExportBacklinks, $smwgExportAll;

	$recursive = 0;  //default, no recursion
	$backlinks = $smwgExportBacklinks; //default

	// check whether we already know what to export //

	if ($page=='') { //try to get GET parameter; simple way of calling the export
		$page = $wgRequest->getVal( 'page' );
	} else {
		//this is needed since MediaWiki 1.8, but it is wrong for 1.7
		$page = urldecode($page);
	}

	if ($page=='') { //try to get POST list; some settings are only available via POST
		$pageblob = $wgRequest->getText( 'pages' );
		if ('' != $pageblob) {
			$pages = explode( "\n", $pageblob );
		}
	} else {
		$pages = array($page);
	}

	if( isset($pages) ) {  // export to RDF
		$wgOut->disable();
		ob_start();

		// Only use rdf+xml mimetype if explicitly requested
		// TODO: should the see also links in the exported RDF then have this parameter as well?
		if ( $wgRequest->getVal( 'xmlmime' )=='rdf' ) {
			header( "Content-type: application/rdf+xml; charset=UTF-8" );
		} else {
			header( "Content-type: application/xml; charset=UTF-8" );
		}

		if ( $wgRequest->getText( 'postform' ) == 1 ) {
			$postform = true; //effect: assume "no" from missing parameters generated by checkboxes
		} else $postform = false;

		$rec = $wgRequest->getText( 'recursive' );
		if ('' == $rec) $rec = $wgRequest->getVal( 'recursive' );
		if ( ($rec == '1') && ($smwgAllowRecursiveExport || $wgUser->isAllowed('delete')) ) {
			$recursive = 1; //users may be allowed to switch it on
		}
		$bl = $wgRequest->getText( 'backlinks' );
		if ('' == $bl) $bl = $wgRequest->getVal( 'backlinks' );
		if (($bl == '1') && ($wgUser->isAllowed('delete'))) {
			$backlinks = true; //admins can always switch on backlinks
		} elseif ( ($bl == '0') || ( '' == $bl && $postform) ) {
			$backlinks = false; //everybody can explicitly switch off backlinks
		}
		$date = $wgRequest->getText( 'date' );
		if ('' == $date) $date = $wgRequest->getVal( 'date' );

		$exRDF = new ExportRDF();
		if ('' !== $date) $exRDF->setDate($date);
		$exRDF->printPages($pages,$recursive,$backlinks);
		return;
	}

	// nothing exported yet; show user interface:
	$html = '<form name="tripleSearch" action="" method="POST">' . "\n" .
	        wfMsg('smw_exportrdf_docu') . "\n" .
	        '<input type="hidden" name="postform" value="1"/>' . "\n" .
	        '<textarea name="pages" cols="40" rows="10"></textarea><br />' . "\n";
	if ( $wgUser->isAllowed('delete') || $smwgAllowRecursiveExport) {
		$html .= '<input type="checkbox" name="recursive" value="1" id="rec">&nbsp;<label for="rec">' . wfMsg('smw_exportrdf_recursive') . '</label></input><br />' . "\n";
	}
	if ( $wgUser->isAllowed('delete') || $smwgExportBacklinks) {
		$html .= '<input type="checkbox" name="backlinks" value="1" default="true" id="bl">&nbsp;<label for="bl">' . wfMsg('smw_exportrdf_backlinks') . '</label></input><br />' . "\n";
	}
	if ( $wgUser->isAllowed('delete') || $smwgExportAll) {
		$html .= '<br />';
		$html .= '<input type="text" name="date" value="'.date(DATE_W3C, mktime(0, 0, 0, 1, 1, 2000)).'" id="date">&nbsp;<label for="ea">' . wfMsg('smw_exportrdf_lastdate') . '</label></input><br />' . "\n";
	}
	$html .= "<br /><input type=\"submit\"/>\n</form>";
	$wgOut->addHTML($html);
}


/**
 * Data class for holding all (special) data needed to export an articles
 * subject. Keeps data needed to generate type and URIs, as well as other
 * special property values.
 */
class SMWExportTitle {
	//@TODO: some of those members can be made local

	// Values for special properties, see SMW_Settings.php for documentation.
	// Each value may be missing if not set or not relevant
	public $has_type = false; // (nonempty) type-ID or false
	public $has_uri = false; // TODO not used right now
	public $ext_nsid = false;
	public $ext_section = false;
	// relevant title values, mandatory
	public $title;
	public $title_text;
	public $title_namespace;
	public $title_id;
	public $title_fragment;
	public $title_prefurl;
	public $title_dbkey;
	public $modifier = '';
	public $value; // the title as a datavalue
	// details about URIs for export
	public $ns_uri = false;
	public $short_uri;
	public $long_uri;
	public $label;
	// key for hashing
	public $hashkey;
	// flags for controlling export
	public $is_individual;
	public $exists;

	/**
	 * Initialise the data for a given article title object, using the
	 * provided DB handler.
	 */
	public function SMWExportTitle($title, $export, $modifier = '') {
		$this->title = $title;
		$this->title_text = $title->getText();
		$this->title_id = $title->getArticleID();
		$this->title_namespace = $title->getNamespace();
		$this->title_fragment = $title->getFragment();
		$this->title_prefurl = $title->getPrefixedURL();
		$this->title_dbkey = $title->getDBKey();
		$this->value = 	SMWDataValueFactory::newTypeIDValue('_wpg', $title->getPrefixedText());
		$this->hashkey = $this->title_prefurl . ' ' . $modifier; // must agree with keys generated elsewhere in this code!
		$this->modifier = $modifier;
		if ($modifier != '') $modifier = '#' . $modifier;

		$this->is_individual = ( ($this->title_namespace !== SMW_NS_PROPERTY) && ($this->title_namespace !== NS_CATEGORY) );
		$this->exists = $title->exists();

		if ($this->exists) {
			if ($title->getNamespace() == SMW_NS_PROPERTY) {
				$a = $export->store->getSpecialValues( $title, SMW_SP_HAS_TYPE );
				if (count($a)>0) {
					if ($a[0]->isUnary()) {
						$this->has_type = $a[0]->getXSDValue();
					} else {
						$this->has_type = '__nry';
					}
				}
			}
			$a = $export->store->getSpecialValues( $title, SMW_SP_EXT_BASEURI );
			if (count($a)>0) $this->ns_uri = $a[0];
			$a = $export->store->getSpecialValues( $title, SMW_SP_EXT_NSID );
			if (count($a)>0) $this->ext_nsid = $a[0];
			$a = $export->store->getSpecialValues( $title, SMW_SP_EXT_SECTION );
			if (count($a)>0) $this->ext_section = $a[0];
		}

		// Calculate URIs and label
		global $wgContLang;
		$ns_text = $wgContLang->getNsText($this->title_namespace);
		if ($ns_text!='') {
			$ns_text .= ':';
		}

		if ($this->ns_uri === false) { //no external URI
			$this->ns_uri = ExportRDF::makeXMLExportId(urlencode(str_replace(' ', '_', $ns_text)));
			$baseXML = ExportRDF::makeXMLExportId(urlencode(str_replace(' ', '_', $this->title_text . $modifier)));
			switch ($this->title_namespace) {
				case SMW_NS_PROPERTY:
					$xmlprefix = 'property:';
					$xmlent = '&property;';
					break;
				default:
					$xmlprefix = 'wiki:';
					$xmlent = '&wiki;';
					$baseXML = $this->ns_uri . $baseXML;
					$this->ns_uri = '';
					break;
			}
			$this->long_uri = $xmlent . $baseXML;
			if (in_array(mb_substr($baseXML,0,1), array('-','0','1','2','3','4','5','6','7','8','9'))) { // illegal as first char in XML
				$this->short_uri = 'wiki:' . $this->ns_uri . $baseXML;
			} else {
				$this->short_uri = $xmlprefix . $baseXML;
			}
		} else { // external URI known
			$this->long_uri = $this->ns_uri . $this->ext_section;
			$this->short_uri = $this->ext_nsid . ':' . $this->ext_section;
		}
		if ($this->is_individual) {
			$this->label = $ns_text . $this->title_text;
		} else {
			$this->label = $this->title_text;
		}
		//$this->label = $this->title_text; // we show the namespace prefixes in most specials in our wiki, so this should also be done by external (re)users (mak)
		//TODO: should we make an exception for schema elements (Category, Attriubte, ...) where the prefix is clear from the context? At least namespaces like User: seem to be essential for understanding.
		if ($this->modifier != '') $this->label .= " ($this->modifier)";
		$this->label = smwfXMLContentEncode($this->label);
	}
}

/**
 * Class for encapsulating the methods for RDF export.
 */
class ExportRDF {
	/**#@+
	 * @access private
	 */

	const MAX_CACHE_SIZE = 5000; // do not let cache arrays get larger than this
	const CACHE_BACKJUMP = 500;  // kill this many cached entries if limit is reached,
	                             // avoids too much array copying; <= MAX_CACHE_SIZE!

	/**
	 * The basic namespace for articles in this wiki (computed on creation).
	 * Version suitable for URLs.
	 */
	private $wiki_xmlns_url;

	/**
	 * The basic namespace for topics talked about in this wiki (computed on creation).
	 * Version suitable for XML identifiers.
	 */
	private $wiki_xmlns_xml;

	/**
	 * An array that keeps track of the elements for which we still need to
	 * write auxilliary definitions.
	 */
	private $element_queue;

	/**
	 * An array that keeps track of the elements which have been exported already
	 */
	private $element_done;

	/**
	 * URL of this special page
	 */
	private $special_url;

	/**
	 * Store handler -- needed multiple times, so "cache" it
	 */
	var $store;

	/**
	 * Date used to filter the export. If a page has not been changed since that
	 * date it will not be exported
	 */
	private $date;

	/**
	 * Array of additional namespaces (abbreviation => URI), flushed on
	 * closing the current namespace tag. Since we export RDF in a streamed
	 * way, it is not always possible to embed additional namespaces into
	 * the RDF-tag which might have been sent to the client already. But we
	 * wait with printing the current Description so that extra namespaces
	 * from this array can still be printed (note that you never know which
	 * extra namespaces you encounter during export).
	 */
	private $extra_namespaces;

	/**
	 * Array of namespaces that have been declared globally already. Contains
	 * entries of format 'namespace abbreviation' => true, assuming that the
	 * same abbreviation always refers to the same URI (i.e. you cannot import
	 * something as rdf:bla if you do not want rdf to be the standard
	 * namespace that is already given in every RDF export).
	 */
	private $global_namespaces;
	
	/**
	 * Array of references to the SWIVT schema. Will be added at the end of the
	 * export.
	 */
	private $schema_refs;

	/**
	 * Unprinted XML is composed from the strings $pre_ns_buffer and $post_ns_buffer.
	 * The split between the two is such that one can append additional namespace
	 * declarations to $pre_ns_buffer so that they affect all current elements. The
	 * buffers are flushed during output in order to achieve "streaming" RDF export
	 * for larger files.
	 */
	private $pre_ns_buffer;

	/**
	 * See documentation for ExportRDF::pre_ns_buffer.
	 */
	private $post_ns_buffer;

	/**
	 * Boolean that is true as long as nothing was flushed yet. Indicates that
	 * extra namespaces can still become global.
	 */
	private $first_flush;

	/**
	 * Integer that counts down the number of objects we still process before
	 * doing the first flush. Aggregating some output before flushing is useful
	 * to get more namespaces global. Flushing will only happen if $delay_flush
	 * is 0.
	 */
	private $delay_flush;
	
	/**
	 * Boolean. If true, the export will be in OWL Full, i.e. it will also
	 * icnlude properties of other properties and of classes, etc.
	 */
	var $owlfull;

	/**
	 * Constructor.
	 */
	public function ExportRDF() {
		global $wgServer;   // actual server address (with http://)
		global $wgScript;   // "/subdirectory/of/wiki/index.php"
		global $wgArticlePath;
		$this->wiki_xmlns_url = $wgServer . str_replace('$1', '', $wgArticlePath);
		global $smwgNamespace; // complete namespace for URIs (with protocol, usually http://)
		if (''==$smwgNamespace) {
			$resolver = Title::makeTitle( NS_SPECIAL, 'URIResolver');
			$smwgNamespace = $resolver->getFullURL() . '/';
		}
		if ($smwgNamespace[0] == '.') {
			$resolver = Title::makeTitle( NS_SPECIAL, 'URIResolver');
			$smwgNamespace = "http://" . mb_substr($smwgNamespace, 1) . $resolver->getLocalURL() . '/';
		}
		$this->wiki_xmlns_xml = $smwgNamespace;
		global $smwgOWLFullExport;
		$this->owlfull = $smwgOWLFullExport; // by default listen to the setting

		$title = Title::makeTitle( NS_SPECIAL, 'ExportRDF' );
		$this->special_url = '&wikiurl;' . $title->getPrefixedURL();

		$this->element_queue = array();
		$this->element_done = array();
		$this->schema_refs = array();
		$this->date = '';
	}

	/**
	 * Sets a date as a filter. Any page that has not been changed since that date
	 * will not be exported. The date has to be a string in XSD format.
	 */
	public function setDate($date) {
		$timeint = strtotime($date);
		$stamp = date("YmdHis", $timeint);
		$this->date = $stamp;
	}

	/**
	 * This function prints all selected pages. The parameter $recursion determines
	 * how referenced ressources are treated:
	 * '0' : add brief declarations for each
	 * '1' : add full descriptions for each, thus beginning real recursion (and
	 *       probably retrieving the whole wiki ...)
	 * else: ignore them, though -1 might become a synonym for "export *all*" in the future
	 * The parameter $backlinks determines whether or not subjects of incoming
	 * properties are exported as well. Enables "browsable RDF."
	 */
	public function printPages($pages, $recursion = 1, $backlinks = true) {
		$this->store = &smwfGetStore();
		$this->pre_ns_buffer = '';
		$this->post_ns_buffer = '';
		$this->first_flush = true;
		$this->delay_flush = 10; //flush only after (fully) printing 11 objects
		$this->extra_namespaces = array();
		$this->printHeader(); // also inits global namespaces
		$linkCache =& LinkCache::singleton();

		// transform pages into queued export titles
		$cur_queue = array();
		foreach ($pages as $page) {
			$title = Title::newFromText($page);
			if (NULL === $title) continue; //invalid title name given
			$et = new SMWExportTitle($title, $this);
			$cur_queue[$title->getPrefixedURL() . ' '] = $et; // " " is the modifier separator
		}

		while (count($cur_queue) > 0) {
			// first, print all selected pages
			foreach ( $cur_queue as $et) {
				$this->printTriples($et);
				$this->markAsDone($et);

				// prepare array for next iteration
				$cur_queue = array();
				if (1 == $recursion) {
					$cur_queue = $this->element_queue + $cur_queue; // make sure the array is *dublicated* instead of copying its ref
					$this->element_queue = array();
				}
				// possibly add backlinks
				if ($backlinks === true) {
					$inRels = $this->store->getInProperties( $et->value );
					foreach ($inRels as $inRel) {
						$inSubs = $this->store->getPropertySubjects( $inRel, $et->value );
						foreach($inSubs as $inSub) {
							$st = $this->getExportTitleFromTitle( $inSub );
							if (!array_key_exists($st->hashkey, $this->element_done)) {
								$cur_queue[] = $st;
							}
						}
					}
					if ( NS_CATEGORY === $et->title_namespace ) { // also print elements of categories
						$instances = $this->store->getSpecialSubjects( SMW_SP_HAS_CATEGORY, $et->title );
						foreach($instances as $instance) {
							$st = $this->getExportTitleFromTitle( $instance );
							if (!array_key_exists($st->hashkey, $this->element_done)) {
								$cur_queue[] = $st;
							}
						}
					}
					if ( 0 == $recursion ) $backlinks = false; // do not recurse through backlinks either
				}
				if ($this->delay_flush > 0) $this->delay_flush--;
			}
			$linkCache->clear();
		}

		// if pages are not processed recursively, print mentioned declarations
		if (!empty($this->element_queue)) {
			if ( '' != $this->pre_ns_buffer ) {
				$this->post_ns_buffer .= "\t<!-- auxilliary definitions -->\n";
			} else {
				print "\t<!-- auxilliary definitions -->\n"; // just print this comment, so that later outputs still find the empty pre_ns_buffer!
			}
			while (!empty($this->element_queue)) {
				$et = array_pop($this->element_queue);
				$this->printTriples($et,false);
			}
		}

		$this->printFooter();
		$this->flushBuffers(true);
	}

	/**
	 * This function prints RDF for *all* pages within the wiki, and for all
	 * elements that are referred to in the exported RDF.
	 */
	public function printAll($outfile, $ns_restriction = false) {
		global $smwgNamespacesWithSemanticLinks;
		$linkCache =& LinkCache::singleton();

		$db = & wfGetDB( DB_MASTER );
		$this->store = & smwfGetStore();
		$this->pre_ns_buffer = '';
		$this->post_ns_buffer = '';
		$this->first_flush = true;
		if ( $outfile === false ) {
			//$this->delay_flush = 10000; //flush only after (fully) printing 10001 objects,
			$this->delay_flush = -1; // do not flush buffer at all
		} else {
			$file = fopen($outfile, 'w');
			if (!$file) {
				print "\nCannot open \"$outfile\" for writing.\n";
				return false;
			}
			print "\nWriting RDF dump to file \"$outfile\" ...\n";
			$this->delay_flush = -1; // never flush, we flush in another way
		}
		$this->extra_namespaces = array();
		$this->printHeader(); // also inits global namespaces

		$start = 1;
		$end = $db->selectField( 'page', 'max(page_id)', false, $outfile );

		$a_count = 0; $d_count = 0; //DEBUG

		for ($id = $start; $id <= $end; $id++) {
			$title = Title::newFromID($id);
			if ( ($title === NULL) || !smwfIsSemanticsProcessed($title->getNamespace()) ) continue;
			if ( !ExportRDF::fitsNsRestriction($ns_restriction, $title->getNamespace()) ) continue;
			$cur_queue = array(new SMWExportTitle($title, $this));
			$a_count++; //DEBUG
			$full_export = true;
			while (count($cur_queue) > 0) {
				foreach ( $cur_queue as $et) {
					$this->printTriples($et, $full_export);
					$this->markAsDone($et);
				}
				$full_export = false; // make sure added dependencies do not pull more than needed
				// resolve dependencies that will otherwise not be printed
				$cur_queue = array();
				foreach ($this->element_queue as $key => $etq) {
					if ( (!$etq->exists) || !smwfIsSemanticsProcessed($etq->title_namespace) ||
					      !ExportRDF::fitsNsRestriction($ns_restriction, $etq->title_namespace) ||
					      $etq->modifier !== '') {
					// Note: we do not need to check the cache to guess if an element was already
					// printed. If so, it would not be included in the queue in the first place.
						$cur_queue[] = $etq;
						//$this->post_ns_buffer .= "<!-- Adding dependency '" . $etq->label . "' -->"; //DEBUG
						$d_count++; //DEBUG
					} else {
						unset($this->element_queue[$key]); // carrying around the values we do not
						                                   // want to export now is a potential memory leak
					}
				}
			}
			if ($outfile !== false) { // flush buffer
				fwrite($file, $this->post_ns_buffer);
				$this->post_ns_buffer = '';
			}
			$linkCache->clear();
		}
		//DEBUG:
		$this->post_ns_buffer .= "<!-- Processed $a_count regular articles. -->\n";
		$this->post_ns_buffer .= "<!-- Processed $d_count added dependencies. -->\n";
		$this->post_ns_buffer .= "<!-- Final cache size was " . sizeof($this->element_done) . ". -->\n";

		$this->printFooter();

		if ($outfile === false) {
			$this->flushBuffers(true);
		} else { // prepend headers to file, there is no really efficient solution (`cat(1)`) for this it seems
			// print head:
			fclose($file);
			foreach ($this->extra_namespaces as $nsshort => $nsuri) {
				 $this->pre_ns_buffer .= "\n\txmlns:$nsshort=\"$nsuri\"";
			}
			$full_export = file_get_contents($outfile);
			$full_export = $this->pre_ns_buffer . $full_export . $this->post_ns_buffer;
			$file = fopen($outfile, 'w');
			fwrite($file, $full_export);
			fclose($file);
		}
	}


	/* Functions for exporting RDF */

	private function printHeader() {
		global $wgContLang;

		$this->pre_ns_buffer .=
			"<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" .
			"<!DOCTYPE rdf:RDF[\n" .
			"\t<!ENTITY rdf 'http://www.w3.org/1999/02/22-rdf-syntax-ns#'>\n" .
			"\t<!ENTITY rdfs 'http://www.w3.org/2000/01/rdf-schema#'>\n" .
			"\t<!ENTITY owl 'http://www.w3.org/2002/07/owl#'>\n" .
			"\t<!ENTITY swivt 'http://semantic-mediawiki.org/swivt/1.0#'>\n" .
			// A note on "wiki": this namespace is crucial as a fallback when it would be illegal to start e.g. with a number. In this case, one can always use wiki:... followed by "_" and possibly some namespace, since _ is legal as a first character.
			"\t<!ENTITY wiki '" . $this->wiki_xmlns_xml .  "'>\n" .
			"\t<!ENTITY property '" . $this->wiki_xmlns_xml .
			$this->makeXMLExportId(urlencode(str_replace(' ', '_', $wgContLang->getNsText(SMW_NS_PROPERTY) . ':'))) .  "'>\n" .
			"\t<!ENTITY wikiurl '" . $this->wiki_xmlns_url .  "'>\n" .
			"]>\n\n" .
			"<rdf:RDF\n" .
			"\txmlns:rdf=\"&rdf;\"\n" .
			"\txmlns:rdfs=\"&rdfs;\"\n" .
			"\txmlns:owl =\"&owl;\"\n" .
			"\txmlns:swivt=\"&swivt;\"\n" .
			"\txmlns:wiki=\"&wiki;\"\n" .
			"\txmlns:property=\"&property;\"";
		$this->global_namespaces = array('rdf'=>true, 'rdfs'=>true, 'owl'=>true, 'swivt'=>true, 'wiki'=>true, 'property'=>true);

		$this->post_ns_buffer .=
			">\n\t<!-- Ontology header -->\n" .
			"\t<owl:Ontology rdf:about=\"\">\n" .
			"\t\t<swivt:creationDate rdf:datatype=\"http://www.w3.org/2001/XMLSchema#dateTime\">" . date(DATE_W3C) . "</swivt:creationDate>\n" .
			"\t\t<owl:imports rdf:resource=\"http://semantic-mediawiki.org/swivt/1.0\" />\n" .
			"\t</owl:Ontology>\n" .
			"\t<!-- exported page data -->\n";
		$this->addSchemaRef( "page", "owl:AnnotationProperty" );
		$this->addSchemaRef( "creationDate", "owl:AnnotationProperty" );
		$this->addSchemaRef( "Subject", "owl:Class" );
	}

	/**
	 * Prints the footer. Prints also all open schema-references.
	 * No schema-references can be added after printing the footer.
	 */
	private function printFooter() {
		$this->post_ns_buffer .= "\t<!-- reference to the Semantic MediaWiki schema -->\n";
		foreach (array_keys($this->schema_refs) as $name) {
			$type = $this->schema_refs[$name];			
			$this->post_ns_buffer .=
				"\t<$type rdf:about=\"&swivt;$name\">\n" .
				"\t\t<rdfs:isDefinedBy rdf:resource=\"http://semantic-mediawiki.org/swivt/1.0\"/>\n" .
				"\t</$type>\n";				
		}
		$this->post_ns_buffer .= "\t<!-- Created with Semantic MediaWiki, http://semantic-mediawiki.org -->\n";
		$this->post_ns_buffer .= '</rdf:RDF>';
	}
	
	/**
	 * Adds a reference to the SWIVT schema. This will make sure that at the end of the page,
	 * all required schema references will be defined and point to the appropriate ontology.
	 *
	 * @param string $name The fragmend identifier of the entity to be referenced.
	 *                     The SWIVT namespace is added. 
	 * @param string $type The type of the referenced identifier, i.e. is it an annotation
	 *                     property, an object property, a class, etc. Should be given as a QName
	 *                     (i.e. in the form "owl:Class", etc.)
	 */
	public function addSchemaRef( $name,  $type ) {
		if (!array_key_exists($name, $this->schema_refs))
			$this->schema_refs[$name] = $type;
	}
	
	/**
	 * Adds a page to the queue of pages to be exported
	 *
	 * @param Title $title The page to be exported
	 * @param boolean $fullexport If true, the export will export this page fully.
	 *                            If false, the export will decide by itself.
	 * @return nothing
	 */
	public function addPage( Title $title, $fullexport=false ) {
		$this->element_queue[] = $this->getExportTitleFromTitle( $title );
	}

	/**
	 * Printe the triples associated to a specific page, and references those needed.
	 * They get printed in the printFooter-function.
	 *
	 * @param SMWExportTitle $et The Exporttitle wrapping the page to be exported
	 * @param boolean $fullexport If all the triples of the page should be exported, or just
	 *                            a definition of the given title.
	 * $return nothing
	 */
	private function printTriples(SMWExportTitle $et, $fullexport=true) {
		// if this was already exported, don't do it again
		if (array_key_exists($et->hashkey, $this->element_done)) return;
		// return if younger than the filtered date
		if ($et->exists && ($this->date !== '')) {
			$rev = Revision::getTimeStampFromID($et->title->getLatestRevID());
			if ($rev < $this->date) return;
		}

		$datatype_rel = false;
		$category_rel = false;
		$equality_rel = false;
		$subprop_rel = false;
		// Set parameters for export
		switch ($et->title_namespace) {
			case SMW_NS_PROPERTY:
				$equality_rel = "owl:equivalentProperty";
				$subprop_rel = "rdfs:subPropertyOf";

				switch ($et->has_type) {
					case '': case '_wpg': case '_uri': case '_ema': case '__nry':
						$type = 'owl:ObjectProperty';
					break;
					case '_anu':
						$type = 'owl:AnnotationProperty';
						$equality_rel = false; // disabled for annotations
						$subprop_rel = false; // disabled for annotations
					break;
					default:
						$type = 'owl:DatatypeProperty';
					break;
				}
				if ($this->owlfull) $category_rel = "rdf:type";
				break;
			case NS_CATEGORY:
				$type = 'owl:Class';
				$category_rel = "rdfs:subClassOf";
				$equality_rel = "owl:equivalentClass";
				break;
			default:
				$type = 'swivt:Subject';
				$category_rel = "rdf:type";
				$equality_rel = "owl:sameAs";
				break;
		}

		// Write export
		if ('' == $this->pre_ns_buffer) { // start new ns block
			$this->pre_ns_buffer .= "\t<$type rdf:about=\"" . $et->long_uri . "\"";
		} else {
			$this->post_ns_buffer .= "\t<$type rdf:about=\"" . $et->long_uri . "\"";
		}
		$this->post_ns_buffer .= ">\n" .
		      "\t\t<rdfs:label>" . $et->label . "</rdfs:label>\n" .
		      "\t\t<swivt:page rdf:resource=\"&wikiurl;" .
		              $et->title_prefurl . "\"/>\n" .
		      "\t\t<rdfs:isDefinedBy rdf:resource=\"" .
		              $this->special_url . '/' . $et->title_prefurl . "\"/>\n";
		// If the property is modified by a unit, export the modifier
		// and the base relation explicitly
		if ( $et->has_type && $et->modifier ) {
			$this->post_ns_buffer .= "\t\t<swivt:modifier rdf:datatype=\"http://www.w3.org/2001/XMLSchema#string\">" .
				smwfXMLContentEncode($et->modifier) .
				"</swivt:modifier>\n";
			$baseprop = $this->getExportTitle($et->title_text, SMW_NS_PROPERTY);
			$this->post_ns_buffer .= "\t\t<swivt:baseProperty rdf:resource=\"" . $baseprop->long_uri . "\"/>\n";
			if (!array_key_exists($baseprop->hashkey, $this->element_queue)) {
				$this->element_queue[$baseprop->hashkey] = $baseprop;
			}
			$this->addSchemaRef( "baseProperty", "owl:AnnotationProperty" );
			$this->addSchemaRef( "modifier", "owl:AnnotationProperty" );
		}

		if ( ($fullexport) && ($et->exists) ) {
			// add statements about categories
			if ($category_rel) {
				$cats = $this->store->getSpecialValues( $et->title, SMW_SP_HAS_CATEGORY );
				foreach ($cats as $cat) {
					$ct = $this->getExportTitleFromTitle( $cat->getTitle() );
					$this->post_ns_buffer .= "\t\t<" . $category_rel . ' rdf:resource="' . $ct->long_uri .  "\"/>\n";
				}
			}

			// TODO: this is not convincing, esp. now that we have custom types
//			if (isset($datatype_handler)) {
//				$this->post_ns_buffer .= "\t\t<swivt:type " . 'rdf:resource="&??;' . $datatype_handler->getID() . "\"/>\n";
//				$this->addSchemaRef( "type", "owl:AnnotationProperty" );
//			}

			// add statements about equivalence to (external) URIs
			// FIXME: temporarily disabled
// 			if ($equality_rel) {
// 				$equalities = smwfGetSpecialPropertyValues($title,SMW_SP_HAS_URI);
// 				$fragment = $title->getFragment();
// 				if( '' != $fragment ) {
// 					$fragment = '#' . $fragment;
// 				}
// 				foreach ($equalities as $equality) {
// 					$this->post_ns_buffer .= "\t\t<" . $equality_rel . ' rdf:resource="' . $equality . $fragment .  "\"/>\n";
// 				}
// 			}

			// add rdfs:subPropertyOf statements
 			if ($subprop_rel) {
				$properties = $this->store->getSpecialValues($et->title, SMW_SP_SUBPROPERTY_OF);
 				foreach ($properties as $property) {
 					// TODO in future, check type safety relations <-> attributes
 					// TODO check also the type of what I am pointing to (is it an atrribute or sth else?)
 					// TODO check the type of the attribute pointed to, does it match?
 					// Could lead to inconsistencies in the output -- and in the wiki? But this will
 					// need to be dealt with as soon as people add subattribute semantics to the wiki
 					$supprop = $this->getExportTitleFromTitle($property, SMW_NS_PROPERTY);
 					$this->post_ns_buffer .= "\t\t<$subprop_rel rdf:resource=\"" . $supprop->long_uri . "\"/>\n";
 					if (!array_key_exists($supprop->hashkey, $this->element_queue)) {
 							$this->element_queue[$supprop->hashkey] = $supprop;
 					}
 				}
 			}

 			// print relations for schema elements only if we are explictly set to OWL Full
			if ($et->is_individual || $this->owlfull) {
				// print all relations
				$props = $this->store->getProperties( $et->title );
				foreach ( $props as $prop ) {
					$values = $this->store->getPropertyValues( $et->title, $prop );
					foreach ( $values as $value ) {
						$pt = $this->getExportTitleFromTitle( $prop, $value->getUnit() );
						$this-> post_ns_buffer .= $value->exportToRDF( $pt->short_uri, $this );
						// TODO check OWL Fullness in Wikipage
					}
				}
			}
		}

		$this->post_ns_buffer .= "\t</" . $type . ">\n";
		$this->flushBuffers();
	}

	/**
	 * Flush all buffers and extra namespaces by printing them to stdout and flushing
	 * the output buffers afterwards.
	 *
	 * @param force if true, the flush cannot be delayed any longer
	 */
	private function flushBuffers($force = false) {
		if ( '' == $this->post_ns_buffer ) return; // nothing to flush (every non-empty pre_ns_buffer also requires a non-empty post_ns_buffer)
		if ( (0 != $this->delay_flush) && !$force ) return; // wait a little longer

		print $this->pre_ns_buffer;
		$this->pre_ns_buffer = '';
		foreach ($this->extra_namespaces as $nsshort => $nsuri) {
			if ($this->first_flush) {
				$this->global_namespaces[$nsshort] = true;
				print "\n\t";
			} else print ' ';
			print "xmlns:$nsshort=\"$nsuri\"";
		}
		$this->extra_namespaces = array();
		print $this->post_ns_buffer;
		$this->post_ns_buffer = '';
		// Ship data in small chunks (even though browsers often do not display anything
		// before the file is complete -- this might be due to syntax highlighting features
		// for app/xml). You may want to sleep(1) here for debugging this.
		ob_flush();
		flush();
		$this->first_flush = false;
	}

	/**
	 * Add an extra namespace that was encountered during output. The method
	 * checks whether the required namespace is available globally and adds
	 * it to the list of extra_namesapce otherwise.
	 */
	public function addExtraNamespace($nsshort,$nsuri) {
		if (!array_key_exists($nsshort,$this->global_namespaces)) {
			$this->extra_namespaces[$nsshort] = $nsuri;
		}
	}
	
	/**
	 * Returns the exportable QName of a page.
	 */
	public function getQName(Title $title, $unit = '') {
		$et = $this->getExportTitleFromTitle( $title, $unit );
		return $et->long_uri;
	}

	/**
	 * Returns the exportable URL of a page.
	 */
	public function getURI(Title $title, $unit = '') {
		$et = $this->getExportTitleFromTitle( $title, $unit );
		return $et->long_uri;
	}

	/** Fetch SMWExportTitle for a given article. The inputs are
	 * $text -- standard text form of the main part of the article name
	 *          (no namespace, no urlencode)
	 * $namespace -- the namespace constant
	 */
	private function getExportTitle($text, $namespace, $modifier = '') {
		$title = Title::newFromText($text, $namespace);
		if ($title === NULL) {
			$this->post_ns_buffer .= "<!-- Error: \"NS$namespace:$text\" is not a valid article. -->\n";
			return NULL; // FIXME: return something that does not crash the export
			// returning this to an unprepared caller is not elegant, but better than crashing; the situation only can occur when the semantic tables are inconsistent with the wiki
		}
		return $this->getExportTitleFromTitle($title, $modifier);
	}

	/**
	 * Fetch SMWExportTitle for a given article that is identified by its
	 * article id.
	 */
	private function getExportTitleFromID($id, $modifier = '') {
		$title = Title::newFromID($id);
		if ($title === NULL) {
			$this->post_ns_buffer .= "<!-- Error: there is no valid article with ID $id. -->\n";
			return NULL; // FIXME: return something that does not crash the export
			// returning this to an unprepared caller is not elegant, but better than crashing; the situation only can occur when the semantic tables are inconsistent with the wiki
		}
		return $this->getExportTitleFromTitle($title, $modifier);
	}


	/**
	 * Fetch SMWExportTitle for a given article. Caches are used to
	 * makes this process more efficient. The title-object is needed to
	 * have a normalised key for looking up the caches, and to create
	 * new SMWExportTitles.
	 */
	private function getExportTitleFromTitle(Title $title, $modifier = '') {
		$key = $title->getPrefixedURL() . ' ' . $modifier;
		if (array_key_exists($key, $this->element_done)) {
			$result = $this->element_done[$key];
		} elseif (array_key_exists($key, $this->element_queue)) {
			$result = $this->element_queue[$key];
		} else {
			$result = new SMWExportTitle($title, $this, $modifier);
			$this->element_queue[$key] = $result; // queue element
		}
		// make sure that extra namespace is added in the current flush, if needed:
		if ($result->ext_nsid !== false) {
			$this->addExtraNamespace($result->ext_nsid, $result->ns_uri);
		}
		return $result;
	}

	/**
	 * Mark an article as done while making sure that the cache used for this
	 * stays reasonably small. Input is given as an SMWExportArticle object.
	 */
	private function markAsDone($et) {
		if ( count($this->element_done) >= ExportRDF::MAX_CACHE_SIZE ) {
			$this->element_done = array_slice( $this->element_done,
										ExportRDF::CACHE_BACKJUMP,
										ExportRDF::MAX_CACHE_SIZE - ExportRDF::CACHE_BACKJUMP,
										true );
		}
		$this->element_done[$et->hashkey] = $et; //mark title as done
		unset($this->element_queue[$et->hashkey]); //make sure it is not in the queue
	}

	/**
	 * This function checks whether some article fits into a given namespace restriction.
	 * FALSE means "no restriction," non-negative restictions require to check whether
	 * the given number equals the given namespace. A restriction of -1 requires the
	 * namespace to be different from Category:, Relation:, Attribute:, and Type:.
	 */
	static function fitsNsRestriction($res, $ns) {
		if ($res === false) return true;
		if ($res >= 0) return ( $res == $ns );
		return ( ($res != NS_CATEGORY) && ($res != SMW_NS_PROPERTY) && ($res != SMW_NS_TYPE) );
	}

	/** This function transforms a valid url-encoded URI into a string
	 *  that can be used as an XML-ID. The mapping should be injective.
	 */
	static function makeXMLExportId($uri) {
		$uri = str_replace( '-', '-2D', $uri);
		//$uri = str_replace( ':', '-3A', $uri); //already done by PHP
		//$uri = str_replace( '_', '-5F', $uri); //not necessary
		$uri = str_replace( array('"','#','&',"'",'+','%'),
		                    array('-22','-23','-26','-27','-2B','-'),
		                    $uri);
		return $uri;
	}

	/** This function transforms an XML-ID string into a valid
	 *  url-encoded URI. This is the inverse to makeXMLExportID.
	 */
	static function makeURIfromXMLExportId($id) {
		$id = str_replace( array('-22','-23','-26','-27','-2B','-'),
		                   array('"','#','&',"'",'+','%'),
		                   $id);
		$id = str_replace( '-2D', '-', $id);
		return $id;
	}
}


