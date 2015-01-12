<?php
namespace Moc\MocHelpers\Domain\Model;
class Builder {

	/**
	 * Convert a list (or all) properites from the step data into an object
	 *
	 * @param mixed $object The classname to add properties to
	 * @param array $data The list of properties to add to the object
	 * @return object
	 * @deprecated
	 */
	public static function convertDataToObject($object, $data = array()) {
		return self::updateValuesOnObject($object, $data);
	}

	/**
	 * Convert a list (or all) properites from the step data into an object. If the object already exists, we just updates all properties from
	 * the data array.
	 *
	 *
	 * @param mixed $object The classname to add properties to
	 * @param array $data The list of properties to add to the object
	 * @return object
	 */
	public static function updateValuesOnObject($object, $data = array()) {
		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\TYPO3\CMS\Extbase\Object\ObjectManager');
		$reflectionService = $objectManager->get('\TYPO3\CMS\Extbase\Reflection\ReflectionService');
		$dataMapper = $objectManager->get('Tx_Extbase_Persistence_Mapper_DataMapper');

		if (!is_object($object)) {
			$object = $objectManager->get($object);
		}

		foreach ($data as $key => $value) {
			if ($key === 'uid') {
				continue;
			}

			$propertyMetaData = $reflectionService->getClassSchema(get_class($object))->getProperty($key);

			if (!empty($propertyMetaData['elementType'])) {
				$type = $propertyMetaData['elementType'];
			} elseif (!empty($propertyMetaData['type'])) {
				$type = $propertyMetaData['type'];
			} else {
				unset($type);
			}

			if (class_exists($type) && !is_object($value)) {
				if (is_array($value) && isset($value['__identity'])) {
					$value = intval($value['__identity']);
				}
				$result = $dataMapper->fetchRelated($object, $key, $value);
				$value = $dataMapper->mapResultToPropertyValue($object, $key, $result);
			}

			$fixedKey = MOC_Inflector::variable($key);
			$object->_setProperty($fixedKey, $value);
		}

		return $object;
	}

}