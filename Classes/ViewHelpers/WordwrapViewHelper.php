<?php
namespace Moc\MocHelpers\ViewHelpers;
/**
 * Wordwrap ViewHelper for fluid
 *
 * Example:
 * 		{namespace moc=Tx_MocHelpers_ViewHelpers}
 *
 *		  <moc:wordwrap>{element}<moc:wordwrap>
 *
 */
class WordwrapViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * Converts a unix timestamp into a viewable date using date
	 *
	 * @param int $width The column width.
	 * @param string $break The line is broken using the optional break parameter.
	 * @param string $cut If the cut is set to TRUE, the string is always wrapped at or before the specified width. So if you have a word that is larger than the given width, it is broken apart.
	 * @return string The wordwrapped string

	 * @author Jan-Erik Revsbech <janerik@mocsystems.com>
	 * @api
	 */
	public function render($width=20,$break="\n",$cut = false) {
		return wordwrap($this->renderChildren(),$width,$break,$cut);
	}

}

?>