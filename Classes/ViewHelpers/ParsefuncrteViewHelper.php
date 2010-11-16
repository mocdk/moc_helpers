<?php
/**
 * ParseFuncRTE ViewHelper for fluid Runs everything to parseFunc_RTE
 *
 * @deprecated, just use the f:format.html instead.
 *
 * Example:
 * 		{namespace moc=Tx_MocHelpers_ViewHelpers}
 *
 *		  <moc:parsefuncrte>{something}</moc:parsefuncrte>
 *
 */
class Tx_MocHelpers_ViewHelpers_ParsefuncrteViewHelper extends Tx_Fluid_ViewHelpers_CObjectViewHelper  {

	/**
	 *
	 * @var tslib_cObj
	 */
	static private $cObj;



	/**
	 * @return String content parsed for links
	 */
	public function render() {
		/**
		* put your comment there...
		*
		* @var tslib_cObj
		*/
		$cObj = t3lib_div::makeInstance('tslib_cObj');
		$conf = array(
			'value'=>$this->renderChildren(),
			'parseFunc'=>'< lib.parseFunc_RTE'
		);
		return $cObj->TEXT($conf);
	}
}

?>
