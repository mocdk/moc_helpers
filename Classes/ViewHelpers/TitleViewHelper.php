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
	 * @param unknown_type $notPageTitle
	 * @param unknown_type $notIndexedTitle
	 * @api
	 */
	public function render($onlyDocumentTitle=false,$onlyIndexedTitle=false) {
		$title = $this->renderChildren();
		
		if(!$onlyIndexedTitle) {
			$GLOBALS['TSFE']->altPageTitle = $title;
		}
		if(!$onlyDocumentTitle) {
			$GLOBALS['TSFE']->indexedDocTitle = $title;
		}
	}
}

?>
