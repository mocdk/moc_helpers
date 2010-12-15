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
		if (!is_object($object)) {
			$object = t3lib_div::makeInstance($object);
		}

		foreach ($data as $key => $value) {
			if ($key == 'uid') {
				continue;
			}

			$fixedKey = MOC_Inflector::variable($key);
			$object->_setProperty($fixedKey, $value);
		}

		return $object;
	}

}