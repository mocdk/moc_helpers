<?php
/**
 * String format ViewHelper for fluid
 *
 * Example:
 * 		{namespace moc=Tx_MocHelpers_ViewHelpers}
 *
 *		  <moc:strftime format="%d %b %Y %H:%M" timestamp="{element}" />
 *
 */
class Tx_MocHelpers_ViewHelpers_StrftimeViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * Converts a unix timestamp into a viewable date using date
	 *
	 * @param string $format The date format for convertion of unix timestamp
	 * @param string $timestamp The unix timestamp to be converted
	 * @return string Rendered string
	 * @author Jan-Erik Revsbech <janerik@mocsystems.com>
	 * @api
	 */
	public function render($timestamp, $format="%d %b %Y %H:%M") {

		return strftime($format, $timestamp);
	}

}

?>