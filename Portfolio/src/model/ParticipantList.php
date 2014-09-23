<?php

namespace model;

require_once("Participant.php");

/**
 * Type secure collection of participants.
 */
class ParticipantList {
	private $portfolioOwners;
	
	public function __construct() {
		$this->portfolioOwners = array();
	}
	
	/**
	 * Returns an array of the participants.
	 *
	 * @return Array
	 */
	public function toArray() {
		
		return $this->portfolioOwners; 
	}
	
	/**
	 * Add a new participant to the list.
	 * 
	 * @param \model\Participant $participant
	 * 
	 * @return Void
	 */
	public function add(Participant $participant) {
		if (!$this->contains($participant))
			$this->portfolioOwners[] = $participant;
	}
	
	/**
	 * Check if a participant can be found within the list.
	 * 
	 * @param \model\Participant $participant The needle to look for.
	 * 
	 * @return Boolean
	 */
	public function contains(Participant $participant) {
		foreach($this->portfolioOwners as $key => $owner) {
			if ($owner->getUnique() == $participant->getUnique() && $owner->getName() == $participant->getName()) {
				return true;
			}
		}
		
		return false;
	}
}