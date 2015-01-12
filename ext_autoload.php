<?php

$extensionClassesPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('moc_helpers') . 'Classes/';

spl_autoload_register('moc_helpers_autoload');

return array(
	'Moc\MocHelpers\Controller\TaskController' => $extensionClassesPath . 'Controller/TaskController.php'
);

function moc_helpers_autoload($name){
	if(strpos($name, 'Moc\MocHelpers') === false){
		return false;
	}

	$root = dirname(__FILE__).DIRECTORY_SEPARATOR.'Classes';
	$namespace = str_replace('Moc\MocHelpers\\', '', $name);
	$nameParts = explode('\\', $namespace);
	$pathName = $root;
	foreach($nameParts as $curNamePart){
		$pathName .= DIRECTORY_SEPARATOR.$curNamePart;
	}
	$pathName .= '.php';

	if(!is_file($pathName)){
		return false;
	}
	require_once($pathName);
}