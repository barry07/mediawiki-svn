<?php

$IP = dirname( dirname(__FILE__) );

require_once("$IP/config.php");
require_once("$IP/common/wwimages.php");

if ($wwAPI) require_once("$IP/common/wwclient.php");
else require_once("$IP/common/wwthesaurus.php");

function printConceptList($langs, $concepts, $class, $limit = false) {
    if (!$concepts) return false;

    if (!$limit || $limit > count($concepts)) $limit = count($concepts);

    $i = 0;
    ?>
    <ul class="<?php print $class; ?>">
      <?php
	foreach ($concepts as $c) {
	    ?><li><?php
	    print getConceptDetailsLink($langs, $c);
	    
	    $i += 1;
	    if ($i >= $limit) break;
	    ?></li><?php
	}
      ?>
    </ul>
    <?php

    return $i < count($concepts);
}

function getImagesAbout($concept, $max) {
    global $utils, $profiling;

    $t = microtime(true);
    $pics = $utils->getImagesAbout($concept, $max);
    $profiling['pics'] += (microtime(true) - $t);

    return $pics;
}

function printConceptImageList($concept, $terse = false, $columns = 5, $limit = false ) {
    global $utils, $wwThumbSize;

    if (!$concept) return false;

    if (is_array($concept) && !isset($concept['id'])) $images = $concept; #XXX: HACK
    else $images = getImagesAbout($concept, $max ? $max +1 : false);

    if (!$images) return;

    $class = $terse ? "terseImageTable" : "";

    $imgList = array_values($images);

    $cw = $wwThumbSize + 32; //FIXME: magic number, use config!

    ?>
    <table class="imageTable <?php print $class; ?>" summary="images" width="<?php print $columns*$cw; ?>">
      <colgroup span="<?php print $columns; ?>" width="<?php print $cw; ?>">
      </colgroup>

      <?php
	$i = 0;
	$c = count($images);
	if (!$limit || $limit > $c) $limit = $c;

	while ($i < $limit) {
	  $i = printConceptImageRow($imgList, $i, $terse, $columns, $limit);
	}
      ?>
    </table>
    <?php

    return $i < $c;
}

function printConceptImageRow($images, $from, $terse, $columns = 5, $limit = false) {
	global $wwThumbSize, $utils;

	$cw = $wwThumbSize + 32; //FIXME: magic number, use config!
	$cwcss = $cw . "px";

	$to = $from + $columns;
	if ( $to > $limit ) $to = $limit;

	print "\t<tr class=\"imageRow\">\n";
	
	for ($i = $from; $i<$to; $i += 1) {
	  $img = $images[$i];
	  print "\t\t<td class=\"imageCell\" width=\"$cw\" align=\"left\" valign=\"bottom\" nowrap=\"nowrap\" style=\"width: $cwcss\"><div class=\"clipBox\" style=\"width:$cwcss; max-width:$cwcss;\">";
	  print $utils->getThumbnailHTML($img, $wwThumbSize, $wwThumbSize);
	  print "</div></td>\n";
	}
	
	print "\n\t</tr>\n";

	if (!$terse) {
	    print "\t<tr class=\"imageMetaRow\">\n";
	    
	    for ($i = $from; $i<$to; $i += 1) {
	      $img = $images[$i];

	      $title = $img['name'];
	      $title = str_replace("_", " ", $title);
	      $title = preg_replace("/\\.[^.]+$/", "", $title);

	      $info = getImageInfo($img);
	      $labels = getImageLabels($img);

	      print "\t\t<td class=\"imageMetaCell\" width=\"$cw\" align=\"left\" valign=\"top\" style=\"width: $cwcss\"><div class=\"clipBox\" style=\"width:$cwcss; max-width:$cwcss;\">";
	      print "<div class=\"imageTitle\" title=\"" . htmlspecialchars( $img['name'] ) . "\">" . htmlspecialchars( $title ) . "</div>";

	      if ($info) {
		  print "<div class=\"imageInfo\">";
		  printList($info, false, "terselist");
		  print "</div>";
	      }

	      if ($labels) {
		  print "<div class=\"imageLabels\">";
		  printList($labels, false, "terselist");
		  print "</div>";
	      }

	      print "</div></td>\n";
	    }
	    
	    print "\n\t</tr>\n";
	}

	return $to;
}

