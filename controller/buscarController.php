<?php
require_once("config.php");
require_once("model/archivoModel.php");
require_once("model/userModel.php");
$p=new Archivos();
$u=new Usuario();
$buscar=$p->buscar_archivo();
if(isset($_SESSION["ses_id"]))
{
	$perfilgral=$u->get_usuario_por_ses();
}
require_once("view/buscar.phtml");
?>
