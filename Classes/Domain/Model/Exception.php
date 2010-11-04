<?php
abstract class Tx_MocHelpers_Domain_Model_Exception extends Exception{
	private $pattern;
	private $arguments;
	protected function initializeWithPattern($pattern){
		$parameters = array_reverse(func_get_args());
		$pattern = array_pop($parameters);
		$arguments = array_reverse($parameters);
		$this->message = ($this->generateMessage($pattern, $arguments));
		$this->setPattern($pattern);
		$this->setArguments($arguments);
		return $e;
	}

	
	/**
	 * Should be implemented as follows, the reason that the body is not implemented in this class is PHPs poor implementation of static
	 *
	 * 
	 */
	abstract public static function createWithPattern();
	


	protected static function generateMessage($pattern, $arguments){
		return vsprintf($pattern, $arguments);
	}

	public function getPattern(){
		return $this->pattern;
	}

	public function getArguments(){
		return $this->arguments;
	}

	protected function setPattern($pattern){
		$this->pattern = $pattern;
	}

	protected function setArguments($arguments){
		$this->arguments = $arguments;
	}
}