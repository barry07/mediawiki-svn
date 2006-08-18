<?php

/**
 * Internationalisation file for the Patroller extension
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Rob Church <robchur@gmail.com>
 * @copyright © 2006 Rob Church
 * @licence GNU General Public Licence 2.0
 */

function efPatrollerAddMessages( &$cache ) {
	$messages = array(
					'patrol' => 'Patrol edits',
					'patrol-endorse' => 'Endorse',
					'patrol-revert' => 'Revert',
					'patrol-revert-reason' => 'Reason:',
					'patrol-skip' => 'Skip',
					'patrol-reverting' => 'Reverting',	
					'patrol-nonefound' => 'No suitable edits could be found for patrolling.',
					'patrol-endorsed-ok' => 'The edit was marked patrolled.',
					'patrol-endorsed-failed' => 'The edit could not be marked patrolled.',
					'patrol-reverted-ok' => 'The edit was reverted.',
					'patrol-reverted-failed' => 'The edit could not be reverted.',
					'patrol-skipped-ok' => 'Ignoring edit.',
					'patrol-reasons' => "* Simple vandalism\n* Newbie test\n* See talk page",
					'patrol-another' => 'Show another edit, if available.',
					'patrol-stopped' => 'You have opted not to patrol another edit. $1',
					'patrol-resume' => 'Click here to resume.',
				);
	$cache->addMessages( $messages );
}

?>
