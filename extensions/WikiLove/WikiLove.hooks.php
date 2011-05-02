<?php
/**
 * Hooks for WikiLove extension
 * 
 * @file
 * @ingroup Extensions
 */

class WikiLoveHooks {
	/**
	 * LoadExtensionSchemaUpdates hook
	 */
	public static function loadExtensionSchemaUpdates( $updater = null ) {
		if ( $updater === null ) {
			global $wgExtNewTables;
			$wgExtNewTables[] = array( 'wikilove_log', dirname( __FILE__ ) . '/patches/WikiLoveLog.sql' );
		} else {
			$updater->addExtensionUpdate( array( 'addTable', 'wikilove_log',
				dirname( __FILE__ ) . '/patches/WikiLoveLog.sql', true ) );
		}
		return true;
	}
	
	/**
	 * Add the preference in the user preferences with the GetPreferences hook.
	 * @param $user
	 * @param $preferences
	 */
	public static function getPreferences( $user, &$preferences ) {
		global $wgWikiLoveGlobal;
		if ( !$wgWikiLoveGlobal ) {
			$preferences['wikilove-enabled'] = array(
				'type' => 'check',
				'section' => 'editing/labs',
				'label-message' => 'wikilove-enable-preference',
			);
		}
		return true;
	}
	
	/**
	 * Adds the required module and edit token JS if we are on a user (talk) page.
	 */
	public static function beforePageDisplay( $out, $skin ) {
		global $wgWikiLoveGlobal, $wgUser;
		if ( !$wgWikiLoveGlobal && !$wgUser->getOption( 'wikilove-enabled' ) ) return true;
		
		$title = self::getUserTalkPage( $skin->getTitle() );
		if ( !is_null( $title ) ) {
			$out->addModules( 'ext.wikiLove' );
			$out->addInlineScript(
			'jQuery( document ).ready( function() {
				jQuery.wikiLove.editToken = ' . FormatJson::encode( $wgUser->edittoken() ) . ';
			} );'
		);
		}
		return true;
	}
	
	/**
	 * Adds a tab the old way (before MW 1.18)
	 */
	public static function skinTemplateTabs( $skin, &$contentActions ) {
		self::skinConfigViewsLinks( $skin, $contentActions );
		return true;
	}
	
	/**
	 * Adds a tab or an icon the new way (MW >1.18)
	 */
	public static function skinTemplateNavigation( &$skin, &$links ) {
		if ( self::showIcon( $skin ) ) {
			self::skinConfigViewsLinks( $skin, $links['views']);
		}
		else {
			self::skinConfigViewsLinks( $skin, $links['actions']);
		}
		return true;
	}
	
	/**
	 * Configure views links.
	 * Helper function for SkinTemplateTabs and SkinTemplateNavigation hooks
	 * to configure views links.
	 */
	private static function skinConfigViewsLinks( $skin, &$views ) {
		global $wgWikiLoveGlobal, $wgUser;
		if ( !$wgWikiLoveGlobal && !$wgUser->getOption( 'wikilove-enabled' ) ) return true;
		
		if ( !is_null( self::getUserTalkPage( $skin->getTitle() ) ) ) {
			$views['wikilove'] = array(
				'text' => wfMsg( 'wikilove-tab-text' ),
				'href' => '#',
			);
			if ( self::showIcon( $skin ) ) {
				$views['wikilove']['class'] = 'icon';
				$views['wikilove']['primary'] = true;
			}
		}
	}
	
	/**
	 * Only show an icon when the global preference is enabled and the current skin is Vector.
	 */
	private static function showIcon( $skin ) {
		global $wgWikiLoveTabIcon;
		return $wgWikiLoveTabIcon && $skin->getSkinName() == 'vector';
	}
	
	/**
	 * Find the editable talk page of the user we're looking at, or null
	 * if such page does not exist.
	 */
	public static function getUserTalkPage( $title ) {
		global $wgUser;
		if ( !$wgUser->isLoggedIn() ) return null;
		
		$ns = $title->getNamespace();
		if ( $ns == NS_USER_TALK && $title->quickUserCan( 'edit' ) ) return $title;
		elseif ( $ns == NS_USER ) {
			$talk = $title->getTalkPage();
			if ( $talk->quickUserCan( 'edit' ) ) return $talk;
		}
		return null;
	}
}