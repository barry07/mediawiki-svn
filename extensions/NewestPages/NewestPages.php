<?php

/**
 * Special page to show the last X pages added to the wiki
 * This doesn't use recent changes so the items don't expire
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Rob Church <robchur@gmail.com>
 * @copyright © 2006 Rob Church
 * @licence GNU General Public Licence 2.0
 */
 
if( defined( 'MEDIAWIKI' ) ) {

	$wgExtensionCredits['specialpage'][] = array( 'name' => 'Newest Pages', 'author' => 'Rob Church', 'url' => 'http://meta.wikimedia.org/wiki/Newest_Pages_%28extension%29' );
	require_once( 'NewestPages.i18n.php' );
	$wgExtensionFunctions[] = 'efNewestPages';

	$wgNewestPagesLimit = 50;

	if( version_compare( $wgVersion, '1.7.0', '>=' ) ) {
		$wgAutoloadClasses['NewestPages'] = dirname( __FILE__ ) . '/NewestPages.page.php';
		$wgSpecialPages['Newestpages'] = 'NewestPages';
	} else {
		require_once( 'SpecialPage.php' );
		require_once( 'NewestPages.page.php' );
	}
	
	function efNewestPages() {
		global $wgMessageCache, $wgVersion;
		$wgMessageCache->addMessages( efNewestPagesMessages() );
		if( version_compare( $wgVersion, '1.7.0', '<' ) )
			SpecialPage::addPage( new NewestPages() );
	}
	
} else {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

?>