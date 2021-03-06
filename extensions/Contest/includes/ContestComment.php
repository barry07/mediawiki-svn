<?php

/**
 * Class representing a single contest comment.
 * Comments can be made by judges on (submissions of) contestants.
 *
 * @since 0.1
 *
 * @file ContestComment.php
 * @ingroup Contest
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ContestComment extends ContestDBObject {

	/**
	 * Method to get an instance so methods that ought to be static,
	 * but can't be due to PHP 5.2 not having LSB, can be called on
	 * it. This also allows easy identifying of code that needs to
	 * be changed once PHP 5.3 becomes an acceptable requirement.
	 *
	 * @since 0.1
	 *
	 * @return ContestDBObject
	 */
	public static function s() {
		static $instance = false;

		if ( $instance === false ) {
			$instance = new self( array() );
		}

		return $instance;
	}

	/**
	 * Get a new instance of the class from an array.
	 * This method ought to be in the basic class and
	 * return a new static(), but this requires LSB/PHP>=5.3.
	 *
	 * @since 0.1
	 *
	 * @param array $data
	 * @param boolean $loadDefaults
	 *
	 * @return ContestDBObject
	 */
	public function newFromArray( array $data, $loadDefaults = false ) {
		return new self( $data, $loadDefaults );
	}

	/**
	 * @see parent::getFieldTypes
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getDBTable() {
		return 'contest_comments';
	}

	/**
	 * @see parent::getFieldTypes
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	protected function getFieldPrefix() {
		return 'comment_';
	}

	/**
	 * @see parent::getFieldTypes
	 *
	 * @since 0.1
	 *
	 * @return array
	 */
	protected function getFieldTypes() {
		return array(
			'id' => 'id',
			'contestant_id' => 'id',
			'user_id' => 'id',

			'text' => 'str',
			'time' => 'int',
		);
	}

	/**
	 * @see parent::getDefaults
	 *
	 * @since 0.1
	 *
	 * @return array
	 */
	public function getDefaults() {
		return array(
			'text' => '',
			'time' => 0,
		);
	}

	/**
	 * (non-PHPdoc)
	 * @see ContestDBObject::insertIntoDB()
	 * @return bool
	 */
	protected function insertIntoDB() {
		$success = parent::insertIntoDB();

		if ( $success ) {
			$contestant = new ContestContestant( array( 'id' => $this->getField( 'contestant_id' ) ) );
			$contestant->addToField( 'comments', 1 );
		}

		return $success;
	}

}
