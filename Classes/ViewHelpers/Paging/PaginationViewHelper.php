<?php
namespace Moc\MocHelpers\ViewHelpers\Paging;
class PaginationViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * @param integer $page
	 * @param integer $total
	 * @param integer $resultsPerPage
	 * @param integer $numberOfPagesToShow
	 * @param string $as
	 * @param integer $removeForEllipsis
	 * @return void
	 */
	public function render($page, $total, $resultsPerPage = 10, $numberOfPagesToShow = 10, $as = 'pagination', $removeForEllipsis = 2) {
		// Calculate numberOfPages based on the result count and resultsPerPage
		$numberOfPages = ceil($total / $resultsPerPage);

		// Generate "link" to all pages
		$pages = range(1, $numberOfPages);

		// Find start page
		$pageOffset = $page - floor(($numberOfPagesToShow - 1) / 2);

		// Correct page if negative
		$pageOffset = ($pageOffset < 1) ? 1 : $pageOffset;

		// Correct if page is to close to end
		$lastPage = $pageOffset + $numberOfPagesToShow - 1;
		$pageOffset = ($lastPage > $numberOfPages) ? ($numberOfPages - $numberOfPagesToShow + 1) : $pageOffset;

		// Correct page (again) if now negative
		$pageOffset = ($pageOffset < 1) ? 1 : $pageOffset;

		// Pagination
		$pagination = array_slice($pages, ($pageOffset - 1), $numberOfPagesToShow);

		// Add dots if necessary
		if (reset($pagination) > 1) {
			for ($i = 1; $i <= $removeForEllipsis; $i++) {
				array_shift($pagination);
			}
			$previousEllipsis = TRUE;
		}

		if (end($pagination) < $numberOfPages) {
			for ($i = 1; $i <= $removeForEllipsis; $i++) {
				array_pop($pagination);
			}
			$nextEllipsis = TRUE;
		}

		// Previous page
		$prevPage = ($page > 1) ? ($page - 1) : NULL;

		// Next page
		$nextPage = ($page < $numberOfPages) ? ($page + 1) : NULL;

		$pagination = array(
			'previous' => $prevPage,
			'next' => $nextPage,
			'from' => ($resultsPerPage * ($page - 1)) + 1,
			'to' => (($resultsPerPage * $page) > $total) ? $total : ($resultsPerPage * $page),
			'page' => $page,
			'total' => $total,
			'numberOfPages' => $numberOfPages,
			'pages' => $pagination,
			'previousEllipsis' => $previousEllipsis,
			'nextEllipsis' => $nextEllipsis
		);

		$this->templateVariableContainer->add($as, $pagination);

		$output = $this->renderChildren();

		$this->templateVariableContainer->remove($as);

		return $output;
	}

}