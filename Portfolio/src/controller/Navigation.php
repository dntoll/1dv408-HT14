<?php
namespace controller;
require_once('./src/view/NavigationView.php');
require_once('./src/controller/ParticipantController.php');

/**
 * Navigation view for a simple routing solution.
 */
class Navigation {	
	
	/**
	 * Checks what controller to instansiate and return value of to HTMLView.
	 */
	public function doControll() {
		$controller;
		switch (\view\NavigationView::getAction()) {
			case \view\NavigationView::$actionAddUser:
				$controller = new ParticipantController();
				return $controller->addUser();
				break;
			case \view\NavigationView::$actionShowUser:
				$controller = new ParticipantController();
				return $controller->show();
				break;
				
			case \view\NavigationView::$actionAddProject:
				$controller = new ParticipantController();
				return $controller->addProject();
			default:
				$controller = new ParticipantController();
				return $controller->showAll();
				break;
		}
	}
}
