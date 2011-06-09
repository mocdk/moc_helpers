<?php
class Tx_MocHelpers_UploadHelper {

	/**
	 * @param string $destinationFolder
	 */
	public function saveFilesToFolder($destinationFolder) {
		try {
			foreach($_FILES as $file) {
				$this->copyFileToDestinationFolder($file, $destinationFolder);
			}
		} catch(Exception $e) {
			return $e->getMessage();
		}
		return TRUE;
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
		$filepath = $this->checkFilepath($destinationFolder . $fileInfo['name']);

		t3lib_div::upload_copy_move($fileInfo['tmp_name'], PATH_site . $filepath);

		return $filepath;
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