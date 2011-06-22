<?php
/**
 * Title ViewHelper for fluid
 *
 * Example:
 * 		{namespace moc=Tx_MocHelpers_ViewHelpers}
 *
 *		  <moc:cdata>Title of Page and Indexing</moc:cdata>
 */
class Tx_MocHelpers_ViewHelpers_CdataViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {


	/**
	 * @return string
	 */
	public function render() {
		return '<![CDATA[' . $this->renderChildren() . ']]>';	}
}

?>
