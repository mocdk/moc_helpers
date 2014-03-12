<?php
namespace MOC\MocHelpers\ViewHelpers;

class CachingViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * @var \TYPO3\CMS\Core\Cache\Frontend\StringFrontend
	 */
	protected $cache;

	/**
	 * @return void
	 */
	public function initializeObject() {
		$this->cache = $GLOBALS['typo3CacheManager']->getCache('mochelpers_cachingviewhelper');
	}

	/**
	 * @param string|array $identifier
	 * @param array $tags
	 * @param integer $lifetime
	 * @return string
	 */
	public function render($identifier, $tags = array(), $lifetime = 0) {
		if (is_array($identifier)) {
			$identifier = md5(serialize($identifier));
		}
		$content = $this->cache->get($identifier);
		if ($content === FALSE) {
			$content = $this->renderChildren();
			$this->cache->set($identifier, $content, $tags, $lifetime);
		}
		return $content;
	}

}