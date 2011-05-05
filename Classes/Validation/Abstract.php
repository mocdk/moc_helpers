<?php
abstract class Tx_MocHelpers_Validation_Abstract {

	/**
	 * @var array An array of Tx_Extbase_Validation_Error for the step
	 */
	protected $errors = NULL;

	/**
	 * @var Tx_Extbase_Validation_ValidatorResolver
	 */
	protected $validatorResolver;

	/**
	 * @var Tx_Extbase_Object_ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * @param Tx_Extbase_Validation_ValidatorResolver $validatorResolver
	 * @return void
	 */
	public function injectValidatorResolver(Tx_Extbase_Validation_ValidatorResolver $validatorResolver) {
		$this->validatorResolver = $validatorResolver;
	}

	/**
	 * @param Tx_Extbase_Object_ObjectManagerInterface $objectManager
	 * @return void
	 */
	public function injectObjectManager(Tx_Extbase_Object_ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	/**
	 * @return void
	 */
	public function initializeObject() {
	}

	/**
	 * @param Tx_Extbase_Validation_Error $error
	 * @param string $argument
	 * @return void
	 */
	public function addError(Tx_Extbase_Validation_Error $error, $argument) {
		if(!array_key_exists($argument, $this->errors)) {
			$this->errors[$argument] = $this->objectManager->create('Tx_Extbase_MVC_Controller_ArgumentError', $argument);
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
	 * @return Tx_MocHelpers_Validation_Abstract
	 */
	public function reset() {
		$this->errors = NULL;
		return $this;
	}

}