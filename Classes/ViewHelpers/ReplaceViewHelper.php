<?php
/**
 * Replace ViewHelper for fluid replace everything through a regex match
 */
class Tx_MocHelpers_ViewHelpers_ReplaceViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * Replace a value
	 *
	 * @param string $value The value to be processed
	 * @param string $pattern A regex pattern
	 * @param string $replace The replacement values
	 * @return string $value
	 */
	public function render($value = '', $pattern = '', $replace = '') {
		return preg_replace($pattern, $replace, $value === '' ? $this->renderChildren() : $value);
	}

}