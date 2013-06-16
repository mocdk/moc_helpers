<?php
namespace MOC\MocHelpers\ViewHelpers\Uri;

/**
 * Class ImageViewHelper
 */
class ImageViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Uri\ImageViewHelper {

	/**
	 * Resizes the image (if required) and returns its path. If the image was not resized, the path will be equal to $src
	 *
	 * @param string $src
	 * @param string $width width of the image. This can be a numeric value representing the fixed width of the image in pixels. But you can also perform simple calculations by adding "m" or "c" to the value. See imgResource.width for possible options.
	 * @param string $height height of the image. This can be a numeric value representing the fixed height of the image in pixels. But you can also perform simple calculations by adding "m" or "c" to the value. See imgResource.width for possible options.
	 * @param integer $minWidth minimum width of the image
	 * @param integer $minHeight minimum height of the image
	 * @param integer $maxWidth maximum width of the image
	 * @param integer $maxHeight maximum height of the image
	 * @param boolean $treatIdAsReference given src argument is a sys_file_reference record
	 * @param boolean $absolute external path to image
	 * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
	 * @return string path to the image
	 */
	public function render($src, $width = NULL, $height = NULL, $minWidth = NULL, $minHeight = NULL, $maxWidth = NULL, $maxHeight = NULL, $treatIdAsReference = FALSE, $absolute = FALSE) {
		$uri = parent::render($src, $width, $height, $minWidth, $minHeight, $maxWidth, $maxHeight);

		if ($absolute === TRUE) {
			$uri = $this->controllerContext->getRequest()->getBaseURI() . $uri;
		}

		return $uri;
	}

}