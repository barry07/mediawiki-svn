<?php

/**
 * Internationalisation file for the BackAndForth extension
 *
 * @author Rob Church <robchur@gmail.com>
 */

/**
 * Fetch extension messages indexed per language
 *
 * @return array
 */
function efBackAndForthMessages() {
	$messages = array(

'en' => array(
	'backforth-next' => 'Next ($1)',
	'backforth-prev' => 'Previous ($1)',
),

'ar' => array(
	'backforth-next' => 'التالي ($1)',
	'backforth-prev' => 'السابق ($1)',
),

'bcl' => array(
	'backforth-next' => 'Sunod ($1)',
	'backforth-prev' => 'Nakaagi ($1)',
),

'br' => array(
	'backforth-next' => 'War-lerc\'h ($1)',
	'backforth-prev' => 'Kent ($1)',
),

'de' => array(
	'backforth-next' => 'Nächste ($1)',
	'backforth-prev' => 'Vorherige ($1)',
),

'eo' => array(
	'backforth-next' => 'Sekva ($1)',
	'backforth-prev' => 'Antaŭa ($1)',
),

'ext' => array(
	'backforth-next' => 'Siguienti ($1)',
),

'fi' => array(
	'backforth-next' => 'Seuraava ($1)',
	'backforth-prev' => 'Edellinen ($1)',
),

'frp' => array(
	'backforth-next' => 'Siuventa ($1)',
	'backforth-prev' => 'Prècèdenta ($1)',
),

'gl' => array(
	'backforth-next' => 'Seguinte ($1)',
	'backforth-prev' => 'Anterior ($1)',
),

'hsb' => array(
	'backforth-next' => 'Přichodne ($1)',
	'backforth-prev' => 'Předchadne ($1)',
),

'it' => array(
	'backforth-next' => 'Successivi ($1)',
	'backforth-prev' => 'Precedenti ($1)',
),

'nl' => array(
	'backforth-next' => 'Volgende ($1)',
	'backforth-prev' => 'Vorige ($1)',
),

'no' => array(
	'backforth-next' => 'Neste ($1)',
	'backforth-prev' => 'Forrige ($1)',
),

'oc' => array(
	'backforth-next' => 'Seguent ($1)',
	'backforth-prev' => 'Precedent ($1)',
),

'sah' => array(
	'backforth-next' => 'Аныгыскы ($1)',
	'backforth-prev' => 'Иннинээҕи ($1)',
),

'scn' => array(
	'backforth-next' => 'Succissivi ($1)',
	'backforth-prev' => 'Pricidenti ($1)',
),

'sk' => array(
	'backforth-next' => 'Ďalšie ($1)',
	'backforth-prev' => 'Predošlé ($1)',
),

'sv' => array(
	'backforth-next' => 'Nästa ($1)',
	'backforth-prev' => 'Föregående ($1)',
),

'yue' => array(
	'backforth-next' => '下一篇 ($1)',
	'backforth-prev' => '上一篇 ($1)',
),

'zh-hans' => array(
	'backforth-next' => '下一条 ($1)',
	'backforth-prev' => '上一条 ($1)',
),

'zh-hant' => array(
	'backforth-next' => '下一條 ($1)',
	'backforth-prev' => '上一條 ($1)',
),

	);

	/* Chinese defaults, fallback to zh-hans or zh-hant */
	$messages['zh'] = $messages['zh-hans'];
	$messages['zh-cn'] = $messages['zh-hans'];
	$messages['zh-hk'] = $messages['zh-hant'];
	$messages['zh-sg'] = $messages['zh-hans'];
	$messages['zh-tw'] = $messages['zh-hant'];
	/* Cantonese default, fallback to yue */
	$messages['zh-yue'] = $messages['yue'];

	return $messages;
}
