<?php

abstract class Tx_MocHelpers_Validation_Abstract {

	/**
	 * @var array An array of Tx_Extbase_Validation_Error for the step
	 */
	protected $errors = null;

	/**
	 * The validator resolver that the controller was initialized with
	 *
	 * @var Tx_Extbase_Validation_ValidatorResolver
	 */
	protected $validatorResolver;

	/**
	 * The object manager that the controller was initialized with
	 *
	 * @var Tx_Extbase_Object_ManagerInterface
	 */
	protected $objectManager;

	/**
	 * Object constructor
	 */
	public function __construct() {
		$this->objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_Manager');

		$reflectionService = t3lib_div::makeInstance('Tx_Extbase_Reflection_Service');
		$validatorResolver = t3lib_div::makeInstance('Tx_Extbase_Validation_ValidatorResolver');

		$validatorResolver->injectObjectManager($this->objectManager);
		$validatorResolver->injectReflectionService($reflectionService);

		$this->validatorResolver = $validatorResolver;
	}

	/*
	 * @return void
	 */
	public function addError(Tx_Extbase_Validation_Error $error, $argument) {
		if(!array_key_exists($argument, $this->errors)) {
			$this->errors[$argument] = $this->objectManager->getObject('Tx_Extbase_MVC_Controller_ArgumentError', $argument);
		}
		$this->errors[$argument]->addErrors(array($error));
	}

	/*
	 * @return boolean
	 */
	public function isValid() {
		if(is_null($this->errors)) {
			$this->validate();
		}
		return empty($this->errors);
	}

	/*
	 * @return array
	 */
	public function getErrors() {
		if(is_null($this->errors)) {
			$this->validate();
		}
		return $this->errors;
	}

	/*
	 * @return Tx_MocHelpers_Validation_Abstract
	 */
	public function reset() {
		$this->errors = null;
		return $this;
	}

}