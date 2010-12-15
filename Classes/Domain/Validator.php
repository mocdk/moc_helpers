<?php
class Tx_MocHelpers_Domain_Validator {
	protected static $validators = array();
	/**
	 * Get validator for a given class
	 *
	 * @return Tx_Extbase_Validation_Validator_ConjunctionValidator
	 */
	public static function getValidator($class) {
		if (!array_key_exists($class, self::$validators)) {
			$reflectionService = t3lib_div::makeInstance('Tx_Extbase_Reflection_Service');
			$objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_Manager');
			$validatorResolver = t3lib_div::makeInstance('Tx_Extbase_Validation_ValidatorResolver');

			$validatorResolver->injectObjectManager($objectManager);
			$validatorResolver->injectReflectionService($reflectionService);
			self::$validators[$class] = $validatorResolver;
		}
		return self::$validators[$class]->getBaseValidatorConjunction($class);
	}
}