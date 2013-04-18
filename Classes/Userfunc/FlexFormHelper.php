<?php
namespace MOC\MocHelpers\Userfunc;

/**
 * This flex form helper makes it possible to access flexform values from TypoScript.
 *
 * Example:
 * 10 = USER
 * 10.userFunc = MOC\MocHelpers\Userfunc\FlexFormHelper->convert
 * 10.path = language
 * 10.value = TEXT (optional)
 * 10.value.field = page:pi_flexform
 */
class FlexFormHelper {

	/**
	 * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
	 */
	public $cObj;

	/**
	 * @param string $content
	 * @param array $configuration
	 * @return mixed
	 */
	public function convert($content, array $configuration) {
		$flexFormService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Service\FlexFormService');
		if (isset($configuration['value'])) {
			$flexFormData = isset($configuration['value.']) ? $this->cObj->stdWrap($configuration['value'], $configuration['value.']) : $configuration['value'];
		} else {
			$flexFormData = isset($this->cObj->data['pi_flexform']) ? $this->cObj->data['pi_flexform'] : '';
		}
		$flexForm = $flexFormService->convertFlexFormContentToArray($flexFormData);
		return isset($configuration['path']) ? \TYPO3\CMS\Extbase\Utility\ArrayUtility::getValueByPath($flexForm, explode('.', $configuration['path'])) : $flexForm;
	}

}