<?php



class LikeView {
	private $model;

	public function __construct(LikeModel $model) {
		$this->model = $model;
	}

	public function didUserPressLike() {
		if (isset($_GET["iLike"]))
			return true;
		return false;
	}

	public function showLikes() {

		$likes = $this->model->getNumLikes();
		$ret = "Antalet likes är $likes ";

		$ret .= "<a href='?iLike'>Like!</a>";

		if ($this->didUserPressLike())
			$ret .= " You like! ";

		return $ret;
	}
}