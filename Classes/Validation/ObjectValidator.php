<?php
namespace Moc\MocHelpers\Validation;
class ObjectValidator extends \Moc\MocHelpers\Validation\ValidationAbstract {

	/**
	 * Contains a list of objects that should all validate for this step to be valid
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	protected $validatingObjects;

	/**
	 * Object constructor
	 *
	 * @return void
	 */
	public function initializeObject() {
		parent::initializeObject();
		$this->validatingObjects = $this->objectManager->get('\TYPO3\CMS\Extbase\Persistence\ObjectStorage');
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