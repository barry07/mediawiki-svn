<?php

class ComScoreUniqueVisitorMetric extends ApiAnalyticsBase {

	public function getAllowedFilters() {
		return array(
			'selectregions',
			'selectcountries',
		);
	}

	public function getDescription() {
		return 'Unique persons that visited one of the Wikimedia wikis at least once in a certain month';
	}

	protected function getExamples() {
		return array(
			'api.php?action=analytics&metric=',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}
}
