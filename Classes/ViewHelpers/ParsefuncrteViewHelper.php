<?php
namespace Moc\MocHelpers\ViewHelpers;
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
class ParsefuncrteViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\CObjectViewHelper  {

	/**
	 *
	 * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
	 */
	static private $cObj;



	/**
	 * @return String content parsed for links
	 */
	public function render() {
		/**
		* put your comment there...
		*
		* @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
		*/
		$cObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer');
		$conf = array(
			'value'=>$this->renderChildren(),
			'parseFunc'=>'< lib.parseFunc_RTE'
		);
		return $cObj->TEXT($conf);
	}
}

?>
