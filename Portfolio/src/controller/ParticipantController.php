<?php

namespace controller;

//Dependencies
require_once("./src/view/PortfolioView.php");
require_once("./src/view/ParticipantView.php");
require_once("./src/view/ProjectView.php");
require_once("./src/model/ParticipantList.php");
require_once('./src/model/ParticipantRepository.php');
require_once('./src/model/ProjectRepository.php');

/**
 * Controller for participant related application flow.
 */
class ParticipantController {
	private $portfolioView;
	private $repository;
	private $participantView;
	private $projectRepository;

	/**
	 * Instantiate required views and required repositories.
	 */
	public function __construct() {
		$this->portfolioView = new \view\PortfolioView(); //Still required in class scope?
		$this->participantView = new \view\ParticipantView(); //Still required in class scope?
		$this->participantRepository = new \model\ParticipantRepository();
		$this->projectRepository = new \model\ProjectRepository();
	}

	/**
	* @return String HTML
	*/
	public function show() {
		if ($this->portfolioView->visitorHasChosenPortfolio() == false) {

			return $this->portfolioView->showAll($this->repository->toList());//DRY? Use $this->showAll()?

		} else {
			$owner = $this->participantRepository->get($this->portfolioView->getOwner());
			
			return $this->participantView->show($owner);
		}
	}
	
	/**
	 * Get the HTML required to show all participants.
	 * 
	 * @return String HTML
	 */
	public function showAll() {
		return $this->portfolioView->showAll($this->participantRepository->toList());
	}
	
	/**
	 * Controller function to add a user.
	 * 
	 * Function will return HTML or Redirect.
	 * 
	 * @return Mixed
	 */
	public function addUser() {
		if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
			$newUser = $this->participantView->getFormData();
			while ($this->participantRepository->toList()->contains($newUser)) {
				$newUser->setUnique();
			}
			
			$this->participantRepository->add($newUser);
			
			\view\NavigationView::RedirectHome(); //Redirect to newly created user?
		} else {
			return $this->participantView->getForm();
		}
	}
	
	/**
	 * Controller function to add a project.
	 * Function returns HTML or Redirect.
	 * 
	 * @TODO: Move to an own controller?
	 * 
	 * @return Mixed
	 */
	public function addProject() {
		$view = new \view\ProjectView();
		if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
			$project = $view->getProject();			
			$project->setOwner($this->participantRepository->get($view->getOwnerUnique()));
			
			$this->projectRepository->add($project);
			\view\NavigationView::RedirectToUser($view->getOwnerUnique());
		} else {
			return $view->getForm($this->participantRepository->get(\view\NavigationView::getId()));
		}
	}
}

