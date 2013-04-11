<?php
/**
 * Slugify view helper to generate dom IDs/url slugs
 */
class Tx_MocHelpers_ViewHelpers_Format_SlugifyViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * Slugifies a value
	 *
	 * @param string $value The value to be processed
	 * @param array $replace The replace array (keys will be replaced with values)
	 * @return string $value
	 */
	public function render($value = '', array $replace = array('æ' => 'ae', 'Æ' => 'ae', 'ø' => 'oe', 'Ø' => 'oe', 'å' => 'aa', 'Å' => 'aa')) {
		$value = $value === '' ? $this->renderChildren() : $value;

		if (empty($replace) === FALSE) {
			$value = strtr($value, $replace);
		}

			// Replace non letter or digits by -
		$value = preg_replace('~[^\\pL\d]+~u', '-', $value);

			// Trim incl. dashes
		$value = trim($value, '-');

			// Transliterate
		if (function_exists('iconv') === TRUE) {
			$value = iconv('utf-8', 'us-ascii//TRANSLIT', $value);
		}

			// Lowercase
		$value = strtolower($value);

			// Remove unwanted characters
		$value = preg_replace('~[^-\w]+~', '', $value);

		return $value;
	}

}