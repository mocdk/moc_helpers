<?php
class Tx_MocHelpers_Domain_Repository_MocRepository extends Tx_Extbase_Persistence_Repository{
	public function createQuery(){
		$query = parent::createQuery();
		$query->getQuerySettings()->setRespectStoragePage(FALSE);
		return $query;
	}

	 /**
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

	public function findBy($field, $value) {
		$Query = $this->createQuery();
		$Criterion = $Query->equals($field, $value);
		return $Query->matching($Criterion)->execute();
	}

	public function countBy($field, $value) {
		$Query = $this->createQuery();
		$Criterion = $Query->equals($field, $value);
		return $Query->matching($Criterion)->count();
	}

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

	public function save($object){
		if (!$this->hasObject($object)) {
			$this->add($object);
		}
		$this->saveAll();
	}

	public function hasObject($Object) {
		if (!($Object instanceof $this->objectType)) {
			throw new Tx_Extbase_Persistence_Exception_IllegalObjectType('The object given to update() was not of the type (' . $this->objectType . ') this repository manages.', 1249479625);
		}

		return $this->identityMap->hasObject($Object);
	}

	public function insertOrUpdate($Object, $field = 'uid') {
		if (!($Object instanceof $this->objectType)) {
			throw new Tx_Extbase_Persistence_Exception_IllegalObjectType('The object given to update() was not of the type (' . $this->objectType . ') this repository manages.', 1249479625);
		}

		$value = $Object->_getProperty($field);
		if (!empty($value) && $this->countBy($field, $value) === 1) {
			$OldObject = $this->findBy($field, $value);
			$Object->setUid($Object->getUid());
			$this->replace($OldObject, $Object);
		} else {
			$this->save($Object);
		}
	}

	public function exists($Object) {
		if (!($Object instanceof $this->objectType)) {
			throw new Tx_Extbase_Persistence_Exception_IllegalObjectType('The object given to update() was not of the type (' . $this->objectType . ') this repository manages.', 1249479625);
		}

		$uid = $Object->getUid();
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