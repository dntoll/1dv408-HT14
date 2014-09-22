<?php
namespace model;

class ProjectList {
	private $projects;
	
	public function __construct() {
		$this->projects = array();
	}
	
	public function toArray() {
		return $this->projects; 
	}
	
	public function add(Project $project) {
		if (!$this->contains($project))
			$this->projects[] = $project;
	}
	
	public function contains(Project $project) {
		foreach($this->projects as $key => $value) {
			if ($project->equals($value)) {
				return true;
			}
		}
		
		return false;
	}
}