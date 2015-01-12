<?php
namespace Moc\MocHelpers\Controller;
abstract class TaskController extends \TYPO3\CMS\Scheduler\Task\AbstractTask {

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
		$this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\TYPO3\CMS\Extbase\Object\ObjectManager');
		$configurationManager = $this->objectManager->get('\TYPO3\CMS\Extbase\Configuration\ConfigurationManager');
		$configurationManager->injectObjectManager($this->objectManager);
		$configurationManager->setConfiguration($this->getConfiguration());
		$persistenceManager = $this->objectManager->get('Tx_Extbase_Persistence_Manager');

		$this->dispatcher = $this->objectManager->get('Tx_Extbase_Dispatcher');
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