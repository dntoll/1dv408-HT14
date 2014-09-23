<?php
namespace model;

require_once('./src/model/ProjectList.php');

class Participant {
	private $uniqueKey;
	private $name;
	private $projects;
	
	/**
	 * Constructor containing mocked overloading in PHP.
	 */
	public function __construct($name, $unique = NULL, ProjectList $projects = NULL) {
		$this->uniqueKey = ($unique == NULL) ? \uniqid() : $unique;
		$this->projects = ($projects == NULL) ? new ProjectList(): $projects;
		$this->name = $name;
	}

	/**
	 * @return String
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return String
	 */
	public function getUnique() {
		return $this->uniqueKey;
	}
	
	/**
	 * Generate a new unique random string ID for a user. 
	 *
	 * @return Void
	 */
	public function setUnique() {
		$this->uniqueKey = \uniqid();
	}
	
	/**
	 * Add a new project to the user.
	 * Do not add empty projects!
	 * 
	 * @param \model\Project $project Instance of the populated project to add. 
	 * @return Void
	 */
	public function add(\model\Project $project) {
		$this->projects->add($project);
	}
	
	/**
	 * @return \model\ProjectList
	 */
	public function getProjects() {
		return $this->projects;
	}
}