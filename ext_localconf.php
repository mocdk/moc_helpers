<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['mochelpers_cachingviewhelper'])) {
	$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['mochelpers_cachingviewhelper'] = array(
		'frontend' => 'TYPO3\CMS\Core\Cache\Frontend\StringFrontend'
	);
}