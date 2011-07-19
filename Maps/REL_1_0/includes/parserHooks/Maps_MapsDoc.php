<?php

/**
 * Class for the 'mapsdoc' parser hooks, 
 * which displays documentation for a specified mapping service.
 * 
 * @since 1.0
 * 
 * @file Maps_MapsDoc.php
 * @ingroup Maps
 * 
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MapsMapsDoc extends ParserHook {
	
	/**
	 * No LSB in pre-5.3 PHP *sigh*.
	 * This is to be refactored as soon as php >=5.3 becomes acceptable.
	 */
	public static function staticMagic( array &$magicWords, $langCode ) {
		$instance = new self;
		return $instance->magic( $magicWords, $langCode );
	}
	
	/**
	 * No LSB in pre-5.3 PHP *sigh*.
	 * This is to be refactored as soon as php >=5.3 becomes acceptable.
	 */	
	public static function staticInit( Parser &$parser ) {
		$instance = new self;
		return $instance->init( $parser );
	}	
	
	/**
	 * Gets the name of the parser hook.
	 * @see ParserHook::getName
	 * 
	 * @since 1.0
	 * 
	 * @return string
	 */
	protected function getName() {
		return 'mapsdoc';
	}
	
	/**
	 * Returns an array containing the parameter info.
	 * @see ParserHook::getParameterInfo
	 * 
	 * @since 1.0
	 * 
	 * @return array
	 */
	protected function getParameterInfo( $type ) {
		$params = array();
		
		$params['service'] = new Parameter( 'service' );
		$params['service']->addCriteria( new CriterionInArray( $GLOBALS['egMapsAvailableServices'] ) );
		$params['service']->setDescription( wfMsg( 'maps-mapsdoc-par-service' ) );
		
		return $params;
	}
	
	/**
	 * Returns the list of default parameters.
	 * @see ParserHook::getDefaultParameters
	 * 
	 * @since 1.0
	 * 
	 * @return array
	 */
	protected function getDefaultParameters( $type ) {
		return array( 'service' );
	}
	
	/**
	 * Renders and returns the output.
	 * @see ParserHook::render
	 * 
	 * @since 1.0
	 * 
	 * @param array $parameters
	 * 
	 * @return string
	 */
	public function render( array $parameters ) {
		$params = $this->getServiceParameters( $parameters['service'] );
		
		return $this->getParameterTable( $params );		
	}
	
	/**
	 * Returns the wikitext for a table listing the provided parameters.
	 *
	 * @since 1.0
	 *
	 * @param array $parameters
	 *
	 * @return string
	 */
	protected function getParameterTable( array $parameters ) {
		$tableRows = array();

		foreach ( $parameters as $parameter ) {
			$tableRows[] = $this->getDescriptionRow( $parameter );
		}

		$table = '';

		if ( count( $tableRows ) > 0 ) {
			$tableRows = array_merge( array(
			'!' . wfMsg( 'validator-describe-header-parameter' ) ."\n" .
			'!' . wfMsg( 'validator-describe-header-aliases' ) ."\n" .
			'!' . wfMsg( 'validator-describe-header-type' ) ."\n" .
			'!' . wfMsg( 'validator-describe-header-default' ) ."\n" .
			'!' . wfMsg( 'validator-describe-header-description' )
			), $tableRows );

			$table = implode( "\n|-\n", $tableRows );

			$table = 
					'{| class="wikitable sortable"' . "\n" .
					$table .
					"\n|}";
		}

		return $table;
	}
	
	/**
	 * Returns the wikitext for a table row describing a single parameter.
	 *
	 * @since 1.0
	 *
	 * @param Parameter $parameter
	 *
	 * @return string
	 */
	protected function getDescriptionRow( Parameter $parameter ) {
		$aliases = $parameter->getAliases();
		$aliases = count( $aliases ) > 0 ? implode( ', ', $aliases ) : '-';

		$description = $parameter->getDescription();
		if ( $description === false ) $description = '-';

		$type = $parameter->getTypeMessage();

		$default = $parameter->isRequired() ? "''" . wfMsg( 'validator-describe-required' ) . "''" : $parameter->getDefault();
		if ( is_array( $default ) ) {
			$default = implode( ', ', $default );
		}
		else if ( is_bool( $default ) ) {
			$default = $default ? 'yes' : 'no';
		}
		
		if ( $default === '' ) $default = "''" . wfMsg( 'validator-describe-empty' ) . "''";

		return <<<EOT
| {$parameter->getName()}
| {$aliases}
| {$type}
| {$default}
| {$description}
EOT;
	}
	
	protected function getServiceParameters( $service ) {
		$service = MapsMappingServices::getServiceInstance( $service );
		
		$params = array();
		
		$params['zoom'] = new Parameter( 'zoom',  Parameter::TYPE_INTEGER );
		$params['zoom']->setDescription( wfMsg( 'maps-par-zoom' ) );
		
		$service->addParameterInfo( $params );	

		return $params;
	}
	
	/**
	 * @see ParserHook::getDescription()
	 * 
	 * @since 1.0
	 */
	public function getDescription() {
		return wfMsg( 'maps-mapsdoc-description' );
	}	
	
}