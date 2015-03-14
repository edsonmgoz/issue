<?php
if(isset($_SESSION["ses_id"]) and isset($_SESSION["privilegio"]) and $_SESSION["privilegio"]=='administrador')
{
	header("Location: ".Conectar::ruta()."?accion=administrador");
}

if(isset($_SESSION["ses_id"]) and isset($_SESSION["privilegio"]) and $_SESSION["privilegio"]=='usuario')
{
	header("Location: ".Conectar::ruta()."?accion=usuario");
}

require_once("model/userModel.php");
$u=new Usuario();

if(isset($_GET["accion"]) and $_GET["accion"] != "index")
{
	$u->control_de_acceso();
}
else
{
	if(isset($_POST["grabar"]) and $_POST["grabar"]=="si")
	{
		$u->logueo();
		exit;
	}
	require_once("view/index.phtml");
}
?>