<?php
namespace MOC\MocHelpers\ViewHelpers\Format;

/**
 * date view helper to generate pretty dates
 */
class DateViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * Event render with multiple day support
	 *
	 * @param string $function
	 * @param object $start
	 * @param object $end
	 * @return string $return
	 */
	public function render($function, $start, $end) {

		switch ($function) {
			case 'eventMultipleDays':
				if ($start->format('d') !== $end->format('d') || $start->format('m') !== $end->format('m') || $start->format('Y') !== $end->format('Y')) {
					// 1. JAN 2013 KL 19.00 - 12. JAN 2013 KL 23.00
					return $start->format('j. M Y \K\L G.i') . ' - ' . $end->format('j. M Y \K\L G.i');
				} else {
					// 1. JAN 2013 | KL 19.00 - 23.00
					return $start->format('j. M Y | \K\L G.i') . ' - ' . $end->format('G.i');
				}
		}
	}

}
