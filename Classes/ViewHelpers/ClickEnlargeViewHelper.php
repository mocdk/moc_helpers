<?php
/**
 * ClickEnlarge ViewHelper for fluid
 *
 * Example:
 * 		{namespace moc=Tx_MocHelpers_ViewHelpers}
 *
 *		  <moc:clickEnlarge path="path/to/image/file.ext" />
 *
 */
class Tx_MocHelpers_ViewHelpers_ClickEnlargeViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 *
	 * @var tslib_cObj
	 */
	static private $cObj;

	public function __construct() {
		if(!$this->cObj instanceof tslib_cObj) {
			$this->cObj = t3lib_div::makeInstance('tslib_cObj');
		}

	}

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
	public function render($path, $width='', $height='', $params='', $alt='', $maxWidth='', $maxHeight='') {
		
		$split = explode('/', $path);
		
		$file_name = $split[count($split) - 1];
		$file_path = str_replace($file_name, '', $path);
				
		$dam = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('uid, tx_smkcopyright_smkcopyright, caption','tx_dam','file_name = "'.$file_name.'" AND file_path = "'.$file_path.'" AND NOT deleted');
		
		$damid = $dam[0]['uid'];
		$damcopyright = $dam[0]['tx_smkcopyright_smkcopyright'];
		$damcaption = $dam[0]['caption'];
	
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
		if($maxWidth) {
			$conf['file.']['maxW'] = $maxWidth;
		}
		if($maxHeight) {
			$conf['file.']['maxH'] = $maxHeight;
		}

		$conf2['userFunc'] = 'user_damfunc->caption';
		$conf2['damid'] = $damid;
		if($damcopyright) {
			$conf2['txdam_tx_smkcopyright_smkcopyright'] = $damcopyright;
		}
		$conf2['damcaption'] = $damcaption;

		$image = $this->cObj->cObjGetSingle('IMAGE', $conf);
		$caption = $this->cObj->cObjGetSingle('USER', $conf2);
		
		$content = '<div><div>'.$image.'</div><div class="csc-textpic-caption" style="display:none">'.$caption.'</div></div>';
		
		return $content;
	}
}

?>