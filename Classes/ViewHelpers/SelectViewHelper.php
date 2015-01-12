<?php
namespace Moc\MocHelpers\ViewHelpers;
/**
 * Speciel select viewhelper. Adds the emptyOption value to the options
 *
 * Example:
 * 		{namespace moc=Tx_MocHelpers_ViewHelpers}
 *
 *		  <moc:select emptyOption="Storkreds" options="{grandconstituencies}" value="{grandconstituency}" name="grandconstituency" optionLabelField="name" optionValueField="uid"/>
 *
 */
class SelectViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Form\SelectViewHelper {
	public function initializeArguments() {
		parent::initializeArguments();
		$this->registerArgument('emptyOption', 'string', 'If specified, will add an empty option',false);

	}
	protected function getOptions() {
		$options = parent::getOptions();
		if($this->arguments['emptyOption']) {
			$this->array_unshift_assoc($options,"0",$this->arguments['emptyOption']);
		}
		return $options;
	}
	function array_unshift_assoc(&$arr, $key, $val)
	{
	    $arr = array_reverse($arr, true);
	    $arr[$key] = $val;
	    $arr = array_reverse($arr, true);
	    return count($arr);
	}

}

?>