function getImageInfo($img) {
	if (empty($img['meta'])) return false;

	$info = array();
	extract($img['meta']);

	$info[] = htmlspecialchars("$img_minor_mime");

	if ( $img_media_type == "BITMAP" ) {
	    $info[] = htmlspecialchars("{$img_width}x{$img_height}");
	}

	if ( $img_size > 1024*1024 ) $info[] = htmlspecialchars(sprintf("%1.0fM", $img_size / (1024.0*1024.0)));
	else if ( $img_size > 1024 ) $info[] = htmlspecialchars(sprintf("%1.0fK", $img_size / 1024.0));
	else $info[] = htmlspecialchars(sprintf("%dB", $img_size));

	return $info;
}

function getImageLabels($img) {
	global $wwLabelPatterns;

	if (!$wwLabelPatterns || empty($img['tags'])) return false;

	$labels = array();

	foreach ( $img['tags'] as $tag ) {
	    foreach ( $wwLabelPatterns as $pattern => $label ) {
		if ( preg_match($pattern, $tag) ) {
		    $labels[$label] = 1;
		    break;
		}
	    }
	}

	$labels = array_keys($labels);
	return $labels;
}

function getConceptDetailsURL($langs, $concept) {
    global $wwSelf;

    if ( is_array($langs) ) $langs = implode('|', $langs);

    return "$wwSelf?id=" . urlencode($concept['id']) . "&lang=" . urlencode($langs); 
}

function getConceptDetailsLink($langs, $concept, $text = NULL) {
    global $utils;

    $name = $utils->pickLocal($concept['name'], $langs);
    $name = str_replace("_", " ", $name);
    $score = @$concept['score'];

    if ($text === null) $text = $name;
  
    $u = getConceptDetailsURL($langs, $concept);
    return '<a href="' . htmlspecialchars($u) . '" title="' . htmlspecialchars($name) . ' (score: ' . (int)$score . ')'. '">' . htmlspecialchars($text) . '</a>';
}

function pickPage( $pages ) {
    if (!$pages) return false;

    foreach ( $pages as $page => $type ) {
	if ($type == 10) return $page;
    }

    return $pages[0];
}

function getConceptPageURLs($lang, $concept) {
    if (!isset($concept['pages'][$lang]) || !$concept['pages'][$lang]) return false;

    if ($lang == 'commons') $domain = 'commons.wikimedia.org';
    else $domain = "$lang.wikipedia.org";

    $urls = array();
    foreach ($concept['pages'][$lang] as $page => $type) {
	$u = "http://$domain/wiki/" . urlencode($page); 
	$urls[$page] = $u;
    }

    return $urls;
}

function getConceptPageLinks($lang, $concept) {
    $urls = getConceptPageURLs($lang, $concept);
    if (!$urls) return false;

    foreach ($urls as $page => $u) {
	$links[] = '<a href="' . htmlspecialchars($u) . '" title="' . htmlspecialchars( str_replace("_", " ", $page) ) . '">' . htmlspecialchars( $lang . ":" . str_replace("_", " ", $page) ) . '</a>';
    }

    return $links;
}

function getAllConceptPageLinks($concept) {
    $links = array();

    foreach ( $concept['languages'] as $lang ) {
	$ll = getConceptPageLinks($lang, $concept);
	if ($ll) $links[$lang] = $ll;
    }

    return $links;
}

function printList($items, $escape = true, $class = "list") {
    ?>
    <ul class="<?php print htmlspecialchars($class); ?>">
      <?php
	foreach ($items as $item) {
	    if ( $escape ) $item = htmlspecialchars($item);
	    print "<li>" . trim($item) . "</li>";
	}
      ?>
    </ul>
    <?php
}

