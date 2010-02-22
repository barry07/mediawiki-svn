<?php
/**
 * InputBox extension
 *
 * @file
 * @ingroup Extensions
 *
 * This file contains the main include file for the Inputbox extension of
 * MediaWiki.
 *
 * Usage: Add the following line in LocalSettings.php:
 * require_once( "$IP/extensions/InputBox/InputBox.php" );
 *
 * @author Erik Moeller <moeller@scireview.de>
 *  namespaces search improvements partially by
 *  Leonardo Pimenta <leo.lns@gmail.com>
 *	Cleaned up by Trevor Parscal <tparscal@wikimedia.org>
 * @copyright Public domain
 * @license Public domain
 * @version 0.1.1
 */

// Check environment
if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This is an extension to the MediaWiki package and cannot be run standalone.\n" );
	die( -1 );
}

/* Configuration */

// Credits
$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'name'           => 'InputBox',
	'author'         => array( 'Erik Moeller', 'Leonardo Pimenta', 'Rob Church', 'Trevor Parscal' ),
	'url'            => 'http://www.mediawiki.org/wiki/Extension:InputBox',
	'descriptionmsg' => 'inputbox-desc',
);

// Shortcut to this extension directory
$dir = dirname( __FILE__ ) . '/';

// Internationalization
$wgExtensionMessagesFiles['InputBox'] = $dir . 'InputBox.i18n.php';

// Register auto load for the special page class
$wgAutoloadClasses['InputBoxHooks'] = $dir . 'InputBox.hooks.php';
$wgAutoloadClasses['InputBox'] = $dir . 'InputBox.classes.php';

// Register parser hook
$wgHooks['ParserFirstCallInit'][] = 'InputBoxHooks::register';
