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
	 * @param boolean $treatIdAsReference
	 * @return \TYPO3\CMS\Core\Resource\FileInterface|\TYPO3\CMS\Core\Resource\FolderInterface
	 */
	public function render($identifier = NULL, $treatIdAsReference = FALSE) {
		$identifier = $identifier ?: $this->renderChildren();
		if (\TYPO3\CMS\Core\Utility\MathUtility::canBeInterpretedAsInteger($identifier)) {
			if ($treatIdAsReference === TRUE) {
				$resource = $this->resourceFactory->getFileReferenceObject($identifier);
			} else {
				$resource = $this->resourceFactory->getFileObject($identifier);
			}
		} elseif (preg_match('/^(0|[1-9][0-9]*):/', $identifier)) { // combined identifier
			$resource = $this->resourceFactory->retrieveFileOrFolderObject($identifier);
		} else {
			$resource = $this->resourceFactory->retrieveFileOrFolderObject(\TYPO3\CMS\Core\Utility\GeneralUtility::resolveBackPath($identifier));
		}
		return $resource;
	}

}