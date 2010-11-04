<?php
/**
 * Linkparsing ViewHelper for fluid
 *
 * Example:
 * 		{namespace moc=Tx_MocHelpers_ViewHelpers}
 *
 *		  <moc:parselinks parameter='{TypolinkCompatibleParameter}' />
 *
 */
class Tx_MocHelpers_ViewHelpers_ParselinksViewHelper extends Tx_Fluid_ViewHelpers_CObjectViewHelper  {

	/**
	 * @param int $max The max length of a link, if the link exceeds this it is prepended with "..."
	 * @return String content parsed for links
	 */
	public function render($max = 1000) {
		
		$content = $this->renderChildren();

		/*** convert all URLs with (http://*) into links ***/
		$content = preg_replace(
			"/([\w]+:\/\/[\w-?&;#~=\.\/\@]+[\w\/])/e",
			"'<a target=\"_blank\" href=\"\\1\">' . ((strlen('\\1') > $max) ? substr('\\1', 0, $max).'...' : '\\1') . '</a>'",
			$content
		);
		
		/*** convert all URLs with (www.*) into links ***/
		$content = preg_replace(
			'/([^\w\/])(www\.[a-z0-9\-]+\.[\w-?&;#~=\.\/\@]+[\w\/])/e',
			"'\\1<a target=\"_blank\" href=\"http://\\2\">' . ((strlen('\\2') > $max) ? substr('\\2', 0, $max).'...' : '\\2') . '</a>'",
			$content
		);
		
		/*** convert all emails into links ***/
		$content = preg_replace(
			'/([\w-?&;#~=\.\/]+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,4}|[0-9]{1,4})(\]?))/e',
			"'<a href=\"mailto:\\1\">' . ((strlen('\\1') > $max) ? substr('\\1', 0, $max).'...' : '\\1') . '</a>'",
			$content
		);
		
		return $content;
		
	}
}

?>
