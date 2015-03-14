<?php
require_once("config.php");
require_once("model/userModel.php");
$u=new Usuario();
$perfil=$u->get_perfil();
$perfilgral=$u->get_usuario_por_ses();
require_once("view/perfil.phtml");
?>