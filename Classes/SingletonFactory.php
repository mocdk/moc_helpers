<?php
namespace Moc\MocHelpers;
class SingletonFactory {
	protected static $instances = array();

	protected function __construct() {

	}

	public static function get($class) {
		$classKey = strtolower($class);
		if (!array_key_exists($classKey, self::$instances)) {
			self::$instances[$classKey] = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance($class);
		}

		return self::$instances[$classKey];
	}
}