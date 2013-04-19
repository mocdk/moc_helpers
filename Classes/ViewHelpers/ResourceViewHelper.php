<?php
namespace MOC\MocHelpers\ViewHelpers;

/**
 * A resource view helper to fetch files/folders resources from the File Abstraction Layer
 *
 * Example:
 * <f:alias map="{image: '{resourceUid -> moc:resource()}'}"><f:image src="{image.publicUrl}" /></f:alias>
 */
class ResourceViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * @var \TYPO3\CMS\Core\Resource\ResourceFactory
	 */
	protected $resourceFactory;

	/**
	 * @param \TYPO3\CMS\Core\Resource\ResourceFactory $resourceFactory
	 * @return void
	 */
	public function injectResourceFactory(\TYPO3\CMS\Core\Resource\ResourceFactory $resourceFactory) {
		$this->resourceFactory = $resourceFactory;
	}

	/**
	 * @param string $identifier
	 * @return \TYPO3\CMS\Core\Resource\FileInterface|\TYPO3\CMS\Core\Resource\Folder
	 */
	public function render($identifier = NULL) {
		return $this->resourceFactory->retrieveFileOrFolderObject($identifier ?: $this->renderChildren());
	}

}