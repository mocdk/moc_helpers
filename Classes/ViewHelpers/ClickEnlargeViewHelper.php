<?php
namespace MOC\MocHelpers\ViewHelpers;

/**
 * Click enlarge view helper for Fluid
 *
 * Example:
 * 		{namespace moc=MOC\MocHelpers\ViewHelpers}
 *
 *		  <moc:clickEnlarge path="path/to/image/file.ext" />
 *
 */
class ClickEnlargeViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * @param string $path
	 * @param string $width
	 * @param string $height
	 * @param string $params
	 * @param string $alt
	 * @param string $maxWidth
	 * @param string $maxHeight
	 * @return string content wrapped in link as clickenlarge
	 */
	public function render($path, $width = '', $height = '', $params = '', $alt = '', $maxWidth = '', $maxHeight = '') {
		$split = explode('/', $path);

		$conf['imageLinkWrap'] = '1';
		$conf['imageLinkWrap.']['bodyTag'] = '<body style="margin:0; background:#fff;">';
		$conf['imageLinkWrap.']['wrap'] = '<a href="javascript:close();"> | </a>';
		$conf['imageLinkWrap.']['width'] = '935m';
		$conf['imageLinkWrap.']['height'] = '700m';
		$conf['imageLinkWrap.']['JSwindow'] = '1';
		$conf['imageLinkWrap.']['JSwindow.']['newWindow'] = '0';
		$conf['imageLinkWrap.']['enable'] = '1';
		$conf['file'] = $path;
		$conf['file.']['width'] = $width;
		$conf['file.']['height'] = $height;
		$conf['params'] = $params;
		$conf['altText'] = $alt;
		if ($maxWidth !== '') {
			$conf['file.']['maxW'] = $maxWidth;
		}
		if ($maxHeight !== '') {
			$conf['file.']['maxH'] = $maxHeight;
		}

		return $GLOBALS['TSFE']->cObjGetSingle('IMAGE', $conf);
	}

}