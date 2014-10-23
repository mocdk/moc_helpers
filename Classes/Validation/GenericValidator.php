<?php
class Tx_MocHelpers_Validation_GenericValidator extends Tx_MocHelpers_Validation_Abstract {

	/**
	 * @var array
	 */
	protected $errors = array();

	/**
	 * @var array
	 */
	protected $validation;

	/**
	 * @var array
	 */
	protected $data;

	/**
	 * @var string
	 */
	protected $defaultTCATable;

	/**
	 * @param array $validation
	 * @return void
	 */
	public function setValidation($validation) {
		$this->validation = $validation;
	}

	/**
	 * @param array $data
	 * @return void
	 */
	public function setData($data) {
		$this->data = $data;
	}

	/**
	 * Check if the current step is valid
	 *
	 * It's only valid if none of the validating objects
	 * returned an non-empty array when calling getErrors
	 *
	 * @return array
	 */
	protected function validate() {
		if($this->validation) {
			foreach($this->validation as $key => $value) {
				$this->validateKey($this->data, $key, $value);
			}
		}

		return $this->errors;
	}

	/**
	 * @param array $data
	 * @param string $key
	 * @param string $value
	 * @param array $path
	 * @return void
	 */
	protected function validateKey($data, $key, $value, $path = array()) {
		if(!is_array($data)) {
			return TRUE;

		}

		if($key === '*') {
			foreach($data as $rowKey => $row) {
				$rowPath = $path;
				array_push($rowPath, $rowKey);
				foreach($value as $subKey => $subValue) {
					$this->validateKey($row, $subKey, $subValue, $rowPath);
				}
			}
		} else {
			if(is_array($value)) {
				array_push($path, $key);
				foreach($value as $subKey => $subValue) {
					if($subKey === 'validations') {
						if(isset($value['if'])) {
							foreach($value['if'] as $ifKey => $ifValue) {
								if(isset($data[$ifKey])) {
									$matchValue = $data[$ifKey];
								} else {
									$matchValue = MOC_Array::extract($this->data, $ifKey);
								}
								if(is_array($ifValue)) {
									$regEx = empty($ifValue['regEx']) ? $ifValue['regularExpression'] : $ifValue['regEx'];
									$result = preg_match($regEx, $matchValue);
									if(($result === 0) || ($result === FALSE)) {
										continue 2;
									}
								} elseif($matchValue != $ifValue) {
									continue 2;
								}
							}
						}
						$subValue = MOC_Array::normalize($subValue);

						$this->addErrors($subValue, $data[$key], $path);
					} else {
						$subData = $data[$key];
						$this->validateKey($subData, $subKey, $subValue, $path);
					}
				}
			}
		}
	}

	/**
	 * @param array $rules
	 * @param array $data
	 * @param array $path
	 * @return void
	 */
	protected function addErrors($rules, $data, $path) {
		if(!is_array($rules)) {
			return;
		}

		foreach($rules as $rule => $arguments) {

			$validator = $this->validatorResolver->createValidator($rule, (array)$arguments);

			if($validator->isValid($data, array('path' => $path, 'data' => $this->data))) {
				continue;
			}

			$argumentPath = $path;

			$argument = array_shift($argumentPath);

			if(!array_key_exists($argument, $this->errors)) {
				$this->errors[$argument] = $this->objectManager->create('Tx_Extbase_MVC_Controller_ArgumentError', $argument);
			}

			$error = $this->errors[$argument];

			foreach($argumentPath as $property) {
				if(!array_key_exists($property, $error->getErrors())) {
					if(is_numeric($property)) {
						throw new MOC_Exception(sprintf('Numeric keys are not allowed as validation variables (%s) - array_merge renumbers numeric values.', $property));
					}
					$error->addErrors(array($property => $this->objectManager->create('Tx_Extbase_Validation_PropertyError', $property)));
				}
				$errors = $error->getErrors();
				$error = $errors[$property];
			}

			$error->addErrors($validator->getErrors());
		}
	}

	public function setDefaultTCATable($table) {
		$this->defaultTCATable = $table;
	}

	public function getTCAValidations($input, $table = null) {
		global $TCA;

		if(is_array($input)) {
			$return = array();

			$input = MOC_Array::normalize($input);

			foreach($input as $column => $value) {
				$return[t3lib_div::underscoredToLowerCamelCase($column)] = $this->getTCAValidations($column, $table);
				if(is_array($value)) {
					$return[t3lib_div::underscoredToLowerCamelCase($column)] = MOC_Array::merge($value, $return[t3lib_div::underscoredToLowerCamelCase($column)]);
				}
			}
			return $return;
		}

		if(stristr('.', $input) !== FALSE) {
			list($table, $input) = explode('.', $input);
		}

		$table = is_null($table) ? $this->defaultTCATable : $table;

		if(empty($table)) {
			throw new MOC_Exception('Table is not defined.');
		}

		if(!isset($TCA[$table]['columns'][$input])) {
			if (TYPO3_MODE === 'FE') {
				$GLOBALS['TSFE']->includeTCA();
			}
			t3lib_div::loadTCA($table);
			if(!isset($TCA[$table]['columns'][$input])) {
				throw new MOC_Exception(sprintf('%s.%s could not be found in the TCA.', $table, $input));
			}
		}

		$rules = isset($TCA[$table]['columns'][$input]['extbase']['validations']) ? $TCA[$table]['columns'][$input]['extbase']['validations'] : $TCA[$table]['columns'][$input]['validations'];

		return array(
			'validations' => (array)$rules
		);
	}

}