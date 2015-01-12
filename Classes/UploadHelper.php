<?php
namespace Moc\MocHelpers;
class UploadHelper {

	/**
	 * @var \TYPO3\CMS\Core\Utility\File\BasicFileUtility
	 */
	protected $basicFileFunctions;

	/**
	 * @param \TYPO3\CMS\Core\Utility\File\BasicFileUtility $basicFileFunctions
	 * @return void
	 */
	public function injectBasicFileFunctions(\TYPO3\CMS\Core\Utility\File\BasicFileUtility $basicFileFunctions) {
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
		} catch(\Exception $e) {
			array_push($savedFiles, $e->getMessage());
		}
		return $savedFiles;
	}

	/**
	 * @param array $fileInfo
	 * @param string $destinationFolder
	 */
	public function copyFileToDestinationFolder($fileInfo, $destinationFolder) {
		$error = \TYPO3\CMS\Core\Utility\GeneralUtility::mkdir_deep(PATH_site, $destinationFolder);
		if ($error) {
			throw new \Exception($error);
		}

		//$fileInfo['name'] = $this->basicFileFunctions->cleanFileName($fileInfo['name']);

		if (strlen($fileInfo['name']) > 60) {
			throw new \Exception(sprintf('File name too long: %s', $fileInfo['name']));
		}

		if ($fileInfo['size'] > (\TYPO3\CMS\Core\Utility\GeneralUtility::getMaxUploadFileSize() * 1024)) {
			throw new \Exception(sprintf('File size too large: %s, %s', $fileInfo['name'], \TYPO3\CMS\Core\Utility\GeneralUtility::formatSize($fileInfo['size'], ' bytes| KB| MB| GB')));
		}

		$filepath = $this->checkFilepath($destinationFolder . $fileInfo['name']);

		\TYPO3\CMS\Core\Utility\GeneralUtility::upload_copy_move($fileInfo['tmp_name'], PATH_site . $filepath);

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