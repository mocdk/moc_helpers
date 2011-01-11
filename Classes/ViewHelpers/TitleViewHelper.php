<?php
/**
 * Title ViewHelper for fluid
 *
 * Example:
 * 		{namespace moc=Tx_MocHelpers_ViewHelpers}
 *
 *		  <moc:title>Title of Page and Indexing</moc:title>
 *		  <moc:title onlyIndexedTitle="1">Title of Page and Indexing</moc:title>
 */
class Tx_MocHelpers_ViewHelpers_TitleViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * @param boolean $notPageTitle
	 * @param boolean $notIndexedTitle
	 * @param boolean $appendPageTitle
	 */
	public function render($onlyDocumentTitle = false, $onlyIndexedTitle = false, $appendPageTitle = false) {
		$title = $this->renderChildren();
		
		if($appendPageTitle) {
			$title .= empty($GLOBALS['TSFE']->cObj->data['nav_title']) ? $GLOBALS['TSFE']->cObj->data['title'] : $GLOBALS['TSFE']->cObj->data['nav_title'];
		}

		if(!$onlyIndexedTitle) {
			$GLOBALS['TSFE']->altPageTitle = $title;
		}
		if(!$onlyDocumentTitle) {
			$GLOBALS['TSFE']->indexedDocTitle = $title;
		}
	}

}