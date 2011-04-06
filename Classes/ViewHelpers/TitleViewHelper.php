<?php
class Tx_MocHelpers_ViewHelpers_TitleViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * @param string $title
	 * @param boolean $notPageTitle
	 * @param boolean $notIndexedTitle
	 * @param boolean $prependPageTitle
	 * @param boolean $appendPageTitle
	 * @param string $splitString
	 */
	public function render($title = '', $onlyDocumentTitle = false, $onlyIndexedTitle = false, $prependPageTitle = false, $appendPageTitle = false, $splitString = ' - ') {
		if($title === '') {
			$title = $this->renderChildren();
		}
		if(trim($title) !== '') {
			if($prependPageTitle || $appendPageTitle) {
				$originalTitle = empty($GLOBALS['TSFE']->cObj->data['nav_title']) ? $GLOBALS['TSFE']->cObj->data['title'] : $GLOBALS['TSFE']->cObj->data['nav_title'];
				if($prependPageTitle) {
					$title = $originalTitle.$splitString.$title;
				} else {
					$title .= $splitString.$originalTitle;
				}
			}
			if(!$onlyIndexedTitle) {
				$GLOBALS['TSFE']->altPageTitle = $title;
			}
			if(!$onlyDocumentTitle) {
				$GLOBALS['TSFE']->indexedDocTitle = $title;
			}
		}
	}

}