<?php
class Tx_MocHelpers_Domain_Model_Builder {

	/**
	 * Convert a list (or all) properites from the step data into an object
	 *
	 * @param string $object The classname to add properties to
	 * @param array $data The list of properties to add to the object
	 * @return object
	 */
	public static function convertDataToObject($object, $data = array()) {
		$objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
		$reflectionService = $objectManager->get('Tx_Extbase_Reflection_Service');
		$dataMapper = $objectManager->get('Tx_Extbase_Persistence_Mapper_DataMapper');

		if (!is_object($object)) {
			$object = $objectManager->create($object);
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
			}

			if (class_exists($type)) {
				$result = $dataMapper->fetchRelated($object, $key, $value);
				$value = $dataMapper->mapResultToPropertyValue($object, $key, $result);
			}

			$fixedKey = MOC_Inflector::variable($key);
			$object->_setProperty($fixedKey, $value);
		}

		return $object;
	}

}