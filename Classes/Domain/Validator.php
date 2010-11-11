<?php
class Tx_MocHelpers_Domain_Validator {
	/**
	 * Get validator for a given class
	 *
	 * @return Tx_Extbase_Validation_Validator_ConjunctionValidator
	 */
	public static function getValidator($class) {
		$reflectionService = Tx_MocHelpers_SingletonFactory::get('Tx_Extbase_Reflection_Service');

		$objectManager = Tx_MocHelpers_SingletonFactory::get('Tx_Extbase_Object_Manager');
		$validatorResolver = Tx_MocHelpers_SingletonFactory::get('Tx_Extbase_Validation_ValidatorResolver');

		$validatorResolver->injectObjectManager($objectManager);
		$validatorResolver->injectReflectionService($reflectionService);

		return $validatorResolver->getBaseValidatorConjunction($class);
	}
}