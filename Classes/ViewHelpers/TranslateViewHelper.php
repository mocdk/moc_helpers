<?php
namespace MOC\MocHelpers\ViewHelpers;

/**
 * Class TranslateViewHelper
 */
class TranslateViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\TranslateViewHelper {

	/**
	 * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
	 * @inject
	 */
	protected $configurationManager;

	/**
	 * Translate a given key or use the tag body as default.
	 *
	 * @param string $id The locallang id
	 * @return string The translated key or tag body if key doesn't exist
	 */
	protected function renderTranslation($id) {
		$request = $this->controllerContext->getRequest();

			// Set extension name to current settings if available
		if ($this->arguments['extensionName'] === NULL) {
			$settings = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
			$this->arguments['extensionName'] = isset($settings['extensionName']) ? $settings['extensionName'] : NULL;
		}

		$extensionName = $this->arguments['extensionName'] === NULL ? $request->getControllerExtensionName() : $this->arguments['extensionName'];
		$value = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($id, $extensionName, $this->arguments['arguments']);
		if ($value === NULL) {
			$value = $this->arguments['default'] !== NULL ? $this->arguments['default'] : $this->renderChildren();
			if (is_array($this->arguments['arguments'])) {
				$value = vsprintf($value, $this->arguments['arguments']);
			}
		} elseif ($this->arguments['htmlEscape']) {
			$value = htmlspecialchars($value);
		}
		return $value;
	}

}