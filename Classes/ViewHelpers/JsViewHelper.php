<?php
/**
 * Javascript ViewHelper for fluid
 * Prevents fluid from parsing braces in inline javascript as inline view helpers
 * Use a '\' in front of braces that you want to keep
 *
 * Example:
 * 		{namespace moc=Tx_MocHelpers_ViewHelpers}
 *
 *		<moc:js>
 *			var obj = \{'foobar':'{myobject:var}'\}
 *		</moc:js>
 *
 *		returns:
 *
 *		var obj = {'foobar':'TheParsedValue'}
 *
 */
class Tx_MocHelpers_ViewHelpers_JsViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * Renders a javascript object
	 *
	 * @param object $object 
	 * @param array $members
	 * @return string Rendered string
	 * @author Mads Brunn <mads@brunn.dk>
	 * @api
	 */
	public function render() {
		
		$js = $this->renderChildren();
		
		$js = str_replace(array('\{','\}'),array('{','}'),$js);
		
		return $js;
	}

}

?>