<?php

abstract class Tx_MocHelpers_Validation_Abstract {

	/**
	 * An array of Tx_Extbase_Validation_Error for the step
	 *
	 * @var array
	 */
	protected $errors = null;

	/**
	 * The object manager that the controller was initialized with
	 *
	 * @var Tx_Extbase_Object_ManagerInterface
	 */
	protected $objectManager;

	/**
	 * @var Tx_Extbase_Reflection_Service
	 */
	protected $reflectionService;
	
	/**
	 * The validator resolver that the controller was initialized with
	 *
	 * @var Tx_Extbase_Validation_ValidatorResolver
	 */
	protected $validatorResolver;
	
	/**
	 * @param Tx_Extbase_Object_ObjectManager $manager
	 */
	public function injectObjectManager(Tx_Extbase_Object_ObjectManager $manager) {
		$this->objectManager = $manager;
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param Tx_Extbase_Reflection_Service $service
	 */
	public function injectReflectionService(Tx_Extbase_Reflection_Service $service) {
		$this->reflectionService = $service;
	}

	/**
	 * 
	 * Enter description here ...
	 * @param Tx_Extbase_Validation_ValidatorResolver $service
	 */
	public function injectValidatorResolver(Tx_Extbase_Validation_ValidatorResolver $resolver) {
		$this->validatorResolver = $resolver;
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
		if(empty($this->errors)) {
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