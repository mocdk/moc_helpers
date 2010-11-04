<?php
class Tx_MocHelpers_Domain_Repository_MocRepository extends Tx_Extbase_Persistence_Repository{
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

	public function save($object){
		if(!$this->identityMap->hasObject($object)){
			$this->add($object);
		}
		$this->saveAll();
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