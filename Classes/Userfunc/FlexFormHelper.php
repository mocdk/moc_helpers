<?php
/**
 * This flex form helper makes it possible to access flexform values from TypoScript.
 *
 * Example:
 * 10 = USER
 * 10.userFunc = Tx_MocHelpers_Userfunc_FlexFormHelper->convert
 * 10.path = language
 * 10.field = pi_flexform (optional)
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
		$flexFormField = isset($configuration['field']) ? $configuration['field'] : 'pi_flexform';
		$flexForm = $flexFormService->convertFlexFormContentToArray(isset($this->pObj->data[$flexFormField]) ? $this->pObj->data[$flexFormField] : '');
		return isset($configuration['path']) ? Tx_Extbase_Utility_Arrays::getValueByPath($flexForm, $configuration['path']) : $flexForm;
	}

	/**
	 * Convert the current page flex form data
	 *
	 * 10 = USER
	 * 10.userFunc = Tx_MocHelpers_Userfunc_FlexFormHelper->convert
	 * 10.configuration {
	 *     tableField = pi_flexform
	 *     flexFormField = language
	 * }
	 * 
	 * @param string $content
	 * @param array $configuration
	 * @return mixed
	 */
	public function convertCurrentPageFlexForm($content, array $configuration) {

		$tableField = $configuration['configuration.']['tableField'];
		$flexFormField = $configuration['configuration.']['flexFormField'];

		// Make sure that the field and flex form field is set before processing it
		if ($tableField !== NULL && $flexFormField !== NULL) {

			$flexFormService = t3lib_div::makeInstance('Tx_Extbase_Service_FlexFormService');
			list($table, $uid) = t3lib_div::trimExplode(':', $GLOBALS['TSFE']->currentRecord, 1);
			$record = $GLOBALS['TSFE']->sys_page->getRawRecord($table, $uid);
			$flexFormXML = $record[$tableField];
			$flexForm = $flexFormService->convertFlexFormContentToArray($flexFormXML);

			return isset($flexForm[$flexFormField]) ? $flexForm[$flexFormField] : 0;
		} else {
			return;
		}
	}

}