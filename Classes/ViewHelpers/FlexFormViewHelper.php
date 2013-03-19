<?php
class Tx_MocHelpers_ViewHelpers_FlexFormViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * @var Tx_Extbase_Service_FlexFormService
	 */
	protected $flexFormService;

	/**
	 * @param Tx_Extbase_Service_FlexFormService $flexFormService
	 * @return void
	 */
	public function injectFlexFormService(Tx_Extbase_Service_FlexFormService $flexFormService) {
		$this->flexFormService = $flexFormService;
	}

	/**
	 * @param string $flexForm
	 * @return array
	 */
	public function render($flexForm = '') {
		return $this->flexFormService->convertFlexFormContentToArray($flexForm === '' ? $this->renderChildren() : $flexForm);
	}

}