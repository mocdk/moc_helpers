<?php
/**
 * Typolink ViewHelper for fluid
 *
 * Example:
 * 		{namespace moc=Tx_MocHelpers_ViewHelpers}
 *
 *		  <moc:typolink parameter="{TypolinkCompatibleParameter}" />
 *
 */
class Tx_MocHelpers_ViewHelpers_TypolinkViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

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
	 * @param String $parameter
	 * @param String $additionalParams
	 * @param String $title
	 * @param String $class
	 * @return String content wrapped in link
	 */
	public function render($parameter,$additionalParams='',$title='',$class='') {
		$conf['parameter'] = $parameter;
		$conf['title'] = $title;
		$conf['additionalParams'] = $additionalParams;
		if(stristr($parameter, '.')) {
			$conf['extTarget'] = '_blank';
		}

		return str_replace('target="_blank"','rel="external"',$this->cObj->typolink($this->renderChildren(), $conf));
	}
}

?>
