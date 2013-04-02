<?php
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
		$flexForm = $flexFormService->convertFlexFormContentToArray(isset($pObj->data[$configuration]) ? $pObj->data[$configuration] : '');
		return isset($configuration['path']) ? Tx_Extbase_Utility_Arrays::getValueByPath($flexForm, $configuration['path']) : $flexForm;
	}

}