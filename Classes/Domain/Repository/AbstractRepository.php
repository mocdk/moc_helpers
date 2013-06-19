<?php
namespace MOC\MocHelpers\Domain\Repository;

/**
 * The abstract moc repository
 *
 * @scope singleton
 */
abstract class AbstractRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	/**
	 * Toggle for the query settings setRespectStoragePage option
	 *
	 * @var boolean
	 */
	protected $respectStoragePage = FALSE;

	/**
	 * Override the RespectStoragePage setting
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryInterface
	 */
	public function createQuery() {
		$query = parent::createQuery();
		$query->getQuerySettings()->setRespectStoragePage($this->respectStoragePage);
		return $query;
	}

	/**
	 * Find all objects with a given list of uids
	 *
	 * @param array $uids array of uids
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	public function findByUids(array $uids = array()) {
		$this->query = $this->createQuery();
		$criterion = $this->query->equals('uid', array_pop($uids));
		if (is_array($uids)) {
			foreach ($uids as $uid) {
				$criterion = $this->query->logicalOr($criterion, $this->query->equals('uid', intval($uid)));
			}
		}
		return $this->query->matching($criterion)->execute();
	}

}