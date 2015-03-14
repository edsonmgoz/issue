<?php
session_start();
class Conectar
{
	public function con()
	{
		// $con=mysql_connect("mysql.hostinger.es","u193364967_issue","burilao777");
		// mysql_query("SET NAMES 'utf8'");
		// mysql_select_db("u193364967_issue");
		// return $con;

		$con=mysql_connect("localhost","root","");
		mysql_query("SET NAMES 'utf8'");
		mysql_select_db("issue");
		return $con;
	}
	public static function ruta()
	{
		// return "http://www.issue.hol.es/";
		return "http://localhost/issue/";
	}
	public function comillas_inteligentes($valor)
	{
		//Retirar las barras
		if(get_magic_quotes_gpc())
		{
			$valor=stripslashes($valor);
		}
		//Colocar comillas si no es entero
		if(!is_numeric($valor))
		{
			$valor= "'" . mysql_real_escape_string($valor) . "'";
		}
		return $valor;
	}
}
?>