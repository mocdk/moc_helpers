<?php

class Tx_MocHelpers_Validation_ObjectValidator extends Tx_MocHelpers_Validation_Abstract {

	/**
	 * Contains a list of objects that should all validate for this step to be valid
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage
	 */
	protected $validatingObjects;

	/**
	 * Object constructor
	 *
	 */
	public function __construct() {
		parent::__construct();
		$this->validatingObjects = new Tx_Extbase_Persistence_ObjectStorage();
	}

	/**
	 * Add an object to the validatingObjects array
	 *
	 * @param array $object
	 */
	public function addValidatingObject($object, $information = null) {
		if (!$this->validatingObjects->contains($object)) {
			$this->validatingObjects->attach($object, $information);
		}
	}

	/**
	 * Check if the current step is valid
	 *
	 * It's only valid if none of the validating objects
	 * returned an non-empty array when calling getErrors
	 *
	 * @return array
	 */
	protected function validate() {
		// Build our argument error list
		foreach ($this->validatingObjects as $object) {
			// If the object has no validation errors, skip it
			$validationErrors = $object->getValidationErrors();

			if (empty($validationErrors)) {
				continue;
			}

			// Get the argument object name
			$argument = $this->validatingObjects->getInfo();

			// Push our error list to the new ArgumentError object
			$this->addError($validationErrors, $argument);
		}

		return $this->errors;
	}

}