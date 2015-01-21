<?php
namespace Moc\MocHelpers;
class AjaxDispatcher {

	/**
	 *
	 * Dispatch ajax call to extbase controller, should be called as USER_INT from TypoScript
	 * @see typoscript/moc_helpers.ajax_dispatcher.setup.ts
	 */
	public function Dispatch() {
		if (!defined ('PATH_typo3conf')) die ('Could not access this script directly!');

		$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::_GET('extensionName');

		$pluginName = \TYPO3\CMS\Core\Utility\GeneralUtility::_GET('pluginName');
		$plugin = strtolower($extensionName).'_'.strtolower($pluginName).'.';
		$tsparserObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\TYPO3\CMS\Core\TypoScript\Parser\TypoScriptParser');
		// Get Typoscript
		$ts = $GLOBALS['TYPO3_CONF_VARS']['FE']['defaultTypoScript_setup.'][43];
		// Parse  Typoscript
		$tsparserObj->parse($ts);
		// Get Typoscript Config
		$conf = $tsparserObj->setup['tt_content.']['list.']['20.'][$plugin];
		if($conf) {
			$content = $GLOBALS['TSFE']->cObj->cObjGetSingle('USER_INT',$conf);
		}
		if($GLOBALS['TSFE']->isINTincScript()) {
			$GLOBALS['TSFE']->content = $content;
			$GLOBALS['TSFE']->INTincScript();
			$content = $GLOBALS['TSFE']->content;
		} else {
			return $content;
		}
	}

	/**
	 *
	 * Generate link to extbase ajax script thorugh dispatcher
	 * @param string $extension extension name extbase-style ie. MocHelpers
	 * @param string $plugin plugin name ie. pi1
	 * @param string $controller controller name CamelCase ie. AjaxRequest for AjaxRequestController
	 * @param string $action action name ie. index for indexAction
	 */
	public static function linkToAjaxBackend($extension,$plugin,$controller,$action) {
		$GETParamScopePrefix = 'tx_' . strtolower($extension) . '_' . strtolower($plugin);

		$params = array(
			'type' => 500,
			'extensionName' => $extension,
			'pluginName' => $plugin,
			 $GETParamScopePrefix => array (
			 	'controller' => $controller,
			 	'action' => $action
			 )
		);

		return \TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('TYPO3_REQUEST_SCRIPT') . '?' . http_build_query($params);
	}

}