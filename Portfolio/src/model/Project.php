<?php
namespace model;

class Project {
	private $unique;
	private $name;
	private $owner;
	
	public function __construct($name, $unique = NULL, $owner = NULL) {
		if (empty($name)) {
			throw new Exception('Name of project cannot be empty.');
		}
		$this->owner = $owner;
		$this->name = $name;
		$this->unique = ($unique == null) ? \uniqid() : $unique;
	}
	
	public function equals(Project $other) {
		return (
			$this->getName() == $other->getName() &&
			$this->getUnique() == $this->getUnique()
			);
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getUnique() {
		return $this->unique;
	}
	
	public function setOwner(Participant $owner) {
		$this->owner = $owner;
	}
	
	public function getOwner() {
		return $this->owner;
	}
}
