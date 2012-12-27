<?php
namespace MOC\MocHelpers\ViewHelpers;

/**
 * Typolink URL view helper for Fluid
 *
 * Example:
 * 		{namespace moc=MOC\MocHelpers\ViewHelpers}
 *
 *		  <moc:typolinkUrl configuration="{parameter: pageUid}" />
 *
 */
class TypolinkUrlViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * @param array $configuration
	 * @return string
	 */
	public function render($configuration) {
		return $GLOBALS['TSFE']->cObj->typolink_URL($configuration);
	}

}