<?php
/**
 * Hooks for Usability Initiative Vector extension
 *
 * @file
 * @ingroup Extensions
 */

class VectorHooks {

	static $modules = array(
		'collapsibletabs' => array(
			'scripts' => array(
				'raw' => array( 'src' => 'Modules/CollapsibleTabs/CollapsibleTabs.js', 'version' => 1 ),
			),
		),
		'editwarning' => array(
			'i18n' => 'VectorEditWarning',
			'preferences' => array(
				'enable' => array(
					// Ideally this would be 'vector-editwarning'
					'key' => 'useeditwarning',
					'ui' => array(
						'type' => 'toggle',
						'label-message' => 'vector-editwarning-preference',
						'section' => 'editing/advancedediting',
					),
				),
			),
			'messages' => array(
				'vector-editwarning-warning',
			),
			'scripts' => array(
				'raw' => array( 'src' => 'Modules/EditWarning/EditWarning.js', 'version' => 1 ),
			),
		),
		'simplesearch' => array(
			'i18n' => 'WikiEditorToc',
			'messages' => array(
				'vector-simplesearch-search',
				'vector-simplesearch-containing',
			),
			'scripts' => array(
				'raw' => array( 'src' => 'Modules/SimpleSearch/SimpleSearch.js', 'version' => 1 ),
			),
		),
	);
	
	/* Static Functions */
	
	/**
	 * From here down, with very little modification is a copy of what's found in WikiEditor/WikiEditor.hooks.php.
	 * Perhaps we could find a clean way of eliminating this redundancy.
	 */
	
	/**
	 * EditPage::showEditForm:initial hook
	 * Adds the modules to the edit form
	 */
	 public static function addModules( &$toolbar ) {
		global $wgOut, $wgUser, $wgJsMimeType;
		global $wgVectorModules, $wgUsabilityInitiativeResourceMode;
		
		// Modules
		$scripts = array();
		$enabled = false;
		$preferences = array();
		foreach ( $wgVectorModules as $module => $enable ) {
			if (
				$enable['global'] || (
					$enable['user']
					&& isset( self::$modules[$module]['preferences']['enable'] )
					&& $wgUser->getOption( self::$modules[$module]['preferences']['enable']['key'] )
				)
			) {
				$enabled = true;
				UsabilityInitiativeHooks::initialize();
				// Scripts
				$mode = $wgUsabilityInitiativeResourceMode;
				if ( !isset( self::$modules[$module]['scripts'][$mode] ) ) {
					$mode = 'raw';
				}
				$scripts[] = self::$modules[$module]['scripts'][$mode];
				// Messages
				if ( isset( self::$modules[$module]['i18n'], self::$modules[$module]['messages'] ) ) {		
					wfLoadExtensionMessages( self::$modules[$module]['i18n'] );
					UsabilityInitiativeHooks::addMessages( self::$modules[$module]['messages'] );
				}
				// Variables
				if ( isset( self::$modules[$module]['variables'] ) ) {
					$variables = array();
					foreach ( self::$modules[$module]['variables'] as $variable ) {
						global $$variable;
						$variables[$variable] = $$variable;
					}
					UsabilityInitiativeHooks::addVariables( $variables );
				}
				// Preferences
				if ( isset( self::$modules[$module]['preferences'] ) ) {
					foreach ( self::$modules[$module]['preferences'] as $name => $preference ) {
						if ( !isset( $preferences[$module] ) ) {			
							$preferences[$module] = array();
						}
						$preferences[$module][$name] = $wgUser->getOption( $preference['key'] );
					}
				}
			}
		}
		// Add all scripts
		foreach ( $scripts as $script ) {
			UsabilityInitiativeHooks::addScript(
				basename( dirname( __FILE__ ) ) . '/' . $script['src'], $script['version']
			);
		}
		// Preferences (maybe the UsabilityInitiative class could do most of this for us?)
		$wgOut->addScript(
			Xml::tags(
				'script',
				array( 'type' => $wgJsMimeType ),
				'var wgVectorPreferences = ' . FormatJson::encode( $preferences, true ) . ';'
			)
		);
		return true;
	}
	
	/**
	 * GetPreferences hook
	 * Add module-releated items to the preferences
	 */
	public static function addPreferences( $user, &$defaultPreferences ) {
		global $wgVectorModules;
		
		foreach ( $wgVectorModules as $module => $enable ) {
			if ( isset( self::$modules[$module]['i18n'], self::$modules[$module]['preferences'] ) ) {
				wfLoadExtensionMessages( self::$modules[$module]['i18n'] );
				foreach ( self::$modules[$module]['preferences'] as $preference ) {
					// The preference with the key 'enable' determines if the rest are even relevant, so in the future
					// setting up some dependencies on that might make sense
					$defaultPreferences[$preference['key']] = $preference['ui'];
				}
			}
		}
		return true;
	}
}
