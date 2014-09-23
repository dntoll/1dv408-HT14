<?php
namespace view;

require_once('./src/model/Project.php');

class ProjectView {
	
	private static $name = 'name';
	private static $userUnique = 'userUnique';
	
	/**
	 * Populate a project model with information from a view
	 * @todo create stupid project that can be used to populate a smart project?
	 * 
	 * @return \model\Project
	 */
	public function getProject() {
		if($this->getName() != NULL) {
			$projectName = $this->getName();
			return new \model\Project($projectName);
		}
	}
	
	/**
	 * Generate HTML form to create a new project bound to a participant.
	 * 
	 * @param \model\Participant $owner The participant that should get the project registred to it.
	 * 
	 * @return String HTML
	 */
	public function getForm(\model\Participant $owner) {
		$userUnique = $owner->getUnique();
		
		$html = "<h1>Add project to ". $owner->getName()."</h1>";
		$html .= "<form action='?action=".NavigationView::$actionAddProject."' method='post'>";
		$html .= "<input type='hidden' name='".self::$userUnique."' value='$userUnique' />";
		$html .= "<input type='text' name='".self::$name."' />";
		$html .= "<input type='submit' value='Add project' />";
		$html .= "</form>";
		
		return $html;
	}
	
	/**
	 * Fetches project name from a form.
	 * 
	 * @return String
	 */
	public function getName() {
		if (isset($_POST[self::$name])) {
			return $_POST[self::$name];
		}
		return null;
	}
	
	/**
	 * Fetches owner unique ID of a project owner.
	 * 
	 * @return String
	 */
	public function getOwnerUnique() {
		if (isset($_POST[self::$userUnique])) {
			return $_POST[self::$userUnique];
		}
		return NULL;
	}
}
