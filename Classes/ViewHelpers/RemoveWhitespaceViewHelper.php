<?php
class Tx_MocHelpers_ViewHelpers_RemoveWhitespaceViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * Removes all whitespace from a text.
	 *
	 * @param string $title
	 * @return string $text
	 */
	public function render($text = '') {

		if ($text !== '') {
			$text = preg_replace('/\s+/', '', $text);
		} else {
			$text = preg_replace('/\s+/', '', $this->renderChildren());
		}

		return $text;
	}

}