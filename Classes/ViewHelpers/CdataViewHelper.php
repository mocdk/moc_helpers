<?php
namespace Moc\MocHelpers\ViewHelpers;
/**
 * Title ViewHelper for fluid
 *
 * Example:
 * 		{namespace moc=Tx_MocHelpers_ViewHelpers}
 *
 *		  <moc:cdata>Title of Page and Indexing</moc:cdata>
 */
class CdataViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {


	/**
	 * @return string
	 */
	public function render() {
		return '<![CDATA[' . $this->renderChildren() . ']]>';	}
}