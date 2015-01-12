<?php
namespace Moc\MocHelpers\ViewHelpers;
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
class StriptagsViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\CObjectViewHelper  {

	/**
	 * @param string $allowableTags	Comma list of tags allowed
	 * @param boolean $decode Whether or not to html_entity_decode
	 * @return String content parsed for links
	 */

	public function render($allowableTags = '', $decode = false) {
		if($decode) {
			return strip_tags(html_entity_decode($this->renderChildren()), $allowableTags);
		}
		return strip_tags($this->renderChildren(), $allowableTags);
	}

}