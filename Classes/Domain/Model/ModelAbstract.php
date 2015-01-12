<?php
namespace Moc\MocHelpers\Domain\Model;
class ModelAbstract extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * Check if the domain model validates according to its validation annotations
	 *
	 * @return boolean
	 */
	public function isValid() {
		$validator = $this->getValidator();
		return $validator->isValid($this);
	}

	/**
	 * Get a list of validation errors
	 *
	 * @param string|null $prefix Prefix error columns if present
	 * @return array
	 */
	public function getValidationErrors($prefix = null) {
		// Its valid, we got no errors ! :)
		// Also, isValid populates errors array in the Tx_Extbase_Validation_Validator_ConjunctionValidator
		// So please dont touch this
		if ($this->isValid()) {
			return array();
		}

		$validator = $this->getValidator();
		$errors = $validator->getErrors();

		// No reason to continue, since we dont need to prefix keys
		if (empty($prefix)) {
			return $errors;
		}

		// Prefix and return
		$prefixedErrors = array();
		foreach ($errors as $key => $value) {
			$prefixedErrors[sprintf('%s.%s', $prefix, $key)] = $value;
		}

		return $prefixedErrors;
	}

	/**
	 * Returns a validator for domain model object
	 *
	 * @return Tx_Extbase_Validation_Validator_ConjunctionValidator
	 */
	public function getValidator() {
		return \Moc\MocHelpers\Domain\Validator::getValidator(get_class($this));
	}

}