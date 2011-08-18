<?php
class Tx_MocHelpers_UploadHelper {

	/**
	 * @var t3lib_basicFileFunctions
	 */
	protected $basicFileFunctions;

	/**
	 * @param t3lib_basicFileFunctions $basicFileFunctions
	 * @return void
	 */
	public function injectBasicFileFunctions(t3lib_basicFileFunctions $basicFileFunctions) {
		$this->basicFileFunctions = $basicFileFunctions;
	}

	/**
	 * @param string $destinationFolder
	 */
	public function saveFilesToFolder($destinationFolder) {
		$savedFiles = array();
		try {
			foreach($_FILES as $file) {
				array_push($savedFiles, $this->copyFileToDestinationFolder($file, $destinationFolder));
			}
		} catch(Exception $e) {
			array_push($savedFiles, $e->getMessage());
		}
		return $savedFiles;
	}

	/**
	 * @param array $fileInfo
	 * @param string $destinationFolder
	 */
	public function copyFileToDestinationFolder($fileInfo, $destinationFolder) {
		$error = t3lib_div::mkdir_deep(PATH_site, $destinationFolder);
		if ($error) {
			throw new Exception($error);
		}

		$fileInfo['name'] = $this->basicFileFunctions->cleanFileName($fileInfo['name']);

		if ($this->basicFileFunctions->checkFileNameLen($fileInfo['name']) === FALSE) {
			throw new Exception(sprintf('File name too long: %s', $fileInfo['name']));
		}

		if ($fileInfo['size'] > (t3lib_div::getMaxUploadFileSize() * 1024)) {
			throw new Exception(sprintf('File size too large: %s, %s', $fileInfo['name'], t3lib_div::formatSize($fileInfo['size'], ' bytes| KB| MB| GB')));
		}

		$filepath = $this->checkFilepath($destinationFolder . $fileInfo['name']);

		t3lib_div::upload_copy_move($fileInfo['tmp_name'], PATH_site . $filepath);

		return array('path' => $filepath, 'name' => pathinfo($filepath, PATHINFO_BASENAME));
	}

	/**
	 * @param string $originalFilepath
	 */
	public function checkFilepath($originalFilepath) {
		$filepath = $originalFilepath;
		$i = 0;
		while(file_exists(PATH_site . $filepath)) {
			$i++;
			$filepath = sprintf('%s/%s%u.%s', pathinfo($originalFilepath, PATHINFO_DIRNAME), pathinfo($originalFilepath, PATHINFO_FILENAME), $i, pathinfo($originalFilepath, PATHINFO_EXTENSION));
		}
		return $filepath;
	}

}