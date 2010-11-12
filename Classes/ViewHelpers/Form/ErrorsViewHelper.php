<?php
class Tx_MocHelpers_ViewHelpers_Form_ErrorsViewHelper extends Tx_Fluid_ViewHelpers_Form_ErrorsViewHelper {
	/**
	 * Iterates through selected errors of the request.
	 *
	 * @param string $for The name of the error name (e.g. argument name or property name). This can also be a property path (like blog.title), and will then only display the validation errors of that property.
	 * @param string $as The name of the variable to store the current error
	 * @param boolean $numberOfErrors Number of errors to show
	 * @return string Rendered string
	 * @author Christopher Hlubek <hlubek@networkteam.com>
	 * @author Sebastian Kurfürst <sebastian@typo3.org>
	 * @api
	 */
	public function render($for = '', $as = 'error', $numberOfErrors = 1) {
		$errors = $this->controllerContext->getRequest()->getErrors();
		if ($for !== '') {
			$propertyPath = explode('.', $for);
			foreach ($propertyPath as $currentPropertyName) {
				$errors = $this->getErrorsForProperty($currentPropertyName, $errors);
			}
		}
		$output = '';
		$i = 0;
		foreach ($errors as $errorKey => $error) {
			if ($i >= $numberOfErrors) {
				break;
			}

			$this->templateVariableContainer->add($as, $error);
			$output .= $this->renderChildren();
			$this->templateVariableContainer->remove($as);

			$i++;
		}
		return $output;
	}
}