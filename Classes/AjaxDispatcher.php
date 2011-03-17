<?php

class tx_MocHelpers_AjaxDispatcher {

	function Dispatch($content, $conf) {
		if (!defined ('PATH_typo3conf')) die ('Could not access this script directly!');

		$extensionName = t3lib_div::_GET('extensionName');

		$pluginName = t3lib_div::_GET('pluginName');
		$plugin = strtolower($extensionName).'_'.strtolower($pluginName).'.';
		$tsparserObj = t3lib_div::makeInstance('t3lib_TSparser');
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

}

?>