<?php
require_once("model/userModel.php");
$u=new Usuario();
if(isset($_SESSION["ses_id"]))
{
	$perfilgral=$u->get_usuario_por_ses();
}
require_once("view/juegos.phtml");
?>