function printConceptPageList( $langs, $concept, $class, $limit = false ) {
    $linksByLanguage = getAllConceptPageLinks($concept);

    $i = 0;
    $more = false;
    ?>
    <ul class="<?php print htmlspecialchars($class); ?>">
      <?php
	foreach ( $linksByLanguage as $lang => $links ) {
	    foreach ($links as $link ) {
		print "<li>" . trim($link) . "</li>";
	    
		$i += 1;
		if ($limit && $i >= $limit) break;
	    }

	    if ($limit && $i >= $limit) {
		$more = true;
		break;
	    }
	}
      ?>
    </ul>
    <?php

    return $more;
}

function array_key_diff($base, $other) {
    $keys = array_keys($other);
    foreach ($keys as $k) {
	unset($base[$k]);
    }

    return $base;
}

function getRelatedConceptList( $concept ) {
    $related = array();
    if ( @$concept['similar'] ) $related += $concept['similar'];
    if ( @$concept['related'] ) $related += $concept['related'];

    if (isset($concept['broader'])) $related = array_key_diff($related, $concept['broader']);
    if (isset($concept['narrower'])) $related = array_key_diff($related, $concept['narrower']);

    sortConceptList($related);
    return $related;
}

function printDefList($items, $scapeKeys = true, $escapeValues = true, $class = "list") {
    ?>
    <dl class="<?php print htmlspecialchars($class); ?>">
      <?php
	foreach ($items as $key => $item) {
	    if ( $escapeKeys ) $key = htmlspecialchars($key);
	    print "\t\t<dt>" . $key . "</dt>\n";

	    if ( $escapeValues ) $item = htmlspecialchars($item);
	    print "\t\t\t<dd>" . $item . "</dd>\n";
	}
      ?>
    </sl>
    <?php
}

function getWeightClass($weight) {
    if (!isset($weight) || !$weight) { 
      return "unknown";
      $weight = NULL;
    }
    else if ($weight>1000) return "huge";
    else if ($weight>100) return "big";
    else if ($weight>10) return "normal";
    else if ($weight>2) return "some";
    else return "little";
}

function stripSections(&$concepts) {
    foreach ($concepts as $k => $c) {
	  foreach ($c['name'] as $l => $n) {
		if (preg_match('/#/', $n)) {
			unset($concepts[$k]);
			break;
		}
	  }
    }
}

function compareConceptScoreAndName($a, $b) {
    if (isset($a['score']) && isset($b['score']) && $a['score'] != $b['score']) {
	if ( $a['score'] > $b['score'] ) return 1;
	else return -1;
    } else {
	if ( $a['name'] > $b['name'] ) return 1; //XXX: unicode collation??
	else return -1;
    }

    return 0;
}

function sortConceptList(&$concepts) {
    usort($concepts, 'compareConceptScoreAndName');
}

function mangleConcept(&$concept) {
    stripSections($concept['narrower']);

    sortConceptList($concept['narrower']);
    sortConceptList($concept['related']);
    sortConceptList($concept['similar']);
    sortConceptList($concept['broader']);
}

