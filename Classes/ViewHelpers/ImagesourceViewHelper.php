<?php
/**
 * ClickEnlarge ViewHelper for fluid
 *
 * Example:
 *      {namespace moc=Tx_MocHelpers_ViewHelpers}
 *
 *        <moc:imagesource path="path/to/image/file.ext" />
 *
 */
class Tx_MocHelpers_ViewHelpers_ImagesourceViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
    /**
     * @var tslib_cObj
     */
    protected $contentObject;

    /**
     * Constructor. Used to create an instance of tslib_cObj used by the render() method.
     *
     * @param tslib_cObj $contentObject injector for tslib_cObj (optional)
     * @return void
     */
    public function __construct($contentObject = NULL) {
        $this->contentObject = $contentObject !== NULL ? $contentObject : t3lib_div::makeInstance('tslib_cObj');
        if (TYPO3_MODE === 'BE') {
            throw new Tx_Fluid_Core_ViewHelper_Exception('ImageViewHelper does not (yet) work in backend mode' , 1253191784);
        }
    }

    /**
     * Render the img tag.
     * @see http://typo3.org/documentation/document-library/references/doc_core_tsref/4.2.0/view/1/5/#id4164427
     *
     * @param string $src
     * @param string $width width of the image. This can be a numeric value representing the fixed width of the image in pixels. But you can also perform simple calculations by adding "m" or "c" to the value. See imgResource.width for possible options.
     * @param string $height height of the image. This can be a numeric value representing the fixed height of the image in pixels. But you can also perform simple calculations by adding "m" or "c" to the value. See imgResource.width for possible options.
     * @param integer $minWidth minimum width of the image
     * @param integer $minHeight minimum height of the image
     * @param integer $maxWidth maximum width of the image
     * @param integer $maxHeight maximum height of the image
     *
     * @return string rendered tag.
     * @author Sebastian Böttger <sboettger@cross-content.com>
     * @author Bastian Waidelich <bastian@typo3.org>
     */
    public function render($src, $width = NULL, $height = NULL, $minWidth = NULL, $minHeight = NULL, $maxWidth = NULL, $maxHeight = NULL) {
        $setup = array(
            'width' => $width,
            'height' => $height,
            'minW' => $minWidth,
            'minH' => $minHeight,
            'maxW' => $maxWidth,
            'maxH' => $maxHeight
        );
        $imageInfo = $this->contentObject->getImgResource($src, $setup);
        $GLOBALS['TSFE']->lastImageInfo = $imageInfo;
        if (!is_array($imageInfo)) {
            throw new Tx_Fluid_Core_ViewHelper_Exception('Could not get image resource for "' . htmlspecialchars($src) . '".' , 1253191060);
        }
        $imageInfo[3] = t3lib_div::png_to_gif_by_imagemagick($imageInfo[3]);
        $GLOBALS['TSFE']->imagesOnPage[] = $imageInfo[3];

        $imageSource = $GLOBALS['TSFE']->absRefPrefix . t3lib_div::rawUrlEncodeFP($imageInfo[3]);
        return $imageSource;

        $this->tag->addAttribute('src', $imageSource);
        $this->tag->addAttribute('width', $imageInfo[0]);
        $this->tag->addAttribute('height', $imageInfo[1]);
        if ($this->arguments['title'] === '') {
            $this->tag->addAttribute('title', $this->arguments['alt']);
        }

        return $this->tag->render();
    }
}