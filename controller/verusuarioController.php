<?php
require_once("config.php");
require_once("model/userModel.php");
$u=new Usuario();
$usuario=$u->get_usuario();
$perfilgral=$u->get_usuario_por_ses();
require_once("view/verusuario.phtml");
?>