function printConcept($concept, $langs, $terse = true) {
    global $utils, $wwMaxPreviewImages, $wwMaxGalleryImages, $wwMaxPreviewLinks, $wwMaxDetailLinks, $wwGalleryColumns;

    extract( $concept );
    if (@$score) $wclass = getWeightClass($score);
    else $wclass = "";

    #$lclass = $terse ? "terselist" : "list";
    $lclass = "terselist";

    $name = $utils->pickLocal($concept['name'], $langs);
    $name = str_replace("_", " ", $name);

    $gallery = getImagesAbout($concept, $terse ? $wwMaxPreviewImages*2 : $wwMaxGalleryImages+1 );

    if (empty($definition)) $definition = "";
    else if (is_array($definition)) $definition = $utils->pickLocal($definition, $langs);

    ?>
    <tr class="row_head">
      <td colspan="3">
	  <h1 class="name <?php print "weight_$wclass"; ?>"><?php print getConceptDetailsLink($langs, $concept); ?>:</h1>
	   <p class="definition"><?php print htmlspecialchars($definition); ?></p> 
	  <div class="wikipages"><strong class="label">Pages:</strong> <?php printConceptPageList( $langs, $concept, $lclass, $terse ? $wwMaxPreviewLinks : $wwMaxDetailLinks ) ?></div>
      </td>
    </tr>

    <tr class="row_images">
      <td class="cell_images" colspan="2">
      <?php 
	  if (!$gallery) print "<p class=\"notice\">No images found for concept <em>".htmlspecialchars($name)."</em>.</p>";
	  else $more = printConceptImageList( $gallery, $terse, $wwGalleryColumns, $terse ? $wwMaxPreviewImages : $wwMaxGalleryImages ); 
      ?>
      </td>
      <?php if ($gallery) { ?>
      <td class="cell_more_images" colspan="1" width="100%" style="vertical-align:bottom; padding: 1ex; font-size:normal;">
      <?php if ($terse) print " <div><strong class=\"more\">[" . getConceptDetailsLink($langs, $concept, "more/details...") . "]</strong></div>"; ?>
      </td>
      <?php } ?>
    </tr>

    <?php if (@$concept['narrower']) { ?>
    <tr class="row_narrower">
      <td class="cell_related" colspan="3">
      <strong class="label">Narrower:</strong>
      <?php 
	  $more = printConceptList( $langs, $concept['narrower'], $lclass, $terse ? $wwMaxPreviewLinks : $wwMaxDetailLinks ); 
      ?>
      <?php if ($terse && $more) print " <strong class=\"more\">[" . getConceptDetailsLink($langs, $concept, "more...") . "]</strong>"; ?>
      </td>
    </tr>
    <?php } ?>

    <?php 
      $related = getRelatedConceptList($concept);
      if ($related) { 
    ?>
    <tr class="row_related">
      <td class="cell_related" colspan="3">
      <strong class="label">Related:</strong> 
      <?php 
	  $more = printConceptList( $langs, $related, $lclass, $terse ? $wwMaxPreviewLinks : $wwMaxDetailLinks ); 
      ?>
      <?php if ($terse && $more) print " <strong class=\"more\">[" . getConceptDetailsLink($langs, $concept, "more...") . "]</strong>"; ?>
      </td>
    </tr>
    <?php } ?>

    <?php if (@$concept['broader']) { ?>
    <tr class="row_category">
      <td class="cell_related" colspan="3">
      <strong class="label">Broader:</strong>
      <?php 
	  $more = printConceptList( $langs, $concept['broader'], $lclass, $terse ? $wwMaxPreviewLinks : $wwMaxDetailLinks ); 
      ?>
      <?php if ($terse && $more) print " <strong class=\"more\">[" . getConceptDetailsLink($langs, $concept, "more...") . "]</strong>"; ?>
      </td>
    </tr>
    <?php } ?>

    <tr class="row_blank">
      <td class="cell_blank" colspan="3">
      &nbsp;
      </td>
    </tr>

    <?php
    if (isset($score) && $score && $score<2 && $pos>=3) return false;
    else return true;
}

$conceptId = @$_REQUEST['id'];
$term = @$_REQUEST['term'];
$lang = @$_REQUEST['lang'];

if ($term!==NULL && preg_match('/^\s*#(\d+)\s*$/', $term, $m)) {
    $conceptId = $m[1];
    $term = NULL;
}

if (!isset($wwSelf)) $wwSelf = @$_SERVER["PHP_SELF"];

$error = NULL;

if ($lang) {
    $ll = preg_split('![,;/|+]!', $lang);
    foreach ($ll as $l) {
	if (!isset($wwLanguages[$l]) && $l != "commons") {
	    $error = "bad language code: $l";
	    $lang = NULL;
	}
    }
}

if ($wwAPI) $thesaurus = new WWClient($wwAPI);
else {
  $thesaurus = new WWThesaurus();
  $thesaurus->connect($wwDBServer, $wwDBUser, $wwDBPassword, $wwDBDatabase);
}

if (@$wwFakeImages) $utils = new WWFakeImages( $thesaurus );
else $utils = new WWImages( $thesaurus );


if ( !$utils->db ) $utils->connect($wwDBServer, $wwDBUser, $wwDBPassword, $wwDBDatabase);

if (@$_REQUEST['debug']) $utils->debug = true;

$limit = 20;
$norm = 1;

$mode = NULL;
$result = NULL;

