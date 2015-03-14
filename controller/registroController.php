<?php
require_once("config.php");
require_once("model/userModel.php");
$p=new Usuario();
if(isset($_POST["grabar"]) and $_POST["grabar"]=="si")
{
	$p->add_user();
	exit;
}
require_once("view/registro.phtml");
?>