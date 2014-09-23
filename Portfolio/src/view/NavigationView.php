<?php
namespace view;

/**
 * Class containing static methods and functions for navigation.
 */
class NavigationView {
	private static $action = 'action';
	private static $id = 'id';
	
	public static $actionAddUser = 'add';
	public static $actionAddProject = 'addProject';
	public static $actionShowUser = 'show';
	public static $actionShowAll = 'showAll';
	
	/**
	 * Get the base menu with correct routed actions.
	 * 
	 * @return String HTML
	 */
	public static function getMenu(){
		$html = "<div id='menu'>";
		$html .= "<a href='?".self::$action."=".self::$actionShowAll."'>Show all</a>&nbsp;";
		$html .= "<a href='?".self::$action."=".self::$actionAddUser."'>Add user</a>&nbsp;";
		$html .= "</div>";
		return $html;
	}
	
	/**
	 * Get submenu for user section.
	 * 
	 * @param int $id Unique Key for the user the menu is created for.
	 * 
	 * @return String HTML
	 */
	public static function getUserMenu($id) {
		$html = "<div id='usermenu'>";
		$html .= "<a href='?".self::$action."=".self::$actionAddProject."&".self::$id."=$id'>Add project</a>&nbsp;";
		$html .= "</div>";
		return $html;
	}
	
	/**
	 * Return the current action asked for.
	 * 
	 * @todo Transform the action to a class of it's own?
	 * 
	 * @return String action
	 */
	public static function getAction() {
		if (isset($_GET[self::$action]))
			return $_GET[self::$action];
		
		return self::$actionShowAll;
	}
	
	/**
	 * Get a generic ID field.
	 * 
	 * @todo Create a "setId()" to connect it to the routing?
	 * 
	 * @return String
	 */
	public static function getId() {
		if (isset($_GET[self::$id])) {
			return $_GET[self::$id];
		}
		
		return NULL;
	}
	
	/**
	 * Redirect to home URL
	 */
	public static function RedirectHome() {
		header('Location: /repository/');
	}
	
	/**
	 * Redirect to a user page.
	 * 
	 * @todo Move to participant view?
	 * 
	 * @param String $uniqueString unique key for the user.
	 */
	public static function RedirectToUser($uniqueString) {
		header('Location: /Repository/?'.self::$action.'='.self::$actionShowUser.'&portfolio='.$uniqueString);
	}
}
