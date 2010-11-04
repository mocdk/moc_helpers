<?php

$extensionClassesPath = t3lib_extMgm::extPath('moc_helpers') . 'Classes/';

return array(
	'tx_mochelpers_controller_taskcontroller' => $extensionClassesPath . 'Controller/TaskController.php',
	'tx_mochelpers_extbase_dispatcher' => $extensionClassesPath . 'Extbase/Dispatcher.php'
);