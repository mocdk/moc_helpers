<?php
class Tx_MocHelpers_ViewHelpers_File_ExistsViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractConditionViewHelper {

	/**
	 * Check if a file exists
	 *
	 * @param string $file File to check against
	 * @return boolean TRUE if $file exists, FALSE if it doesn't
	 */
	public function render($file) {
		return file_exists($file);
	}

}
