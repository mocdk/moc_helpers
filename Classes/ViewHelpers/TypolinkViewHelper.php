<?php
namespace MOC\MocHelpers\ViewHelpers;

/**
 * Typolink view helper for Fluid
 *
 * Example:
 * {namespace moc=MOC\MocHelpers\ViewHelpers}
 * <moc:typolink configuration="{parameter: pageUid, ATagParams: 'class=\"link\"'}" />
 */
class TypolinkViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * @param array $configuration
	 * @return string
	 */
	public function render($configuration) {
		return $GLOBALS['TSFE']->cObj->typolink($this->renderChildren(), $configuration);
	}

}