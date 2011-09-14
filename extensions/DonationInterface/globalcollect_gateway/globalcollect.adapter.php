<?php

class GlobalCollectAdapter extends GatewayAdapter {
	const GATEWAY_NAME = 'Global Collect';
	const IDENTIFIER = 'globalcollect';
	const COMMUNICATION_TYPE = 'xml';
	const GLOBAL_PREFIX = 'wgGlobalCollectGateway';

	/**
	 * stageData should alter the postdata array in all ways necessary in preparation for
	 * communication with the gateway. 
	 */
	function stageData() {
		$this->postdata['amount'] = $this->postdata['amount'] * 100;
		
		switch ( $this->postdata['card_type'] ) {
			case 'visa':
				$this->postdata['card_type'] = 1;
				break;
			case 'mastercard':
				$this->postdata['card_type'] = 3;
				break;
			case 'american':
				$this->postdata['card_type'] = 2;
				break;
			case 'discover':
				$this->postdata['card_type'] = 128;
				break;
		}
		
		$this->postdata['expiry'] = $this->postdata['expiration']; //. ($this->postdata['year'] % 100);
		$this->postdata['card_num'] = str_replace(' ', '', $this->postdata['card_num']);
		
		$returnto = '';
		if (array_key_exists('returnto', $this->postdata)){
			$returnto = $this->postdata['returnto'];
		} else {
			$returnto = $this->postdatadefaults['returnto'];
		}
		
		$this->postdata['returnto'] = $returnto . "?order_id=" . $this->postdata['order_id'];
		
	}

	function defineAccountInfo() {
		$this->accountInfo = array(
			'MERCHANTID' => self::getGlobal( 'MerchantID' ),
			//'IPADDRESS' => '', //TODO: Not sure if this should be OUR ip, or the user's ip. Hurm. 
			'VERSION' => "1.0",
		);
	}

	function defineVarMap() {
		$this->var_map = array(
			'ORDERID' => 'order_id',
			'AMOUNT' => 'amount',
			'CURRENCYCODE' => 'currency',
			'LANGUAGECODE' => 'language',
			'COUNTRYCODE' => 'country',
			'MERCHANTREFERENCE' => 'order_id',
			'RETURNURL' => 'returnto', //TODO: Fund out where the returnto URL is supposed to be coming from. 
			'IPADDRESS' => 'user_ip', //TODO: Not sure if this should be OUR ip, or the user's ip. Hurm.
			'PAYMENTPRODUCTID' => 'card_type',
			'CVV' => 'cvv',
			'EXPIRYDATE' => 'expiry',
			'CREDITCARDNUMBER' => 'card_num', 
			'FIRSTNAME' => 'fname',
			'SURNAME' => 'lname',
			'STREET' => 'street',
			'CITY' => 'city',
			'STATE' => 'state',
			'ZIP' => 'zip',
			'EMAIL' => 'email',
		);
	}

	function defineReturnValueMap() {
		$this->return_value_map = array(
			'OK' => true,
			'NOK' => false,
		);
	}

	function defineTransactions() {
		$this->transactions = array( );

		$this->transactions['INSERT_ORDERWITHPAYMENT'] = array(
			'request' => array(
				'REQUEST' => array(
					'ACTION',
					'META' => array(
						'MERCHANTID',
						// 'IPADDRESS',
						'VERSION'
					),
					'PARAMS' => array(
						'ORDER' => array(
							'ORDERID',
							'AMOUNT',
							'CURRENCYCODE',
							'LANGUAGECODE',
							'COUNTRYCODE',
							'MERCHANTREFERENCE'
						),
						'PAYMENT' => array(
							'PAYMENTPRODUCTID',
							'AMOUNT',
							'CURRENCYCODE',
							'LANGUAGECODE',
							'COUNTRYCODE',
							'HOSTEDINDICATOR',
							'RETURNURL',
//							'CVV',
//							'EXPIRYDATE',
//							'CREDITCARDNUMBER',
							'FIRSTNAME',
							'SURNAME',
							'STREET',
							'CITY',
							'STATE',
							'ZIP',
							'EMAIL',
						)
					)
				)
			),
			'values' => array(
				'ACTION' => 'INSERT_ORDERWITHPAYMENT',
				'HOSTEDINDICATOR' => '1'
			),
		);

		$this->transactions['TEST_CONNECTION'] = array(
			'request' => array(
				'REQUEST' => array(
					'ACTION',
					'META' => array(
						'MERCHANTID',
//							'IPADDRESS',
						'VERSION'
					),
					'PARAMS' => array( )
				)
			),
			'values' => array(
				'ACTION' => 'TEST_CONNECTION'
			)
		);
	}

	/**
	 * Take the entire response string, and strip everything we don't care about.
	 * For instance: If it's XML, we only want correctly-formatted XML. Headers must be killed off. 
	 * return a string.
	 */
	function getFormattedResponse( $rawResponse ) {
		$xmlString = $this->stripXMLResponseHeaders( $rawResponse );
		$displayXML = $this->formatXmlString( $xmlString );
		$realXML = new DomDocument( '1.0' );
		self::log( "Here is the Raw XML: " . $displayXML ); //I am apparently a huge fibber.
		$realXML->loadXML( trim( $xmlString ) );
		return $realXML;
	}

	/**
	 * Parse the response to get the status. Not sure if this should return a bool, or something more... telling.
	 */
	function getResponseStatus( $response ) {

		$aok = true;

		foreach ( $response->getElementsByTagName( 'RESULT' ) as $node ) {
			if ( array_key_exists( $node->nodeValue, $this->return_value_map ) && $this->return_value_map[$node->nodeValue] !== true ) {
				$aok = false;
			}
		}

		return $aok;
	}

	/**
	 * Parse the response to get the errors in a format we can log and otherwise deal with.
	 * return a key/value array of codes (if they exist) and messages. 
	 */
	function getResponseErrors( $response ) {
		$errors = array( );
		foreach ( $response->getElementsByTagName( 'ERROR' ) as $node ) {
			$code = '';
			$message = '';
			foreach ( $node->childNodes as $childnode ) {
				if ( $childnode->nodeName === "CODE" ) {
					$code = $childnode->nodeValue;
				}
				if ( $childnode->nodeName === "MESSAGE" ) {
					$message = $childnode->nodeValue;
				}
			}
			$errors[$code] = $message;
		}
		return $errors;
	}

	/**
	 * Harvest the data we need back from the gateway. 
	 * return a key/value array
	 */
	function getResponseData( $response ) {
		$data = array( );
		foreach ( $response->getElementsByTagName( 'ROW' ) as $node ) {
			foreach ( $node->childNodes as $childnode ) {
				if ( trim( $childnode->nodeValue ) != '' ) {
					$data[$childnode->nodeName] = $childnode->nodeValue;
				}
			}
		}
		
		foreach ( $response->getElementsByTagName( 'ORDER' ) as $node ) {
			foreach ( $node->childNodes as $childnode ) {
				if ( trim( $childnode->nodeValue ) != '' ) {
					$data['RequestOrder-' . $childnode->nodeName] = $childnode->nodeValue;
				}
			}
		}
		
		foreach ( $response->getElementsByTagName( 'PAYMENT' ) as $node ) {
			foreach ( $node->childNodes as $childnode ) {
				if ( trim( $childnode->nodeValue ) != '' ) {
					$data['RequestPayment-' . $childnode->nodeName] = $childnode->nodeValue;
				}
			}
		}
		
		
		self::log( "Returned Data: " . print_r( $data, true ) );
		return $data;
	}

	function processResponse( $response ) {
		//TODO: Stuff. 
	}

}
