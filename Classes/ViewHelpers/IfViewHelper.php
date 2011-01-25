<?php

/*                                                                        *
 * This script belongs to the FLOW3 package "Fluid".                      *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * This view helper implements an if/else condition.
 * @see Tx_Fluid_Core_Parser_SyntaxTree_ViewHelperNode::convertArgumentValue() to find see how boolean arguments are evaluated
 *
 * = Conditions =
 *
 * As a condition is a boolean value, you can just use a boolean argument.
 * Alternatively, you can write a boolean expression there.
 * Boolean expressions have the following form:
 * XX Comparator YY
 * Comparator is one of: ==, !=, <, <=, >, >= and %
 * The % operator converts the result of the % operation to boolean.
 *
 * XX and YY can be one of:
 * - number
 * - Object Accessor
 * - Array
 * - a ViewHelper
 * Note: Strings at XX/YY are NOT allowed.
 *
 * <code title="condition example">
 * <f:if condition="{rank} > 100">
 *   Will be shown if rank is > 100
 * </f:if>
 * <f:if condition="{rank} % 2">
 *   Will be shown if rank % 2 != 0.
 * </f:if>
 * <f:if condition="{rank} == {k:bar()}">
 *   Checks if rank is equal to the result of the ViewHelper "k:bar"
 * </f:if>
 * </code>
 *
 * = Examples =
 *
 * <code title="Basic usage">
 * <f:if condition="somecondition">
 *   This is being shown in case the condition matches
 * </f:if>
 * </code>
 *
 * Everything inside the <f:if> tag is being displayed if the condition evaluates to TRUE.
 *
 * <code title="If / then / else">
 * <f:if condition="somecondition">
 *   <f:then>
 *     This is being shown in case the condition matches.
 *   </f:then>
 *   <f:else>
 *     This is being displayed in case the condition evaluates to FALSE.
 *   </f:else>
 * </f:if>
 * </code>
 *
 * Everything inside the "then" tag is displayed if the condition evaluates to TRUE.
 * Otherwise, everything inside the "else"-tag is displayed.
 *
 * <code title="inline notation">
 * {f:if(condition: someCondition, then: 'condition is met', else: 'condition is not met')}
 * </code>
 *
 * The value of the "then" attribute is displayed if the condition evaluates to TRUE.
 * Otherwise, everything the value of the "else"-attribute is displayed.
 *
 *
 * @version $Id: IfViewHelper.php 671 2010-08-17 10:04:09Z egede $
 * @package Fluid
 * @subpackage ViewHelpers
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @api
 * @scope prototype
 */


class Tx_MocHelpers_ViewHelpers_IfViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractConditionViewHelper  {

	public function __construct() {
		//This mus be called! Otherwise the paren constructor will fuck up the arguments
	}
	
	/**
	 * renders <f:then> child if $condition is true, otherwise renders <f:else> child.
	 *
	 * @param mixed $left View helper condition
	 * @param mixed $right View helper condition
	 * @param string $match View helper condition
	 * @param string $then String to be returned if the condition is met
	 * @param string $else String to be returned if the condition is not met
	 * @return string the rendered string
	 * @author Aske Ertmann <aske@mocsystems.com>
	 * @author Jan-Erik Revsbech <janerik@mocsystems.com>
	 * @api
	 */
	public function render($left, $right, $match = 'equals', $then = NULL, $else = NULL) {
		
		switch($match) {
			case '>':
			case 'greaterThan':
				$condition = ($left > $right);
				break;

			case '<':
			case 'lessThan':
				$condition = ($left < $right);
				break;

			case '>=':
			case 'equalsGreaterThan':
				$condition = ($left >= $right);
				break;

			case '<=':
			case 'equalsLessThan':
				$condition = ($left <= $right);
				break;
			
			case '!=':
			case 'not':
			case 'notEquals':
				$condition = ($left != $right);
				break;

			case '===':
				$condition = ($left === $right);
				break;

			case '!==':
				$condition = ($left !== $right);
				break;

			default:
				$condition = ($left == $right);
				break;
		}

		if ($condition) {
			return $this->renderThenChild();
		} else {
			return $this->renderElseChild();
		}
	}
}

?>