<?php
namespace view;

class ParticipantView {
	
	private static $name = 'name';
	
	/**
	 * Populate a new user model from form data.
	 * @todo Maybe put this in a controller? Create new user model that is dumber?
	 * 
	 * @return \model\Participant
	 */
	public function getFormData() {
		if (isset($_POST[self::$name])) {
			return new \model\Participant($_POST[self::$name]);
		}
		
		return NULL;
	}
	
	/**
	 * Retrieves the form to be used to when adding a new user.
	 * 
	 * @return String HTML
	 */
	public function getForm() {
		$html = "<h1>Add user</h1>";
		$html .= "<form method='post' action='?action=".NavigationView::$actionAddUser."'>";
		$html .= "<input type='text' name='".self::$name."'/>";
		$html .= "<input type='submit' value='Register User' />";
		$html .= "</form>";
		
		return $html;
	}
	
	/**
	 * Creates the HTML needed to display a participant with a list of projects.
	 * 
	 * @return String HTML
	 */
	public function show(\model\Participant $participant) {
		$ret = NavigationView::getUserMenu($participant->getUnique());
		$ret .= '<h1>' . $participant->getName() . '</h1>';
		$ret .= "<h2>Projects</h2>";
		$ret .= "<ul>";
		foreach($participant->getProjects()->toArray() as $project) {
			$ret .= "<li>".$project->getName()."</li>";
		}
		
		$ret .= "</ul>";
		
		return $ret;
	}
}
