<?php
class Tx_MocHelpers_ViewHelpers_RemoveWhitespaceViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * Removes all whitespace from a text.
	 *
	 * @param string $title
	 * @return mixed $text
	 */
	public function render($text = '') {

		if ($text !== '') {
			$text = preg_replace('/\s+/', '', $text);
		} else {
			$text = $this->renderChildren();
		}

		return $text;
	}

}