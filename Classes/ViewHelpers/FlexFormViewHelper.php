<?php
class Tx_MocHelpers_ViewHelpers_FlexFormViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * @param string $flexForm
	 * @return array
	 */
	public function render($flexForm = '') {
		return t3lib_div::makeInstance('Tx_Extbase_Service_FlexFormService')->convertFlexFormContentToArray($flexForm === '' ? $this->renderChildren() : $flexForm);
	}

}