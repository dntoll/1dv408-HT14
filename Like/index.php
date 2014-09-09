 <?php
 require_once("../common/HTMLView.php");
 require_once("src/LikeController.php");


session_start();

//http://yuml.me/81b86d6b

$c = new LikeController();
$htmlBody = $c->doControll();

$view = new HTMLView(); 
$view->echoHTML($htmlBody);
 