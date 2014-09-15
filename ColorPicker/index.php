<?php

require_once("controller/SelectColor.php");

session_start();


$persistance = new \Model\SessionColorPersistor("colorSessionLocation");
$controller = new \Controller\SelectColor($persistance);

echo $controller->doSelectColor();
