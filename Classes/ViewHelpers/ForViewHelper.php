<?php
namespace Moc\MocHelpers\ViewHelpers;
/**
 * For ViewHelper for fluid
 *
 * Example:
 * 		{namespace moc=Tx_MocHelpers_ViewHelpers}
 *
 *		  <moc:for each="{parameter}" as="element"></moc:for>
 *
 */
class ForViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * Iterates through elements of $each and renders child nodes with additional split in between var (not appended in end of array)
	 *
	 * @param mixed $each The array or SplObjectStorage to iterated over
	 * @param string $as The name of the iteration variable
	 * @param string $splitter The string of which to split the strings with
	 * @param string $key The name of the variable to store the current array key
	 * @param boolean $reverse If enabled, the iterator will start with the last element and proceed reversely
	 * @return string Rendered string
	 * @author Sebastian Kurfürst <sebastian@typo3.org>
	 * @author Bastian Waidelich <bastian@typo3.org>
	 * @author Robert Lemke <robert@typo3.org>
	 *
	 * @author Aske Ertmann <aske@mocsystems.com>
	 * @api
	 */
	public function render($each, $as, $splitter, $key = '', $reverse = FALSE) {
		$output = '';
		if($each === NULL) {
			return '';
		}
		if(is_object($each)) {
			if(!$each instanceof \Traversable) {
				throw new \TYPO3\CMS\Fluid\Core\ViewHelper\Exception('ForViewHelper only supports arrays and objects implementing Traversable interface' , 1248728393);
			}
			$each = $this->convertToArray($each);
		}

		if($reverse === TRUE) {
			$each = array_reverse($each);
		}

		$output = '';
		$i=0;
		foreach($each as $keyValue => $singleElement) {
			$this->templateVariableContainer->add($as, $singleElement);
			if($key !== '') {
				$this->templateVariableContainer->add($key, $keyValue);
			}
			if($singleElement === end($each)) {
				$output .= $this->renderChildren();
			} else {
				$output .= $this->renderChildren().$splitter;
			}
			$this->templateVariableContainer->remove($as);
			if($key !== '') {
				$this->templateVariableContainer->remove($key);
			}
			$i++;
		}
		return $output;
	}

	/**
	 * Turns the given object into an array.
	 * The object has to implement the Traversable interface
	 *
	 * @param Traversable $object The object to be turned into an array. If the object implements Iterator the key will be preserved.
	 * @return array The resulting array
	 * @author Bastian Waidelich <bastian@typo3.org>
	 */
	protected function convertToArray(\Traversable $object) {
		$array = array();
		foreach($object as $keyValue => $singleElement) {
			$array[$keyValue] = $singleElement;
		}
		return $array;
	}
}