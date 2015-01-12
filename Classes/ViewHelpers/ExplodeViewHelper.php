<?php
namespace Moc\MocHelpers\ViewHelpers;
/**
 * Explode ViewHelper for fluid
 *
 * Takes a string, and explodeds it into iterable pars
 *
 * Example:
 * 		{namespace moc=Tx_MocHelpers_ViewHelpers}
 *
 *		  <moc:explode text="{text}" as="myvar">
 *
 * 		  <moc:explode>
 *
 */
class ExplodeViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * Converts a string into an array broken by newline (or other configurable token)
	 *
	 * @param string $as The string to explode into lines
	 * @param string $as The name of the iteration variable
	 * @param string $token The token to split by (default new line chr(10))
	 * @param int $maxlines If set, then only this many lines are returned (default = 0: all lines)
	 * @param boolean $ellipsis If set, then the last returned line is appended with "..." if there are more than maxlines
	 * @param boolean $excludeEmptyLines If set, empty lines are not returned
	 * @return string The wordwrapped string

	 * @author Jan-Erik Revsbech <janerik@mocsystems.com>
	 * @api
	 */
	public function render($text, $as, $token = "\n", $maxlines = 0, $ellipsis = false, $excludeEmptyLines = false) {
		$count = 0;
		foreach(explode($token, $text) as $keyValue => $singleElement) {
			if($maxlines && ($count == $maxlines)) {
				break;
			}
			if($excludeEmptyLines && strlen($singleElement) === 0) {
				$count++;
				continue;
			}
			if($ellipsis && ((count(explode($token, $text)) - 1) > $maxlines) && ($count == $maxlines)) {
				$singleElement = $singleElement . '...';
			}
			$this->templateVariableContainer->add($as, $singleElement);
			$output .= $this->renderChildren();
			$this->templateVariableContainer->remove($as);
			$count++;
		}
		return $output;
	}

}