$fallback_languages = array( "en", "commons" ); #TODO: make the user define this list

if ( $lang ) {
    $languages = explode( '|', $lang );
    $languages = array_merge( $languages, $fallback_languages ); 
    $languages = array_unique( $languages );
} else {
    $languages = $fallback_languages;
}

$lang = $languages[0];

$profiling['thesaurus'] = 0;
$profiling['pics'] = 0;

if (!$error) {
  $t = microtime(true);
  try {
      if ($lang && $conceptId) {
	  $mode = "concept";
	  $result = $thesaurus->getConceptInfo($conceptId, $languages);
	  if ( $result ) $result = array( $result ); //hack
      } else if ($lang && $term) {
	  $mode = "term";
	  $result = $thesaurus->getConceptsForTerm($lang, $term, $languages, $norm, $limit);
      } 
  } catch (Exception $e) {
      $error = $e->getMessage();
  }
  $profiling['thesaurus'] += (microtime(true) - $t);
}


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr"> 
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>WikiPics: multilingual search for Wikimedia Commons</title>

    <style type="text/css">
	html, body { font-family: verdana, helvetica, arial, sans-serif; font-size:10pt; margin: 0; padding: 0; }

	a, a:link, a:visited, a:active, a:hover {
	  color:#2200CC;
	}

	a, a:link, a:visited {
	  text-decoration: none;
	}

	a:active, a:hover {
	  text-decoration: underline;
	}

	.error { color: red; font-weight: bold; }
	.weight_huge { font-size: 140%; font-weight:bold; }
	.weight_big { font-size: 120%; font-weight:bold; }
	.weight_normal { font-size: 110%; font-weight:bold; }
	.weight_some { font-size: 100%; font-weight:bold; }
	.weight_little { font-size: 90%; font-weight:bold; }
	.weight_unknown { font-size: 100%; font-weight:bold; }

	/*
	.row_def td { font-size: small; font-style:italic; }
	.row_details td { font-size: small; }
	*/

	.row_head td { font-size: small; }

	.row_head td { border-top: 1px solid #6B90DA; background-color: #F0F7F9; padding: 0.5ex; }
	.row_head h1, .row_head h2, .row_head h3 { padding: 0; margin: 0; font-size: inherit; font-weight: inherit; }
	.row_head p { padding: 0; margin: 0; font-size: inherit;  }
	.row_head .name { font-weight: bold; display:inline; font-size: large; }
	.row_head .definition { font-style: italic; display:inline; }
	.row_head .wikipages { font-style: inherit; display:inline; }

	.row_images td { vertical-align: bottom; }

	.row_related td, .row_category, .row_narrower { font-size: small; background-color: #F0F7F9; }
	.row_blank td { font-size: small;  }

	/*
	.cell_weight { text-align: right; }
	.cell_label { text-align: right; font-weight: bold; }
	*/

	.label { font-weight: bold; }
	.note { font-size:small; }

	.header { font-size:small; text-align: left; margin:0 0 1ex 0; padding:0.5ex; border-bottom: 1px solid #C9D7F1; }

	.inputform { text-align: left; margin:0 1ex; }
	.inputform td { text-align: left; vertical-align: bottom; padding: 0.5ex; }
	.inputform td.note { font-size:small; }
	.inputform th { text-align: left; vertical-align: bottom; }


	.footer { font-size:small; text-align: center; margin:1ex 0 0 0; padding: 0; border-top: 1px solid #C9D7F1; }

	.tersegallery, .tersegallery li, .terselist, .terselist li { display: inline; margin:0; padding:0; }
	.terselist li:before { content:", " }
	.terselist li:first-child:before { content:"" }

	.gallery li { display: inline; padding:0.5ex; margin:0.5ex; }

	.results { margin: 1em; }
	.results td { text-align: left; vertical-align: top; }
	.results th { text-align: left; vertical-align: top; font-weight:bold; }

	.imageTable td.imageCell { 
	    vertical-align: bottom; 
	    padding-top: 0.5em;
	    padding-right: 1em;
	    font-size: small;
	}

	.imageTable td.imageCell img { 
	    font-size:50%; 
	}

	.imageTable td.imageMetaCell { 
	    vertical-align: top; 
	    padding-bottom: 0.5em;
	    padding-right: 1em;
	    font-size:small; 
	}

	.clipBox {
	    overflow: hidden;
	}

	.imageTable td.imageCell img { border: 1px solid; }

	.imageInfo { color: #676767 }
	.imageLabels { color: #676767; font-size:80%; }
    </style>
</head>
<body>
    <div class="header">
      <div style="float:left">Wikipics 0.1&alpha; (experimental)</div>
      <div style="float:right"><a href="http://wikimedia.de">Wikimedia Deutschland e.V.</a></div>
    <!--   <h1>WikiWord Navigator</h1>
      <p>Experimental semantic navigator and thesaurus interface for Wikipedia.</p>
      <p>The WikiWord Navigator was created as part of the WikiWord project run by <a href="http://wikimedia.de">Wikimedia Deutschland e.V.</a>.
      It is based on a <a href="http://brightbyte.de/page/WikiWord">diploma thesis</a> by Daniel Kinzler, and runs on the <a href="http://toolserver.org/">Wikimedia Toolserver</a>. WikiWord is an ongoing research project. Please contact <a href="http://brightbyte.de/page/Special:Contact">Daniel Kinzler</a> for more information.</p>  --> &nbsp;
    </div>

    <div class="inputform" >
    <form name="search" action="<?php print $wwSelf; ?>">
      <table border="0" class="inputgrid" summary="input form">
	<tr>
	  <td>
	    <?php 
	      $u = $utils->getThumbnailURL("Commons_logo_optimized.svg", 60); 
	      print "<img class=\"logo\" alt=\"Wikimedia Commons Logo\" src=\"".htmlspecialchars($u)."\" title=\"Search Wikimedia Commons\" align=\"bottom\"/>";
	    ?>
	  </td>
	  <td>
	    <label for="term" style="display:none">Term: </label><input type="text" name="term" id="term" size="24" value="<?php print htmlspecialchars($term); ?>"/>
	  </td>
	  <td>
	    <label for="term" style="display:none">Language: </label>
	    <?php WWUtils::printSelector("lang", $wwLanguages, $lang) ?>
	  </td>
	  <td>
	    <input type="submit" name="go" value="go"/>
	  </td>
	  <td class="note">
	    <small>Note: this is a thesaurus lookup, not a full text search. Multiple words are handeled as a single phrase. Only exact matches of complete phrases will be found. </small>
	  </td>
	</tr>
      </table>
      
      <?php
      if ($utils->debug) {
	      print '<input type="hidden" name="debug" value="true"/>';
	      print "<p>debug mode enabled!</p>";
	      flush();                           
      }
      ?>
    </form>
    </div>
<?php
if ($error) {
  print "<p class=\"error\">".htmlspecialchars($error)."</p>";
}

if (!$result && $mode) {
  if ($mode=="concept") print "<p class=\"error\">".htmlspecialchars($error)."</p>";
  else if ($mode=="term") print "<p class=\"notice\">No meanings found for term <em>".htmlspecialchars($term)."</em>.</p>";
}
?>    

<?php
if ($result && $mode) {
    if ( $mode == 'concept' ) $terse = false;
    else if ( $mode == 'term' ) $terse = true;
?>
    <table  border="0" class="results" cellspacing="0" summary="search results">
<?php
    $count = 0;
    foreach ( $result as $row ) {
	$count = $count + 1;
	$row['pos'] = $count;

?>    
    <?php 
	  mangleConcept($row);
	  $continue= printConcept($row, $languages, $terse);

	  if (!$continue) break;
    ?>

<?php
    } #concept loop

?>
    </table>
<?php
} #if results
?>

<div class="footer">
<p>Wikipics is provided by <a href="http://wikimedia.de">Wikimedia Deutschland</a> as part of the <a href="http://brightbyte.de/page/WikiWord">WikiWord</a> project.</p>

</div>
</body>
<?php
foreach ( $profiling as $key => $value ) {
  print "<!-- $key: $value sec -->\n";
}
?>
</html>
<?php
$utils->close();
?>