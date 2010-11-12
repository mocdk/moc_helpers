<?php
/**
 * Pagination viewhelper for fluid templates. Returns the lowerbound for the navigation.
 * 
 * 
 *
 * @author Jan-Erik Revsbech <janerik@mocsystems.com>
 *
 *
 *
 * Example:
 * 		{namespace moc=Tx_MocHelpers_ViewHelpers}
 * Viser <moc:paging.lowerBound  currentPage="{resultData.currentPage}" resultsPerPage="10" />-<moc:paging.upperBound totalResults="{resultData.totalCount}" currentPage="{resultData.currentPage}" resultsPerPage="10"/> ud af {resultData.totalCount} resultater
 *
 */

class Tx_MocHelpers_ViewHelpers_Paging_UpperBoundViewHelper  extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	public function __construct(){

	}
	/**
	 * @param Integer $totalResults
	 * @param Integer $currentPage Starting at 1
	 * @param Integer $resultsPerPage
	 * @param Integer $returnUpperBound
	 * @return MixIntegered
	 */
	public function render($totalResults,$currentPage=1,$resultsPerPage=10){
		$upperBound = ($currentPage)*$resultsPerPage;
		if($upperBound>$totalResults) {
			$upperBound = $totalResults;
		}
		return $upperBound;
	}
}