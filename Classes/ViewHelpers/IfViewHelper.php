<?php
namespace Moc\MocHelpers\ViewHelpers;
class IfViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractConditionViewHelper {

	/**
	 * renders <f:then> child if $condition is true, otherwise renders <f:else> child.
	 *
	 * @param mixed $left View helper condition
	 * @param mixed $right View helper condition
	 * @param string $match View helper condition
	 * @return string the rendered string
	 * @author Sebastian Kurfürst <sebastian@typo3.org>
	 * @author Bastian Waidelich <bastian@typo3.org>
	 * @api
	 * @reference: http://php.net/manual/en/language.operators.comparison.php
	 */
	public function render($left, $right, $match = '') {
		switch($match) {
			case '>=':
			case 'greaterThanOrEqualTo':
				$condition = ($left >= $right);
				break;

			case '<=':
			case 'lessThanOrEqualTo':
				$condition = ($left <= $right);
				break;

			case '>':
			case 'greaterThan':
				$condition = ($left > $right);
				break;

			case '<':
			case 'lessThan':
				$condition = ($left < $right);
				break;

			case '!==':
			case 'notIdentical':
				$condition = ($left !== $right);
				break;

			case '!=':
			case '<>':
			case 'not':
			case 'notEqual':
				$condition = ($left != $right);
				break;

			case '===':
			case 'identical':
				$condition = ($left === $right);
				break;

			case 'equal':
			case '==':
			default:
				$condition = ($left == $right);
				break;
		}

		if ($condition) {
			return $this->renderThenChild();
		}

		return $this->renderElseChild();
	}

}