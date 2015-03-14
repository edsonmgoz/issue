<?php
require_once("config.php");
require_once("model/userModel.php");
$u=new Usuario();
if(isset($_POST["grabar"]) and $_POST["grabar"]=="si")
{
	$u->cambiar_pass();
	exit;
}
$u->get_usuario_por_id();
$perfilgral=$u->get_usuario_por_ses();
require_once("view/cambiarpass.phtml");
?>
