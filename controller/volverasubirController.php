<?php
require_once("config.php");
require_once("model/archivoModel.php");
require_once("model/userModel.php");
$p=new Archivos();
$u=new Usuario();
if(isset($_POST["grabar"]) and $_POST["grabar"]=="si")
{
	$p->volverasubir();
	exit;
}
$arch=$p->get_archivo_por_id();
$perfilgral=$u->get_usuario_por_ses();
require_once("view/volverasubir.phtml");
?>
