<?php
class Tx_MocHelpers_Domain_Repository_MocRepository extends Tx_Extbase_Persistence_Repository{

	/**
	 * Toggle for the createQuery setRespectStoragePage option
	 *
	 * @var boolean
	 */
	protected $respectStoragePage = false;

	/**
	  * Override the RespectStoragePage setting
	 *
	 * @return Tx_Extbase_Persistence_QueryInterface
	 */
	public function createQuery(){
		$query = parent::createQuery();
		$query->getQuerySettings()->setRespectStoragePage($this->respectStoragePage);
		return $query;
	}

	 /**
	 * Find all objects with a given lidt of uids
	 *
	 * @param array $uids array of ids
	 */
	public function findByUids(array $ids = array()){
		$this->query = $this->createQuery();
		$criterion = $this->createUidEqualsCriterion(-1100);//-1100 has no significance, it only serves as a criterion precondition which will return no iterms
		foreach($ids as $id){
			$criterion = $this->query->logicalOr($criterion, $this->createUidEqualsCriterion($id));
		}
		return $this->query->matching($criterion)->execute();
	}

	/**
	 * Find by a given field / value combination
	 *
	 * @param string $field
	 * @param mixed $value
	 * @return array
	 */
	public function findBy($field, $value) {
		$Query = $this->createQuery();
		$Criterion = $Query->equals($field, $value);
		return $Query->matching($Criterion)->execute();
	}

	/**
	 * Count the number of records matching a given field / value combination
	 *
	 * @param string $field
	 * @param mixed $value
	 * @return integer
	 */
	public function countBy($field, $value) {
		$Query = $this->createQuery();
		$Criterion = $Query->equals($field, $value);
		return $Query->matching($Criterion)->count();
	}

	/**
	 * Find just one record by a field / value combination
	 *
	 * @param string $field
	 * @param mixed $value
	 * @return Tx_Extbase_DomainObject_AbstractEntity|null
	 */
	public function findOneBy($field, $value) {
		$query = $this->createQuery();
		$result = $query->matching($query->equals($field, $value))
    		->setLimit(1)
    		->execute();
		$object = NULL;
		if (count($result) > 0) {
    		$object = current($result);
		}
		return $object;
	}

	/**
	 * Saves an object and persist it at once
	 *
	 * @param Tx_Extbase_DomainObject_AbstractEntity $object
	 */
	public function save($object) {
		// Only allow to save valid objects, if the object supports it
		if (($object instanceof Tx_MocHelpers_Domain_Model_Abstract) && !$object->isValid()) {
			throw new Tx_MocHelpers_Domain_Repository_Exception('Object does not validate. Please check if all model validation rules has been upheld');
		}

		if (!$this->hasObject($object)) {
			$this->add($object);
		}

		$this->saveAll();
	}

	/**
	 * Check if the repository has an object
	 *
	 * @param Tx_Extbase_DomainObject_AbstractEntity $object
	 * @return boolean
	 */
	public function hasObject($object) {
		if (!($object instanceof $this->objectType)) {
			throw new Tx_Extbase_Persistence_Exception_IllegalObjectType('The object given to update() was not of the type (' . $this->objectType . ') this repository manages.', 1249479625);
		}

		return $this->identityMap->hasObject($object);
	}

	/**
	 * Insert or replaces an object
	 *
	 * If the record already exists, update it, else insert it by calling save
	 *
	 * @param Tx_Extbase_DomainObject_AbstractEntity $object
 	 * @return void
 	 */
	public function insertOrUpdate($object) {
		if (!($object instanceof $this->objectType)) {
			throw new Tx_Extbase_Persistence_Exception_IllegalObjectType('The object given to update() was not of the type (' . $this->objectType . ') this repository manages.', 1249479625);
		}

		if (!empty($value) && $this->exists($object) === 1) {
			$oldObject = $this->findBy('uid', $object->_getProperty('uid'));
			$object->setUid($object->getUid());

			$this->replace($oldObject, $object);
		} else {
			$this->save($object);
		}
	}

	/**
	 * Check if an object exists in the database
	 *
	 * @param Tx_Extbase_DomainObject_AbstractEntity $object
	 * @return boolean
	 */
	public function exists($object) {
		if (!($object instanceof $this->objectType)) {
			throw new Tx_Extbase_Persistence_Exception_IllegalObjectType('The object given to update() was not of the type (' . $this->objectType . ') this repository manages.', 1249479625);
		}

		$uid = $object->getUid();
		if (empty($uid)) {
			throw new Tx_Extbase_Persistence_Exception_UnknownObject('The "object" is does not have an existing counterpart in this repository.', 1249479819);
		}

		return 1 === $this->countByUid($uid);
	}

	/**
	 * @param int $id
	 */
	protected function createUidEqualsCriterion($id){
		return $this->query->equals('uid', $id);
	}

	public function saveAll(){
		$this->persistenceManager->persistAll();
	}

	public function logicalOrs($queries) {
		if(!$this->query) {
			$this->quuery = $this->createQuery();
		}
		$combined_ors = array_pop($queries);
		if (count($queries)) {
			foreach ($queries as $criterion) {
				$combined_ors = $this->query->logicalOr($criterion,$combined_ors);
			}
		}
		return $combined_ors;
	}
}