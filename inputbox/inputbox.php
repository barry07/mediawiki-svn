<?php

/**
 * This file contains the main include file for the Inputbox extension of 
 * MediaWiki. 
 *
 * Usage: require_once("path/to/inputbox.php" in LocalSettings.php
 *
 * @author Erik Moeller <moeller@scireview.de>
 * @copyright Public domain
 * @license Public domain
 * @package MediaWikiExtensions
 * @version 0.1
 */
 
/**
 * Register the Inputbox extension with MediaWiki
 */ 
$wgExtensionFunctions[] = 'registerInputboxExtension';

/**
 * Sets the tag that this extension looks for and the function by which it
 * operates
 */
function registerInputboxExtension()
{
    global $wgParser;
    $wgParser->setHook('inputbox', 'renderInputbox');
}


/**
 * Renders an inputbox based on information provided by $input.
 */
function renderInputbox($input)
{
	getBoxOption($type,$input,"type");	
	getBoxOption($width,$input,"width");	
	getBoxOption($preload,$input,"preload");
	getBoxOption($editintro,$input,"editintro");
	getBoxOption($default,$input,"default");	
	getBoxOption($bgcolor,$input,"bgcolor");	
	# Make sure you escape any user input in the output!
	
	if($type=="search") {	
		$inputbox=getSearchForm($width,$default,$bgcolor);
	} elseif($type=="create") {
		$inputbox=getCreateForm($width,$preload,$editintro,$default,$bgcolor);
	}
	if(isset($inputbox)) {
		return $inputbox;
	} else {
		# Careful with HTML insertions here
		return "<br /> <font color='red'>Input box not defined.</font>";
	}
}

function getSearchForm($width,$default='',$bgcolor='') {
	global $wgUser;
	
	$width=intval($width);
	if(!$width) $width=45;

	$sk=$wgUser->getSkin();
	$searchpath = $sk->escapeSearchLink();
	$defaultEnc = htmlspecialchars( $default );
	$bgcolorEnc = htmlspecialchars( $bgcolor );
	$tryexact = wfMsgHtml( 'tryexact' );
	$searchfulltext = wfMsgHtml( 'searchfulltext' );
	
	$searchform=<<<ENDFORM
<table border="0" width="100%">
<tr>
<td align="center" bgcolor="$bgcolorEnc" cellspacing="0">
<form name="searchbox" action="$searchpath" class="searchbox">
	<input class="searchboxInput" name="search" type="text"
	value="$defaultEnc" size="$width"/><br />
	<input type='submit' name="go" class="searchboxGoButton"
	value="$tryexact"
	/>&nbsp;<input type='submit' name="fulltext"
	class="searchboxSearchButton"
	value="$searchfulltext" />
</form>
</td>
</tr>
</table>
ENDFORM;
	return $searchform;
}

function getCreateForm($width,$preload='',$editintro='',$default='', $bgcolor='') {
	global $wgScript;	
	
	$width=intval($width);
	if(!$width) $width = 45;
	
	$action = htmlspecialchars( $wgScript );
	$preloadEnc = htmlspecialchars( $preload );
	$editintroEnc = htmlspecialchars( $editintro );
	$defaultEnc = htmlspecialchars( $default );	
	$bgcolorEnc = htmlspecialchars( $bgcolor );
	$createarticle = wfMsgHtml( "createarticle" );
	
	$createform=<<<ENDFORM
<table border="0" width="100%" cellspacing="0">
<tr>
<td align="center" bgcolor="$bgcolorEnc">
<form name="createbox" action="$action" method="get" class="createbox">
	<input type='hidden' name="action" value="edit">
	<input type="hidden" name="preload" value="$preloadEnc" />
	<input type="hidden" name="editintro" value="$editintroEnc" />	
	<input class="createboxInput" name="title" type="text"
	value="$defaultEnc" size="$width"/><br />		
	<input type='submit' name="create" class="createboxButton"
	value="$createarticle"/>	
</form>
</td>
</tr>
</table>
ENDFORM;
	return $createform;
}

function getBoxOption(&$value,&$input,$name) {

	if(preg_match("/$name\s*=\s*(.*)/mi",$input,$matches)) {
		$value=$matches[1];
	} 	
}
