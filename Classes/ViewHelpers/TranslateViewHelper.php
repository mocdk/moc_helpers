<?php
/**
 * Translate a key from locallang. The files are loaded from the folder
 * "Resources/Private/Language/".
 */
class Tx_MocShop_ViewHelpers_TranslateViewHelper extends Tx_Fluid_ViewHelpers_TranslateViewHelper {

	/**
	 * @var Tx_Extbase_Configuration_ConfigurationManagerInterface
	 */
	protected $configurationManager;

	/**
	 * @param Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager
	 * @return void
	 */
	public function injectConfigurationManager(Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager) {
		$this->configurationManager = $configurationManager;
	}

	/**
	 * Translate a given key or use the tag body as default.
	 *
	 * @param string $key The locallang key
	 * @param string $default If the given locallang key could not be found, this value is used. If this argument is not set, child nodes will be used to render the default
	 * @param boolean $htmlEscape TRUE if the result should be htmlescaped. This won't have an effect for the default value
	 * @param array $arguments Arguments to be replaced in the resulting string
	 * @param string $extensionName
	 * @return string The translated key or tag body if key doesn't exist
	 * @author Christopher Hlubek <hlubek@networkteam.com>
	 * @author Bastian Waidelich <bastian@typo3.org>
	 * @author Aske Ertmann <aske@moc.net>
	 */
	public function render($key, $default = NULL, $htmlEscape = TRUE, array $arguments = NULL, $extensionName = '') {
		if ($extensionName === '') {
			$request = $this->controllerContext->getRequest();
			$settings = $this->configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
			$extensionName = isset($settings['extensionName']) ? $settings['extensionName'] : $request->getControllerExtensionName();
		}
		$value = Tx_Extbase_Utility_Localization::translate($key, $extensionName, $arguments);
		if ($value === NULL) {
			$value = $default !== NULL ? $default : $this->renderChildren();
		} elseif ($htmlEscape) {
			$value = htmlspecialchars($value);
		}
		return $value;
	}

}