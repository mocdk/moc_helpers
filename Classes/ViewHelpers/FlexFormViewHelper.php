<?php
namespace MOC\MocHelpers\ViewHelpers;

class FlexFormViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * @var \TYPO3\CMS\Extbase\Service\FlexFormService
	 */
	protected $flexFormService;

	/**
	 * @param \TYPO3\CMS\Extbase\Service\FlexFormService $flexFormService
	 * @return void
	 */
	public function injectFlexFormService(\TYPO3\CMS\Extbase\Service\FlexFormService $flexFormService) {
		$this->flexFormService = $flexFormService;
	}

	/**
	 * @param string $flexForm
	 * @return array
	 */
	public function render($flexForm = '') {
		return $this->flexFormService->convertFlexFormContentToArray($flexForm === '' ? $this->renderChildren() : $flexForm);
	}

}