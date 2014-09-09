<?php

 require_once("src/LikeModel.php");
 require_once("src/LikeView.php");

class LikeController {
	private $view;
	private $model;

	public function __construct() {
		$this->model = new LikeModel();
		$this->view = new LikeView($this->model);
	}

	public function doControll() {
		//Hantera indata
		if ($this->view->didUserPressLike()) {
			$this->model->addLike();
		}

		//Generera utdata
		return $this->view->showLikes();

	}
}