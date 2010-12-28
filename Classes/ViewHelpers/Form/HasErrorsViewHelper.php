<?php
class Tx_MocHelpers_ViewHelpers_Form_HasErrorsViewHelper extends Tx_Fluid_ViewHelpers_Form_ErrorsViewHelper {
	/**
	 * Iterates through selected errors of the request.
	 *
	 * @param string $for The name of the error name (e.g. argument name or property name). This can also be a property path (like blog.title), and will then only display the validation errors of that property.
	 * @param string $class The string to return if true
	 * @return string Rendered string
	 * @author Christopher Hlubek <hlubek@networkteam.com>
	 * @author Sebastian Kurfürst <sebastian@typo3.org>
	 * @api
	 */
	public function render($for = '', $class = '') {
		$errors = $this->controllerContext->getRequest()->getErrors();
		if ($for !== '') {
			$propertyPath = explode('.', $for);
			foreach ($propertyPath as $currentPropertyName) {
				$errors = $this->getErrorsForProperty($currentPropertyName, $errors);
			}
		}
		if(empty($errors)) {
			return false;
		} else {
			if(empty($class)) {
				return true;
			}
			return $class;
		}
	}
}