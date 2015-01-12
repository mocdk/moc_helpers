<?php
namespace Moc\MocHelpers\ViewHelpers;
/**
 * Typolink ViewHelper for fluid
 *
 * Example:
 * 		{namespace moc=Tx_MocHelpers_ViewHelpers}
 *
 *		  <moc:typolink parameter="{TypolinkCompatibleParameter}" />
 *
 */
class TypolinkUrlViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 *
	 * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
	 */
	static private $cObj;

	public function __construct() {
		if(!$this->cObj instanceof \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer) {
			$this->cObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer');
		}

	}


	/**
	 * @param string $parameter
	 * @param string $additionalParams
	 * @return string URI
	 */
	public function render($parameter,$additionalParams='') {
		$conf['parameter'] = $parameter;
		$conf['additionalParams'] = $additionalParams;
		return $this->cObj->typolink_URL($conf);
	}

}