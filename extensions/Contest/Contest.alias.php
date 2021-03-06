<?php

/**
 * Aliases for the special pages of the Contest extension.
 *
 * @since 0.1
 *
 * @file Contest.alias.php
 * @ingroup Contest
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

$specialPageAliases = array();

/** English (English) */
$specialPageAliases['en'] = array(
	'Contest' => array( 'Contest' ),
	'Contestant' => array( 'Contestant' ),
	'Contests' => array( 'Contests' ),
	'ContestSignup' => array( 'ContestSignup' ),
	'ContestWelcome' => array( 'ContestWelcome' ),
	'EditContest' => array( 'EditContest' ),
	'MyContests' => array( 'MyContests', 'ContestSubmission', 'My contests' ),
);
