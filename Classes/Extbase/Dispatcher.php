<?php

class Tx_MocHelpers_Extbase_Dispatcher extends Tx_Extbase_Dispatcher {

	/**
	 * wrap method to be public
	 * @see typo3_src/typo3/sysext/extbase/Classes/Tx_Extbase_Dispatcher::initializeConfigurationManagerAndFrameworkConfiguration()
	 */
	public function initializeConfigurationManagerAndFrameworkConfiguration($configuration) {
		parent::initializeConfigurationManagerAndFrameworkConfiguration($configuration);
	}
}