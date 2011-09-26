<?php

/**
 * Static class for hooks handled by the Contest extension.
 *
 * @since 0.1
 *
 * @file Contest.hooks.php
 * @ingroup Contest
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class ContestHooks {
	
	/**
	 * Schema update to set up the needed database tables.
	 *
	 * @since 0.1
	 *
	 * @param DatabaseUpdater $updater
	 *
	 * @return true
	 */
	public static function onSchemaUpdate( /* DatabaseUpdater */ $updater = null ) {
		global $wgDBtype;
		
//		$updater->addExtensionUpdate( array(
//			'addTable',
//			'surveys',
//			dirname( __FILE__ ) . '/Survey.sql',
//			true
//		) );
	}
	
	/**
	 * Hook to add PHPUnit test cases.
	 * 
	 * @since 0.1
	 * 
	 * @param array $files
	 * 
	 * @return true
	 */
	public static function registerUnitTests( array &$files ) {
		$testDir = dirname( __FILE__ ) . '/test/';
		
		//$files[] = $testDir . 'SurveyQuestionTest.php';
		
		return true;
	}
	
}