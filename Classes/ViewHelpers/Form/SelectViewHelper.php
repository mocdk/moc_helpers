<?php
namespace MOC\MocHelpers\ViewHelpers\Form;

/**
 * Speciel form select view helper. Adds the emptyOption argument to prepend the options
 *
 * Example:
 * {namespace moc=MOC\MocHelpers\ViewHelpers}
 * <moc:form.select emptyOption="" options="{options}" value="{option}" name="option" optionLabelField="name" optionValueField="uid" />
 */
class SelectViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Form\SelectViewHelper {

	/**
	 * @return void
	 */
	public function initializeArguments() {
		parent::initializeArguments();
		$this->registerArgument('emptyOption', 'string', 'If specified, will add an empty option', FALSE);
	}

	/**
	 * @return array
	 */
	protected function getOptions() {
		$options = parent::getOptions();
		if (isset($this->arguments['emptyOption'])) {
			array_unshift($options, $this->arguments['emptyOption']);
		}
		return $options;
	}

}