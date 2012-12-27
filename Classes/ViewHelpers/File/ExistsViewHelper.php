<?php
namespace MOC\MocHelpers\ViewHelpers\File;

class ExistsViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

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
