<?php
class Tx_MocHelpers_ViewHelpers_MetaViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * @param string $tag
	 * @param string $content
	 * @return void
	 */
	public function render($tag = '', $content = '') {
		if(in_array(strtolower($tag), array('description', 'keywords'))) {
			if($content === '') {
				$content = $this->renderChildren();
			}
			$content = trim($content);
			if($content !== '') {
				if(strtolower($tag) == 'description') {
					$GLOBALS['TSFE']->page['description'] = $content;
					// Override the page's description field, to work with page.meta.DESCRIPTION.override.field = description
					$GLOBALS['TSFE']->cObj->data['description'] = $content;
				} else {
					$GLOBALS['TSFE']->page['keywords'] = $content;
					// Override the page's keywords field, to work with page.meta.KEYWORDS.override.field = keywords
					$GLOBALS['TSFE']->cObj->data['keywords'] = $content;
				}
			}
		} else {
			if($tag === '') {
				$tag = $this->renderChildren();
			}
			$GLOBALS['TSFE']->getPageRenderer()->addMetaTag(trim($tag));
		}
	}

}