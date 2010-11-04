<?php

Abstract class Tx_MocHelpers_Controller_TaskController extends tx_scheduler_Task {

	/**
	 * Tx_MocHelpers_Extbase_Dispatcher
	 */
	protected $dispatcher;

	/**
	 *
	 * @return array or null;
	 */
	abstract protected function getConfiguration();

	protected function initializeExtbaseAndPersistence() {
		$this->dispatcher = t3lib_div::makeInstance('Tx_MocHelpers_Extbase_Dispatcher');
		if(is_array($this->getConfiguration())) {
			$this->dispatcher->initializeConfigurationManagerAndFrameworkConfiguration($this->getConfiguration());
		}
		$this->dispatcher->getPersistenceManager();
	}

	protected function shutDownExtbaseAndPersistence() {
		if($this->dispatcher instanceof Tx_MocHelpers_Extbase_Dispatcher) {
			try {
				$this->dispatcher->getPersistenceManager()->persistAll();
			} catch (Exception $e) {
				var_dump($e->getMessage());
			}
		}
	}

	public function __construct(){
		parent::__construct();
		$this->initializeExtbaseAndPersistence();
	}

	public function __destruct() {
		$this->shutDownExtbaseAndPersistence();
	}

	public function __wakeup(){
		$this->initializeExtbaseAndPersistence();
	}

	public function __sleep() {
		$this->shutDownExtbaseAndPersistence();
		return array_keys(get_object_vars($this));
	}

}