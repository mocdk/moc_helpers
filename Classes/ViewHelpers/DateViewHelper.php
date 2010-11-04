<?php
/**
 * For ViewHelper for fluid
 *
 * Example:
 * 		{namespace moc=Tx_MocHelpers_ViewHelpers}
 *
 *		  <moc:date format="Y-m-d H:i:s" timestamp="{element}" />
 *
 */
class Tx_MocHelpers_ViewHelpers_DateViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * Converts a unix timestamp into a viewable date using date
	 *
	 * @param string $format The date format for convertion of unix timestamp
	 * @param string $timestamp The unix timestamp to be converted
	 * @return string Rendered string
	 * @author Aske Ertmann <aske@mocsystems.com>
	 * @api
	 */
	public function render($timestamp, $format="d-m-Y") {
		$date = date($format, $timestamp);
		return $date;
	}

}

?>
