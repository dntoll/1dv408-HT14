<?php

namespace Controller;

require_once("/model/Palette.php");
require_once("/view/ColorPicker.php");


class SelectColor {
	/*
	* @var Palette model
	*/
	private $palette;

	/*
	* @var View view
	*/
	private $view;

	/**
	 * @param ModelSessionColorPersistor $persistance [description]
	 */
	public function __construct(\Model\SessionColorPersistor $persistance) {
		$this->palette = new \Model\Palette(10, $persistance);
		$this->view = new \View\ColorPicker($this->palette);
	}


	/**
	* @return String [HTML]
	*/
	public function doSelectColor() {

		if ($this->view->userHasSelectedColor() ) {
			try {
				$color = $this->view->getSelectedColor();
				$this->palette->setSelectedColor($color);
			} catch (\Exception $e) {
				$this->view->showErrorMessage();
			}
		}

		return $this->view->getHTML();
	}
}


