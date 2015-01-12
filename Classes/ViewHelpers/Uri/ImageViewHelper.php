<?php
namespace Moc\MocHelpers\ViewHelpers\Uri;
class ImageViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Uri\ImageViewHelper {

	/**
	 * Resizes the image (if required) and returns its path. If the image was not resized, the path will be equal to $src
	 * @see http://typo3.org/documentation/document-library/references/doc_core_tsref/4.2.0/view/1/5/#id4164427
	 *
	 * @param string $src
	 * @param string $width width of the image. This can be a numeric value representing the fixed width of the image in pixels. But you can also perform simple calculations by adding "m" or "c" to the value. See imgResource.width for possible options.
	 * @param string $height height of the image. This can be a numeric value representing the fixed height of the image in pixels. But you can also perform simple calculations by adding "m" or "c" to the value. See imgResource.width for possible options.
	 * @param integer $minWidth minimum width of the image
	 * @param integer $minHeight minimum height of the image
	 * @param integer $maxWidth maximum width of the image
	 * @param integer $maxHeight maximum height of the image
	 * @param integer $absolute external path to image
	 * @return string path to the image
	 * @author Bastian Waidelich <bastian@typo3.org>
	 * @author Christian Baer <chr.baer@googlemail.com> - extended by Nikolaj Pedersen - 20-10-2011 <nikolaj@moc.net>
	 */
	public function render($src, $width = NULL, $height = NULL, $minWidth = NULL, $minHeight = NULL, $maxWidth = NULL, $maxHeight = NULL, $absolute = FALSE) {

		$uri = parent::render($src, $width, $height, $minWidth, $minHeight, $maxWidth, $maxHeight);

		if ($absolute) {
			$uri = $this->controllerContext->getRequest()->getBaseURI() . $uri;
		}

		return $uri;
	}
}
