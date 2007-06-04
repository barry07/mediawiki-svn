<?php
/**
 * This file contains classes that are used for representing query results,
 * basically several containers/iterators for accessing all parts of a query result.
 * These classes might once be replaced by interfaces that are implemented
 * by storage-specific classes if this is useful (e.g. for performance gains by
 * lazy retrieval).
 *
 * @author Markus Krötzsch
 */

/**
 * Objects of this class encapsulate the result of a query in SMW. They
 * provide access to the query result and printed data, and to some
 * relevant query parameters that were used.
 * 
 * While the API does not require this, it is ensured that every result row 
 * returned by this object has the same number of elements (columns).
 */
class SMWQueryResult {
	protected $content; //an array (table) of arrays (rows) of arrays (fields, SMWResultArray)
	protected $printrequests; //an array of SMWPrintRequest objects, indexed by their natural hash keys
	protected $furtherres;

	/**
	 * Initialise the object with an array of SMWPrintRequest objects, which
	 * define the structure of the result "table" (one for each column).
	 */
	public function SMWQueryResult($printrequests, $furtherres=false) {
		$this->content = array();
		$this->printrequests = $printrequests;
		$this->furtherres = $furtherres;
	}

	/**
	 * Checks whether it conforms to the given schema of print requests, adds the
	 * row to the result, and returns true. Otherwise returns false.
	 * TODO: should we just skip the checks and trust our callers?
	 */
	public function addRow($row) {
		reset($row);
		reset($this->printrequests);
		$pr = current($this->printrequests);
		$ra = current($row);

		while ( $pr !== false ) {
			if (!($ra instanceof SMWResultArray)) {
				return false;
			}
			//compare print-request signatures:
			if ($pr->getHash() !== $ra->getPrintRequest()->getHash()) {
				return false;
			}
			$pr = next($this->printrequests);
			$ra = next($row);
		}
		if ($ra !== false) {
			return false;
		}
		$this->content[] = $row;
		reset($this->content);
		return true;
	}


	/**
	 * Return the next result row as an array of
	 * SMWResultArray objects.
	 */
	public function getNext() {
		$result = current($this->content);
		next($this->content);
		return $result;
	}

	/**
	 * Return number of available results.
	 */
	public function getCount() {
		return count($this->content);
	}

	/**
	 * Return the number of columns of result values that each row 
	 * in this result set contains.
	 */
	public function getColumnCount() {
		return count($this->printrequests);
	}

	/**
	 * Return array of print requests (needed for printout since they contain 
	 * property labels).
	 */
	public function getPrintRequests() {
		return $this->printrequests;
	}

	/**
	 * Would there be more query results that were 
	 * not shown due to a limit?
	 */
	public function hasFurtherResults() {
		return $this->furtherres;
	}

	/**
	 * Return URL of a page that displays those search results
	 * (and enables browsing results, and is accessible even without
	 * JavaScript enabled browsers).
	 */
	public function getQueryURL() {
		/// TODO implement (requires some way of generating/maintaining this URL as part of the query, and setting it when creating this result)
	}
}

/**
 * Container for the contents of a single result field of a query result,
 * i.e. basically an array of Titles or SMWDataValues with some additional
 * parameters.
 */
class SMWResultArray {
	protected $printrequest;
	protected $content;
	protected $furtherres;

	public function SMWResultArray($content, SMWPrintRequest $printrequest, $furtherres = false) {
		$this->content = $content;
		reset($this->content);
		$this->printrequest = $printrequest;
		$this->furtherres = $furtherres;
	}

	/**
	 * Returns an array of objects. Depending on the type of 
	 * results, they are either Titles or SMWDataValues.
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * Return the next result object (Title or SMWDataValue).
	 */
	public function getNextObject() {
		$result = current($this->content);
		next($this->content);
		return $result;
	}

	/**
	 * Return the main text representation of the next result object 
	 * (Title or SMWDataValue). Convenience method that would not be
	 * required if Titles would be but special SMWDataValues.
	 */
	public function getNextText() {
		$object = current($this->content);
		next($this->content);
		if ($object instanceof SMWDataValue) { //print data values
			return $object->getStringValue();
		} elseif ($object instanceof Title) { // print Title objects
			return $object->getPrefixedText(); ///TODO: support optional linking of titles
			/// As long as SMWDataValue is not re-implemented to support linking and optional HTML,
			/// all solutions here can only be hacks, returning complete HTML links based on some
			/// Boolean parameter.
		} else {
			return false;
		}
	}

	/**
	 * Would there be more query results that were 
	 * not shown due to a limit?
	 */
	public function hasFurtherResults() {
		return $this->furtherres;
	}

	/**
	 * Return an SMWPrintRequest object describing what is contained in this
	 * result set.
	 */
	public function getPrintRequest() {
		return $this->printrequest;
	}
}

?>