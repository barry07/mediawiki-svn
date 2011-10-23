<?php
$wgHooks['ParserFirstCallInit'][] = 'efSternograph';
$wgExtensionMessagesFiles['Sternograph'] = dirname( __FILE__ ) . "/Sternograph.i18n.php";
$wgAutoloadClasses['Sternograph'] = dirname( __FILE__ ) . "/Sternograph.body.php";

$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'Sternograph',
	'version' => '0.0',
	'author' =>'Smoke 003723', 
	'url' => 'http://www.mediawiki.org/wiki/Extension:Sternograph', 
	'descriptionmsg' => 'descriptionmsg'
       );
 
function efSternograph(&$parser){
	new Sternograph($parser);
	return true;
}


