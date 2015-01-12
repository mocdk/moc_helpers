<?php
namespace Moc\MocHelpers\Domain;
class Validator {

	protected static $validators = array();

	/**
	 * Get validator for a given class
	 *
	 * @return Tx_Extbase_Validation_Validator_ConjunctionValidator
	 */
	public static function getValidator($class) {
		if (!array_key_exists($class, self::$validators)) {
			$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Tx_Extbase_Object_Manager');
			$reflectionService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\TYPO3\CMS\Extbase\Reflection\ReflectionService');
			$validatorResolver = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\TYPO3\CMS\Extbase\Validation\ValidatorResolver');

			$validatorResolver->injectObjectManager($objectManager);
			$validatorResolver->injectReflectionService($reflectionService);
			self::$validators[$class] = $validatorResolver;
		}
		return self::$validators[$class]->getBaseValidatorConjunction($class);
	}

}