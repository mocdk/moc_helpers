<?php
class Tx_MocHelpers_SingletonFactory {
	protected static $instances = array();

	protected function __construct() {

	}

	public static function get($class) {
		$classKey = strtolower($class);
		if (!array_key_exists($classKey, self::$instances)) {
			self::$instances[$classKey] = t3lib_div::makeInstance($class);
		}

		return self::$instances[$classKey];
	}
}