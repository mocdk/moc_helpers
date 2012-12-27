<?php
namespace MOC\MocHelpers\ViewHelpers;

class TitleViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * @param string $title
	 * @param boolean $notPageTitle
	 * @param boolean $notIndexedTitle
	 * @param boolean $prependPageTitle
	 * @param boolean $appendPageTitle
	 * @param string $splitString
	 * @return void
	 */
	public function render($title = '', $onlyDocumentTitle = FALSE, $onlyIndexedTitle = FALSE, $prependPageTitle = FALSE, $appendPageTitle = FALSE, $splitString = ' - ') {
		if($title === '') {
			$title = $this->renderChildren();
		}
		$title = trim(html_entity_decode($title));
		if($title !== '') {
			if($prependPageTitle || $appendPageTitle) {
				$originalTitle = empty($GLOBALS['TSFE']->cObj->data['nav_title']) ? $GLOBALS['TSFE']->cObj->data['title'] : $GLOBALS['TSFE']->cObj->data['nav_title'];
				if($prependPageTitle) {
					$title = $originalTitle . $splitString . $title;
				} else {
					$title .= $splitString . $originalTitle;
				}
			}
			if(!$onlyIndexedTitle) {
				$GLOBALS['TSFE']->altPageTitle = $title;
			}
			if(!$onlyDocumentTitle) {
				$GLOBALS['TSFE']->indexedDocTitle = $title;
			}
			$GLOBALS['TSFE']->cObj->data['title'] = $title;
		}
	}

}