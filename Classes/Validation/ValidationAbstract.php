<?php
namespace Moc\MocHelpers\Validation;
abstract class ValidationAbstract {

	/**
	 * @var array An array of \TYPO3\CMS\Extbase\Validation\Error for the step
	 */
	protected $errors = NULL;

	/**
	 * @var \TYPO3\CMS\Extbase\Validation\ValidatorResolver
	 */
	protected $validatorResolver;

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * @param \TYPO3\CMS\Extbase\Validation\ValidatorResolver $validatorResolver
	 * @return void
	 */
	public function injectValidatorResolver(\TYPO3\CMS\Extbase\Validation\ValidatorResolver $validatorResolver) {
		$this->validatorResolver = $validatorResolver;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
	 * @return void
	 */
	public function injectObjectManager(\TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	/**
	 * @return void
	 */
	public function initializeObject() {
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Validation\Error $error
	 * @param string $argument
	 * @return void
	 */
	public function addError(\TYPO3\CMS\Extbase\Validation\Error $error, $argument) {
		if(!array_key_exists($argument, $this->errors)) {
			$this->errors[$argument] = $this->objectManager->get('Tx_Extbase_MVC_Controller_ArgumentError', $argument);
		}
		$this->errors[$argument]->addErrors(array($error));
	}

	/**
	 * @return boolean
	 */
	public function isValid() {
		if(empty($this->errors)) {
			$this->validate();
		}
		return empty($this->errors);
	}

	/**
	 * @return array
	 */
	public function getErrors() {
		if(is_null($this->errors)) {
			$this->validate();
		}
		return $this->errors;
	}

	/**
	 * @return \Moc\MocHelpers\Validation\ValidationAbstract
	 */
	public function reset() {
		$this->errors = NULL;
		return $this;
	}

}