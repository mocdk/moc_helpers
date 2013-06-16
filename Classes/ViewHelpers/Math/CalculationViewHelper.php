<?php
namespace MOC\MocHelpers\ViewHelpers\Math;

/**
 * Backported from Calculation viewhleper in FLOW3, but aliases are only create inside the current scope!
 *
 * Basic math calculations, result can be output or stored in a new variable
 * So far no nesting and parenthesis, no precedence of operators
 *
 * = Examples =
 *
 * <code title="simple multiplication">
 * <f:calculation expressionString="3*4" aliasToCreate="twelve" >
 *  In here I can use the alias {twelve]
 * </f:calculation>
 * </code>
 *
 * Output:
 * 12 (output defaults to TRUE!)
 * Stores the result in a new template variable "twelve"
 * <f:calculation expressionString="{twelve}-1+3" />
 * which here can be used in the next calculation ( with multicalculation / but no precedence of operators)
 * any defined variables in the template can be used. float is supported with . decimal separator
 * - as prefix is also supported <f:calculation expressionString="12+-4" />
 *
 * @version $Id:
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @scope prototype
 */
class CalculationViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * @var array
	 */
	protected $operatorsWithPrecedenceValue = array('+' => 10, '-' => 10, '*' => 20, '/' => 20, '%' => 20);

	/**
	 * @param string $expressionString The math expression to evaluate
	 * @param boolean $output should the result be returned?
	 * @param string $aliasToCreate name of new alias to be set with result
	 * @return string
	 */
	public function render($expressionString, $output = TRUE, $aliasToCreate = NULL) {
		$splitArray = array();
		preg_match_all('([0-9.]*|[\D]?)', $expressionString, $splitArray);
		$expressionArray = $this->buildExpressionArray($splitArray[0]);
		$result = $this->evaluateExpressionArray($expressionArray);
		if ($aliasToCreate !== NULL) {
			$this->templateVariableContainer->add($aliasToCreate, $result);
			$output = $this->renderChildren();
			$this->templateVariableContainer->remove($aliasToCreate);
			return $output;
		}
		return $result;
	}

	/**
	 * Later on responsible for presplitting the array by parenthesis to have nested calculations
	 *
	 * @param array $splitArray The array with splitted formula
	 * @param integer $nestingLevel used for the recursion of nested parenthesis
	 * @return array multidimensional array with numbers, operators and subarrays (nested)
	 */
	protected function buildExpressionArray($splitArray, $nestingLevel = 0) {
		$expresionArray = array();

		foreach ($splitArray as $key => $splitPart) {
			$splitPart = trim($splitPart);
			if ($splitPart == '(') {
				$nestingLevel++;
			} elseif ($splitPart == ')') {
				$nestionLevel--;
			} else {
				if (strlen($splitPart)) {
					$expressionArray[] = $splitPart;
				}
			}
		}

		return $expressionArray;
	}

	/**
	 * Will try to evaluate the calculation and return a final value
	 *
	 * @param array $expressionArray array to be calculated
	 * @return string
	 */
	protected function evaluateExpressionArray(array $expressionArray = array()) {
		$subExpressionsEliminated = FALSE;
			// eliminate sub expressions, this is recursive, so after first run, all sub expressions should be eliminated
		if ($subExpressionsEliminated === FALSE) {
			foreach ($expressionArray as $key => $mathData) {
				if (is_array($mathData)) {
					$expressionArray[$key] = $this->evaluateExpressionArray($mathData);
				}
			}
			$subExpressionsEliminated = TRUE;
		}
		$i = 0;
			// we loop a maximum of 99 times over the expression before Exception
		while (count($expressionArray) > 1 && $i < 99) {
			$prev = NULL;
			$i++;
			foreach ($expressionArray as $key => $mathData) {
					// lets see if we have an operator
				if (array_key_exists($mathData, $this->operatorsWithPrecedenceValue)) {
						// check next
					$nextKey = $this->findNextValidKey($expressionArray, $key);
					if (is_numeric($nextKey)) {
						$next = $expressionArray[$nextKey];
					} else {
						$next = NULL;
					}

					if (is_numeric($prev) && is_numeric($next)) {
						switch ($mathData) {
							case '-':
								$eval = $prev - $next;
								break;
							case '+':
								$eval = $prev + $next;
								break;
							case '*':
								$eval = $prev * $next;
								break;
							case '/':
								$eval = $prev / $next;
								break;
							case '%':
								$eval = $prev % $next;
								break;
							default:
						}
						if (isset($prevKey)) {
							unset($expressionArray[$prevKey]);
						}
						unset($expressionArray[$nextKey]);
						$expressionArray[$key] = $eval;
						break;
					} elseif ($prev !== NULL && array_key_exists($prev, $this->operatorsWithPrecedenceValue) && is_numeric($next) && $mathData === '-') {
						$expressionArray[$key] = 0 - $next;
						unset($expressionArray[$nextKey]);
// @codingStandardsIgnoreStart
						break;
// @codingStandardsIgnoreEnd
					}
				}

				$prev = $expressionArray[$key];
				$prevKey = $key;
			}

		}
		if (count($expressionArray) == 1) {
			return reset($expressionArray);
		}
		return '';
	}

	/**
	 * Find next valid key of (calculation) array (not easy as values get deleted)
	 *
	 * @param array $array the array to find a next key
	 * @param integer $keyFrom the key for which you want the next
	 * @return integer
	 */
	protected function findNextValidKey($array, $keyFrom) {
		$i = 0;
		$key = NULL;
		while ($key == NULL && $i < 99) {
			$i++;
			if (isset($array[$keyFrom + $i])) {
				$key = $keyFrom + $i;
			}
		}
		return $key;
	}

}