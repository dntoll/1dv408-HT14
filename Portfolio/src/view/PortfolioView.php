<?php

namespace view;
/**
 * @todo Refactor together with ProjectView and ParticipantView.
 * Some things might be better off in other views.
 */
class PortfolioView {
	private static $getLocation = "portfolio"; //Made static
	
	public function getOwner() {
		if (isset($_GET[self::$getLocation])) {
			return $_GET[self::$getLocation];
		}
		
		return NULL;
	}

	public function visitorHasChosenPortfolio() {
		if (isset($_GET[self::$getLocation])) 
			return true;

		return false;
	}

	public function showAll(\model\ParticipantList $portfolioOwners) {		
		$ret = "<h1>Show all</h1>";
		
		$ret .= "<ul>";
		foreach ($portfolioOwners->toArray() as $participant) {//Changed this to work with new navigation view.
			$ret .= "<li><a href='?action=".NavigationView::$actionShowUser."&".self::$getLocation."=" . 
					urlencode($participant->getUnique()) ."'>" . 
					$participant->getName(). "</a></li>";

		};
		
		$ret .= "</ul>";
		
		return $ret;
	}
}