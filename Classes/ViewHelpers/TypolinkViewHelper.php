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
class TypolinkViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

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
	 * @param string $title
	 * @param string $class
	 * @param string $ATagParams
	 * @return string content wrapped in link
	 */
	public function render($parameter, $additionalParams='', $title='', $class='', $ATagParams='') {
		$conf['parameter'] = $parameter;
		$conf['title'] = $title;
		$conf['additionalParams'] = $additionalParams;
		if(!empty($class)) {
			$conf['ATagParams'] = sprintf('class="%s"', $class);
		}
		if(!empty($ATagParams)) {
			$conf['ATagParams'] = $conf['ATagParams'] . ' ' . $ATagParams;
		}
		if(stristr($parameter, '.')) {
			$conf['extTarget'] = '_blank';
		}

		return str_replace('target="_blank"', 'rel="external"', $this->cObj->typolink($this->renderChildren(), $conf));
	}

}