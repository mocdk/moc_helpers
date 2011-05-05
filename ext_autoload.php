<?php

$extensionClassesPath = t3lib_extMgm::extPath('moc_helpers') . 'Classes/';

spl_autoload_register('moc_helpers_autoload');

return array(
	'tx_mochelpers_controller_taskcontroller' => $extensionClassesPath . 'Controller/TaskController.php',
	'tx_mochelpers_extbase_dispatcher' => $extensionClassesPath . 'Extbase/Dispatcher.php'
);

function moc_helpers_autoload($name){
	if(strpos($name, 'Tx_MocHelpers') === false){
		return false;
	}

	$root = dirname(__FILE__).DIRECTORY_SEPARATOR.'Classes';
	$namespace = str_replace('Tx_MocHelpers_', '', $name);
	$nameParts = explode('_', $namespace);
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