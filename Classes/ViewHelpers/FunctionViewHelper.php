<?php
class Tx_MocHelpers_ViewHelpers_FunctionViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper  {

	/**
	 * @param string $f Function
	 * @param mixed $a Optional variable
	 * @param mixed $b Optional variable
	 * @param mixed $c Optional variable
	 * @param mixed $d Optional variable
	 * @return mixed
	 */
	public function render($f, $a = '', $b = '', $c = '', $d = '') {
		// Render variable $a as the children if argument is empty
		$a = ($a === '') ? $this->renderChildren() : $a;

		// Prevent empty values to return 0
		if($b !== '') {
			$int_b = is_int(intval($b));
		}
		$int_b = is_int($int_b);
		if($c !== '') {
			$int_c = is_int(intval($c));
		}
		$int_c = is_int($int_c);
		if($d !== '') {
			$int_d = is_int(intval($d));
		}
		$int_d = is_int($int_d);

		switch($f) {
			case 'ucfirst':
				return ucfirst((string)$a);

			case 'lcfirst':
				return lcfirst((string)$a);

			case 'strtolower':
				return strtolower((string)$a);

			case 'strtoupper':
				return strtoupper((string)$a);

			case 'ucwords':
				return ucwords((string)$a);

			case 'strip_tags':
				return strip_tags((string)$a);

			case 'html_entity_decode':
				return html_entity_decode((string)$a);

			case 'strftime':
				$b = $b ? $b : '%d %b %Y %H:%M';
				return strftime((string)$b, (int)$a);

			case 'date':
				$b = $b ? $b : 'd-m-Y H:i';
				return date((int)$a, (string)$b);

			case 'empty':
				return empty($a);

			case 'trim':
				return trim((string)$a);

			case 'uniqid':
				return uniqid();

			case 'time':
				return time();

			case 'vprintf':
				return vprintf($a, (array)$b);

			case 'vsprintf':
				return vsprintf($a, (array)$b);

			case 'substr_replace':
				if($int_d) {
					return substr_replace((string)$a, (string)$b, (int)$c, (int)$d);
				}
				return substr_replace((string)$a, (string)$b, (int)$c);

			case 'substr_count':
				if($int_c && $int_d) {
					return substr_count((string)$a, (string)$b, (int)$c, (int)$d);
				}
				if($int_c) {
					return substr_count((string)$a, (string)$b, (int)$c);
				}
				return substr_count((string)$a, (string)$b);

			case 'substr':
				if($int_c) {
					return substr((string)$a, (string)$b, (int)$c);
				}
				return substr((string)$a, (string)$b);

			case 'strtr':
				if(is_array($b)) {
					return strtr((string)$a, (array)$b);
				}
				return strtr((string)$a, (string)$b, (string)$c);

			case 'strtok':
				return strtok((string)$a, (string)$b);

			case 'strstr':
				return strstr((string)$a, (string)$b);

			case 'strstr':
				return strstr((string)$a, (string)$b);

			case 'strspn':
				if($int_c && $int_d) {
					return strspn((string)$a, (string)$b, (int)$c, (int)$d);
				}
				if($int_c) {
					return strspn((string)$a, (string)$b, (int)$c);
				}
				return strspn((string)$a, (string)$b);

			case 'strrpos':
				if($int_c) {
					return strrpos((string)$a, (string)$b, (int)$c);
				}
				return strrpos((string)$a, (string)$b);

			case 'strripos':
				if($int_c) {
					return strripos((string)$a, (string)$b, (int)$c);
				}
				return strripos((string)$a, (string)$b);

			case 'strrev':
				return strrev((string)$a);

			case 'strrchr':
				if($int_b) {
					return strrchr((string)$a, (int)$b);
				}
				return strrchr((string)$a, (string)$b);

			case 'strpos':
				if($int_c) {
					return strpos((string)$a, (string)$b, (int)$c);
				}
				return strpos((string)$a, (string)$b);

			case 'strpbrk':
				return strpbrk((string)$a, (string)$b);

			case 'strncmp':
				if($int_c) {
					return strncmp((string)$a, (string)$b, (int)$c);
				}
				return strncmp((string)$a, (string)$b);

			case 'strncasecmp':
				return strncasecmp((string)$a, (string)$b, (int)$c);

			case 'strnatcmp':
				return strnatcmp((string)$a, (string)$b);

			case 'strnatcasecmp':
				return strnatcasecmp((string)$a, (string)$b);

			case 'strlen':
				return strlen((string)$a);

			case 'stristr':
				return stristr((string)$a, (string)$b);

			case 'stripos':
				if($int_c) {
					return stripos((string)$a, (string)$b, (int)$c);
				}
				return stripos((string)$a, (string)$b);

			case 'stripslashes':
				return stripslashes((string)$a);

			case 'stripcslashes':
				return stripcslashes((string)$a);

			case 'strip_tags':
				if((string)$b) {
					return strip_tags((string)$a, (string)$b);
				}
				return strip_tags((string)$a);

			case 'strcspn':
				if($int_c && $int_d) {
					return strcspn((string)$a, (string)$b, (int)$c, (int)$d);
				}
				if($int_c) {
					return strcspn((string)$a, (string)$b, (int)$c);
				}
				return strcspn((string)$a, (string)$b);

			case 'strcoll':
				return strcoll((string)$a, (string)$b);

			case 'strcmp':
				return strcmp((string)$a, (string)$b);

			case 'strchr':
				return strchr((string)$a, (string)$b);

			case 'strcasecmp':
				return strcasecmp((string)$a, (string)$b);

			case 'str_word_count':
				if($int_b && (string)$c) {
					return str_word_count((string)$a, (int)$b, (string)$c);
				}
				if($int_b) {
					return str_word_count((string)$a, (int)$b);
				}
				return str_word_count((string)$a);

			case 'str_split':
				if($int_b) {
					return str_split((string)$a, (int)$b);
				}
				return str_split((string)$a);

			case 'str_shuffle':
				return str_shuffle((string)$a);

			case 'str_replace':
				return str_replace($a, $b, $c);

			case 'str_repeat':
				return str_repeat((string)$a, (string)$b);

			case 'str_pad':
				if((string)$c && $int_d) {
					return str_pad((string)$a, (string)$b, (string)$c, (int)$d);
				}
				if((string)$c) {
					return str_pad((string)$a, (string)$b, (string)$c);
				}
				return str_pad((string)$a, (string)$b);

			case 'str_ireplace':
				return str_ireplace((string)$a, (string)$b, (string)$c);

			case 'sprintf':
				return sprintf((string)$a, (string)$b, (string)$c, (string)$d);

			case 'sha1':
				return sha1((string)$a);

			case 'md5':
				return md5((string)$a);

			case 'rtrim':
				if((string)$b) {
					return rtrim((string)$a, (string)$b);
				}
				return rtrim((string)$a);

			case 'printf':
				return printf((string)$a, (string)$b, (string)$c, (string)$d);

			case 'quotemeta':
				return quotemeta((string)$a);

			case 'parse_str':
				return parse_str((string)$a);

			case 'ord':
				return ord((string)$a);

			case 'number_format':
				if($int_b && (string)$c && (string)$d) {
					return number_format((float)$a, (int)$b, (string)$c, (string)$d);
				}
				if($int_b) {
					return number_format((float)$a, (int)$b);
				}
				return number_format((float)$a);

			case 'implode':
				return implode((string)$b, (string)$a);

			case 'htmlspecialchars':
				if($int_b && (string)$c && (bool)$d) {
					return htmlspecialchars((string)$a, (int)$b, (string)$c, (bool)$d);
				}
				if($int_b && (string)$c) {
					return htmlspecialchars((string)$a, (int)$b, (string)$c);
				}
				if($int_b) {
					return htmlspecialchars((string)$a, (int)$b);
				}
				return htmlspecialchars((string)$a);

			case 'htmlspecialchars_decode':
				if($int_b) {
					return htmlspecialchars_decode((string)$a, (int)$b);
				}
				return htmlspecialchars_decode((string)$a);

			case 'htmlentities':
				if($int_b && (string)$c && (bool)$d) {
					return htmlentities((string)$a, (int)$b, (string)$c, (bool)$d);
				}
				if($int_b && (string)$c) {
					return htmlentities((string)$a, (int)$b, (string)$c);
				}
				if($int_b) {
					return htmlentities((string)$a, (int)$b);
				}
				return htmlentities((string)$a);

			case 'html_entity_decode':
				if($int_b && (string)$c) {
					return html_entity_decode((string)$a, (int)$b, (string)$c);
				}
				if($int_b) {
					return html_entity_decode((string)$a, (int)$b);
				}
				return html_entity_decode((string)$a);

			case 'explode':
				if($int_c) {
					return explode((string)$a, (string)$b, (int)$c);
				}
				return explode((string)$a, (string)$b);

			case 'chunk_split':
				if($int_b && $int_c) {
					return chunk_split((string)$a, (int)$b, (int)$c);
				}
				if($int_b) {
					return chunk_split((string)$a, (int)$b);
				}
				return chunk_split((string)$a);

			case 'chr':
				return chr((string)$a);

			case 'chop':
				if((string)$b) {
					return chop((string)$a, (string)$b);
				}
				return chop((string)$a);

			case 'addslashes':
				return addslashes((string)$a);

			case 'addcslashes':
				return addcslashes((string)$a, (string)$b);
		}
		
		// Throw new exception if the given function doesn't have a matching case
		throw new Tx_Fluid_Core_ViewHelper_Exception('Function not allowed in function viewhelper: "' . htmlspecialchars($f) . '".', 1300267763);
	}

}