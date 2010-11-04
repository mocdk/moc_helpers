<?php
/**
 * Linespli ViewHelper for fluid
 *
 * Takes a string, and explodeds it into lines useing wordwrap
 *
 * Example:
 * 		{namespace moc=Tx_MocHelpers_ViewHelpers}
 *
 *					<moc:linesplit text="{fb_entry.message}" as="line" width="50" cut="true" maxlines="3" >
 *						<span class="line">{line}</span><br />
 *					</moc:linesplit>
 *
 */
class Tx_MocHelpers_ViewHelpers_LinesplitViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * Converts a string into an array of lines with max $width characters in each lines, and only splitting on words.
	 *
	 * @param string $as The string to explode into lines
	 * @param string $as The name of the iteration variable
	 * @param int $width The column width og each line
	 * @param string $cut If the cut is set to TRUE, the string is always wrapped at or before the specified width. So if you have a word that is larger than the given width, it is broken apart.
	 * @param int $maxlines If set, then only this many lines are returned
	 * @param boolean $ellipsis If set, then the last returned line is appended with "..." if there are more than maxlines
	 * @return string The wordwrapped string

	 * @author Jan-Erik Revsbech <janerik@mocsystems.com>
	 * @api
	 */
	public function render($text, $as, $width = 70, $cut = false, $maxlines = 0, $ellipsis = false) {
	$maxlines = 4;
		$words = array();
		foreach(preg_split('%[\n,]+%', $text) as $line) {
			foreach(explode(' ', $line) as $word) {
				$split_word = wordwrap($word, $width, '********', $cut);
				foreach(explode('********', $split_word) as $splitted_word) {
					if(!empty($splitted_word)) {
						array_push($words, $splitted_word);
					}
				}
			}
		}

		$stripped_words = wordwrap(strip_tags($text), $width, '********', $cut);
		$count = 0;
		$word_count = 0;
		
		$splitted_words = explode('********', $stripped_words);
		
		foreach($splitted_words as $key => $value) {
			if(empty($value)) {
				unset($splitted_words[$key]);
			}
		}
		
		ksort($splitted_words);
	
		foreach($splitted_words as $keyValue => $singleElement) {
			$element_words = array();
			foreach(preg_split('%[\n,]+%', $singleElement) as $line) {
				$word_split = explode(' ', trim($line));
				foreach($word_split as $key => $value) {
					if(empty($value)) {
						unset($word_split[$key]);
					}
				}
				$line_count = count($word_split);
			}

			unset($string);
			
			for($i = 1; $i <= $line_count; $i++) {
				if($i > 1) {
					$string .= ' ' . $words[$word_count];
				} else {
					$string .= $words[$word_count];
				}
				$word_count++;
			}

			if($maxlines && $count == $maxlines) {
				break;
			}
			
			if($ellipsis && ((count($splitted_words) - 1) > $maxlines) && ($count+1 == $maxlines)) {
				$string = $string . '...';
			}

			$check = trim($string);
			
			if(!empty($check)) {
				$this->templateVariableContainer->add($as, $string);
				$output .= $this->renderChildren();
				$this->templateVariableContainer->remove($as);
				$count++;
			}
		}
		
		return $output;
	}

}

?>