<?php

class LanguageTest extends MediaWikiTestCase {
	private $lang;

	function setUp() {
		$this->lang = Language::factory( 'en' );
	}
	function tearDown() {
		unset( $this->lang );
	}

	function testLanguageConvertDoubleWidthToSingleWidth() {
		$this->assertEquals(
			"0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz",
			$this->lang->normalizeForSearch(
				"０１２３４５６７８９ＡＢＣＤＥＦＧＨＩＪＫＬＭＮＯＰＱＲＳＴＵＶＷＸＹＺａｂｃｄｅｆｇｈｉｊｋｌｍｎｏｐｑｒｓｔｕｖｗｘｙｚ"
			),
			'convertDoubleWidth() with the full alphabet and digits'
		);
	}

	function testFormatTimePeriod() {
		$this->assertEquals(
			"9.5s",
			$this->lang->formatTimePeriod( 9.45 ),
			'formatTimePeriod() rounding (<10s)'
		);

		$this->assertEquals(
			"10s",
			$this->lang->formatTimePeriod( 9.95 ),
			'formatTimePeriod() rounding (<10s)'
		);

		$this->assertEquals(
			"1m 0s",
			$this->lang->formatTimePeriod( 59.55 ),
			'formatTimePeriod() rounding (<60s)'
		);

		$this->assertEquals(
			"2m 0s",
			$this->lang->formatTimePeriod( 119.55 ),
			'formatTimePeriod() rounding (<1h)'
		);

		$this->assertEquals(
			"1h 0m 0s",
			$this->lang->formatTimePeriod( 3599.55 ),
			'formatTimePeriod() rounding (<1h)'
		);

		$this->assertEquals(
			"2h 0m 0s",
			$this->lang->formatTimePeriod( 7199.55 ),
			'formatTimePeriod() rounding (>=1h)'
		);

		$this->assertEquals(
			"2h 0m",
			$this->lang->formatTimePeriod( 7199.55, 'avoidseconds' ),
			'formatTimePeriod() rounding (>=1h), avoidseconds'
		);

		$this->assertEquals(
			"2h 0m",
			$this->lang->formatTimePeriod( 7199.55, 'avoidminutes' ),
			'formatTimePeriod() rounding (>=1h), avoidminutes'
		);

		$this->assertEquals(
			"48h 0m",
			$this->lang->formatTimePeriod( 172799.55, 'avoidseconds' ),
			'formatTimePeriod() rounding (=48h), avoidseconds'
		);

		$this->assertEquals(
			"3d 0h",
			$this->lang->formatTimePeriod( 259199.55, 'avoidminutes' ),
			'formatTimePeriod() rounding (>48h), avoidminutes'
		);

		$this->assertEquals(
			"2d 1h 0m",
			$this->lang->formatTimePeriod( 176399.55, 'avoidseconds' ),
			'formatTimePeriod() rounding (>48h), avoidseconds'
		);

		$this->assertEquals(
			"2d 1h",
			$this->lang->formatTimePeriod( 176399.55, 'avoidminutes' ),
			'formatTimePeriod() rounding (>48h), avoidminutes'
		);

		$this->assertEquals(
			"3d 0h 0m",
			$this->lang->formatTimePeriod( 259199.55, 'avoidseconds' ),
			'formatTimePeriod() rounding (>48h), avoidminutes'
		);

		$this->assertEquals(
			"2d 0h 0m",
			$this->lang->formatTimePeriod( 172801.55, 'avoidseconds' ),
			'formatTimePeriod() rounding, (>48h), avoidseconds'
		);

		$this->assertEquals(
			"2d 1h 1m 1s",
			$this->lang->formatTimePeriod( 176460.55 ),
			'formatTimePeriod() rounding, recursion, (>48h)'
		);
	}

	/**
	 * Test Language::isValidBuiltInCode()
	 * @dataProvider provideLanguageCodes
	 */
	function testBuiltInCodeValidation( $code, $message = '' ) {
		$this->assertTrue(
			(bool) Language::isValidBuiltInCode( $code ),
			"validating code $code $message"
		);
	}

	function testBuiltInCodeValidationRejectUnderscore() {
		$this->assertFalse(
			(bool) Language::isValidBuiltInCode( 'be_tarask' ),
			"reject underscore in language code"
		);
	}

	function provideLanguageCodes() {
		return array(
			array( 'fr'       , 'Two letters, minor case' ),
			array( 'EN'       , 'Two letters, upper case' ),
			array( 'tyv'      , 'Three letters' ),
			array( 'tokipona'   , 'long language code' ),
			array( 'be-tarask', 'With dash' ),
			array( 'Zh-classical', 'Begin with upper case, dash' ),
			array( 'Be-x-old', 'With extension (two dashes)' ),
		);
	}
}
