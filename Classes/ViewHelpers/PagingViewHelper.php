<?php
namespace Moc\MocHelpers\ViewHelpers;
/**
 * Pagination viewhelper for fluid templates. Used for constructing pagination bar/links for lists.
 *
 * Is generlized from ViewHelper for SMK, but with some addition.
 *
 * @author Christian Jul Jensen <christian@mocsystems.com>
 * @author Jan-Erik Revsbech <janerik@mocsystems.com>
 *
 *
 *
 * Example:
 * 		{namespace moc=Tx_MocHelpers_ViewHelpers}
 *
 *		<li class="prev">
 *			<f:if condition="{resultData.currentPage} > 1">
 *				<f:then>
 *					<f:link.action addQueryString="true" arguments="{page: resultData.currentPage}"><f:translate key="navigation.previous" /></f:link.action>|
 *				</f:then>
 *				<f:else>
 *
 *				</f:else>
 *			</f:if>
 *		</li>
 *
 *		<f:for each="{moc:paging(totalResults: resultData.totalCount currentPage: resultData.currentPage resultsPerPage: 10)}" as="page" key="key">
 *			<li class="page_{page}">
 *				<f:if condition="{resultData.currentPage} == {page}">
 *					<f:then><strong><a>{page}</a></strong>|</f:then>
 *					<f:else>
 *						<f:if condition="{page} < 0 ">
 *							<f:then><a>&#8230;</a>|</f:then>
 *							<f:else>
 *								<f:link.action addQueryString="true" arguments="{page: page}">{page}</f:link.action>|
 *							</f:else>
 *						</f:if>
 *					</f:else>
 *				</f:if>
 *			</li>
 *
 *		</f:for>
 *
 *		<li class="next">
 *			<f:if condition="{resultData.currentPage} < {resultData.totalCount}">
 *				<f:then>
 *					<f:link.action addQueryString="true" arguments="{page: resultData.currentPage}"><f:translate  key="navigation.next" />&nbsp;&gt;</f:link.action>
 *				</f:then>
 *			<f:else>
 *
 *				</f:else>
 *			</f:if>
 *		</li>
 *
 *
 */
class PagingViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * @param integer $totalResults
	 * @param integer $currentPage
	 * @param integer $resultsPerPage
	 * @param integer $numberOfPagesToShow
	 * @return array
	 */
	public function render($totalResults, $currentPage = 1, $resultsPerPage = 10, $numberOfPagesToShow = 10){
		$numberOfPages = ceil($totalResults / $resultsPerPage);
		$pageRange = array();
		if ($numberOfPages > 2) {
			$numberOfPagesToShow -= 2;
			$pageRange = $this->findPageRange($numberOfPages, $currentPage, $numberOfPagesToShow);
		}
		if ($numberOfPages > 0) {
			array_unshift($pageRange, 1);
		}
		array_push($pageRange, $numberOfPages);

		return $pageRange;
	}

	protected function findPageRange($numberOfPages, $currentPage, $numberOfPagesToShow) {
		$halfThePagesToShow = floor($numberOfPagesToShow / 2);
		if (($numberOfPages <= $numberOfPagesToShow) || ($currentPage <= $halfThePagesToShow)) {
			$pageRange = range(2, min($numberOfPagesToShow + 1,$numberOfPages-1));
		} elseif($currentPage >= ($numberOfPages - $halfThePagesToShow)) {
			$pageRange = range($numberOfPages - $numberOfPagesToShow, $numberOfPages - 1);
		} else {
			$startIndex = $currentPage - $halfThePagesToShow + 1;
			$startIndex = max(2, $startIndex);
			$pageRange = range($startIndex, $startIndex + $numberOfPagesToShow - 1);
		}

		if ($pageRange[0] != 2) {
			$pageRange[0] = -1;
		}

		$lastEntry = $numberOfPagesToShow - 1;

		if($pageRange[$lastEntry] != ($numberOfPages-1) && intval($pageRange[$lastEntry])) {
			$pageRange[$lastEntry] = -1;
		}

		return $pageRange;
	}

}