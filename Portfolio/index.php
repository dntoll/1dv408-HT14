<?php
require_once("src/view/HTMLView.php");
require_once("src/controller/Navigation.php");
	
$view = new HTMLView();

$navigation = new \controller\Navigation();

$htmlBody = $navigation->doControll();

$view->echoHTML($htmlBody);
