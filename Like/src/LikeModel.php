 <?php

class LikeModel {
	private $sessionLocation = "LikeModel::NumLikes";
	
	public function __construct() {
		if (isset($_SESSION[$this->sessionLocation]) == false) {
			$_SESSION[$this->sessionLocation] = 0;
		}
	}

	public function getNumLikes() {
		return $_SESSION[$this->sessionLocation];
	}

	public function addLike() {
		$_SESSION[$this->sessionLocation]++;
	}
}