<?php
require_once("config.php");
require_once("model/archivoModel.php");
require_once("model/userModel.php");
$p=new Archivos();
$u=new Usuario();
$archivo=$p->get_mis_archivos();
$perfilgral=$u->get_usuario_por_ses();
require_once("view/misarchivos.phtml");
?>