<?php
abstract class Tx_MocHelpers_Controller_TaskController extends tx_scheduler_Task {

	/**
	 * Tx_MocHelpers_Extbase_Dispatcher
	 */
	protected $dispatcher;

	/**
	 * @return array or NULL
	 */
	abstract protected function getConfiguration();
	
	public function setScheduler() {
		parent::setScheduler();
		$this->objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
		$configurationManager = $this->objectManager->get('Tx_Extbase_Configuration_ConfigurationManager');
		$configurationManager->injectObjectManager($this->objectManager);
		$configurationManager->setConfiguration($this->getConfiguration());
		$persistenceManager = $this->objectManager->get('Tx_Extbase_Persistence_Manager');

		$this->dispatcher = $this->objectManager->create('Tx_Extbase_Dispatcher');
		$this->dispatcher->injectConfigurationManager($configurationManager);
		$this->dispatcher->injectPersistenceManager($persistenceManager);
	}

	protected function shutDownExtbaseAndPersistence() {
		if($this->objectManager === NULL) {
			return;
		}
		$this->objectManager->get('Tx_Extbase_Persistence_Manager')->persistAll();
		$this->objectManager = NULL;
	}

	public function __destruct() {
		$this->shutDownExtbaseAndPersistence();
	}

	public function __sleep() {
		$this->shutDownExtbaseAndPersistence();
		return array_keys(get_object_vars($this));
	}

}