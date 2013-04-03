<?php
/**
 * This flex form helper makes it possible to access flexform values from TypoScript.
 *
 * Example:
 * 10 = USER
 * 10.userFunc = Tx_MocHelpers_Userfunc_FlexFormHelper->convert
 * 10.path = language
 * 10.value.field = pi_flexform (optional)
 */
class Tx_MocHelpers_Userfunc_FlexFormHelper {

	/**
	 * @var tslib_cObj
	 */
	public $pObj;

	/**
	 * @param string $content
	 * @param array $configuration
	 * @return mixed
	 */
	public function convert($content, array $configuration) {
		$flexFormService = t3lib_div::makeInstance('Tx_Extbase_Service_FlexFormService');
		if (isset($configuration['value'])) {
			$flexFormData = $this->pObj->stdWrap($configuration['value'], $configuration['value.']);
		} else {
			$flexFormData = isset($this->pObj->data['pi_flexform']) ? $this->pObj->data['pi_flexform'] : '';
		}
		$flexForm = $flexFormService->convertFlexFormContentToArray($flexFormData);
		return isset($configuration['path']) ? Tx_Extbase_Utility_Arrays::getValueByPath($flexForm, $configuration['path']) : $flexForm;
	}

}