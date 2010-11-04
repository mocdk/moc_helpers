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
class Tx_MocHelpers_ViewHelpers_TypolinkUrlViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

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
	 * @return String URI
	 */
	public function render($parameter,$additionalParams='') {
		$conf['parameter'] = $parameter;
		$conf['additionalParams'] = $additionalParams;
		return $this->cObj->typolink_URL($conf);
	}
}

?>
