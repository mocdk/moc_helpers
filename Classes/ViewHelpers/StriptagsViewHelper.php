<?php
/**
 * Striptags ViewHelper for fluid Runs everything to parseFunc_RTE
 *
 *
 *
 * Example:
 * 		{namespace moc=Tx_MocHelpers_ViewHelpers}
 *
 *		  <moc:striptags>{something}</moc:striptags>
 *
 */
class Tx_MocHelpers_ViewHelpers_StriptagsViewHelper extends Tx_Fluid_ViewHelpers_CObjectViewHelper  {

	/**
	 * @param string $allowableTags	Comma list of tags allowed
	 * @return String content parsed for links
	 */
	public function render($allowableTags = "") {
		return strip_tags($this->renderChildren(),$allowableTags);
		
	}
}