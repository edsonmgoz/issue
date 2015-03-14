<?php
class Archivos extends Conectar
{

	private $archivo;
	private $get_usuario_archivo;
	private $muestra_busqueda_archivo;
	private $arch;
	private $get_usuario_suarchivo;

	public function add_archivo()
	{
		if(empty($_POST["titulo"])  or ($_POST["categoria"]=="Elegir") or empty($_FILES["archivo"]["name"]))
		{
			header("Location: ".Conectar::ruta()."?accion=subir&m=2");
			exit;
		}

		if($_FILES["archivo"]["type"]=="application/pdf" or $_FILES["archivo"]["type"]=="application/msword" or $_FILES["archivo"]["type"]=="application/vnd.openxmlformats-officedocument.wordprocessingml.document" or $_FILES["archivo"]["type"]=="application/vnd.ms-powerpoint" or $_FILES["archivo"]["type"]=="application/vnd.openxmlformats-officedocument.presentationml.presentation" or $_FILES["archivo"]["type"]=="text/plain")
		{
			if($_FILES["archivo"]["size"] < 6291456)
			{
				parent::con();
				$sql=sprintf
				(
					"select titulo from archivos where titulo=%s",
					parent::comillas_inteligentes($_POST["titulo"])
				);
				$res=mysql_query($sql);
				if(mysql_num_rows($res)==0)
				{
					$documento=date("d-m-Y")."_".date("h-i-s")."_".$_FILES["archivo"]["name"];
					$documentoutf=utf8_decode(date("d-m-Y")."_".date("h-i-s")."_".$_FILES["archivo"]["name"]);
					copy($_FILES["archivo"]["tmp_name"],"archivos/$documentoutf");
					$ses = $_SESSION["ses_id"];
					$query=sprintf
					(
						"insert into archivos values (null,%s,%s,%s,'$documento',now(),'$ses');",
						parent::comillas_inteligentes($_POST["titulo"]),
						parent::comillas_inteligentes($_POST["categoria"]),
						parent::comillas_inteligentes($_POST["descripcion"])
					);
					mysql_query($query);
					header("Location: ".Conectar::ruta()."?accion=subir&m=5");
				}
				else
				{
					header("Location: ".Conectar::ruta()."?accion=subir&m=6");
				}
			}
			else
			{
				header("Location: ".Conectar::ruta()."?accion=subir&m=4");
			}
		}
		else
		{
			header("Location: ".Conectar::ruta()."?accion=subir&m=3");
		}
	}

	public function get_mis_archivos()
	{
		$ses = $_SESSION["ses_id"];
		$sql="select *, date_format(fecha_archivo,'%d-%m-%Y') as fecha_archivo from archivos where id_usuario=$ses order by id_archivo desc";
		$res=mysql_query($sql,parent::con());
		while($reg=mysql_fetch_assoc($res))
		{
			$this->archivo[]=$reg;
		}
		return $this->archivo;
	}

	public function get_usuario_archivo()
	{
		$sql="select usuarios.id_usuario, usuarios.nombre_usuario, archivos.titulo, archivos.categoria, archivos.descripcion, archivos.archivo, date_format(fecha_archivo,'%d-%m-%Y') as fecha_archivo from usuarios, archivos where usuarios.id_usuario=archivos.id_usuario order by archivos.id_archivo desc";
		$res=mysql_query($sql,parent::con());
		while($reg=mysql_fetch_assoc($res))
		{
			$this->get_usuario_archivo[]=$reg;
		}
		return $this->get_usuario_archivo;
	}

	public function buscar_archivo()
	{
		if(isset($_POST["buscar"]))
		{
			$sql="select usuarios.id_usuario, usuarios.nombre_usuario, archivos.titulo, archivos.categoria, archivos.descripcion, archivos.archivo,date_format(fecha_archivo,'%d/%m/%Y')as fecha_archivo from usuarios, archivos where titulo like '%".$_POST["buscar"]."%' and usuarios.id_usuario=archivos.id_usuario order by archivos.id_archivo desc";
			$res=mysql_query($sql,parent::con());
			if(mysql_num_rows($res)==0)
			{
				echo "<script type='text/javascript'>
				alert('No hay Registros para este Criterio de Busqueda');
				window.location='".Conectar::ruta().".?accion=buscararchivo';
				</script>";
			}
			else
			{
				while($reg=mysql_fetch_array($res))
				{
					$this->muestra_busqueda_archivo[]=$reg;
				}
				return $this->muestra_busqueda_archivo; //retornamos el arreglo de repuestos
			}
		}
		else
		{
			header("Location: ".Conectar::ruta()."?accion=buscararchivo");
		}

	}


	public function get_archivo_por_id()
	{
		if(isset($_GET['id_archivo']) and $_GET['id_archivo'] > 0)
		{
			parent::con();
			$sql=sprintf
			(
				"select * from archivos where id_archivo=%s",
				parent::comillas_inteligentes($_GET["id_archivo"])
			);
			$res=mysql_query($sql);
			if(mysql_affected_rows() > 0)
			{
				while($reg=mysql_fetch_assoc($res))
				{
					$this->arch[]=$reg;
				}
				return $this->arch;
			}
			else
			{
				echo "<script type='text/javascript'>
				alert('Código de archivo no encontrado en la base de datos');
				window.location='".Conectar::ruta().".?accion=misarchivos';
				</script>";
			}
		}
		else
		{
			echo "<script type='text/javascript'>
			alert('Código de archivo invalido');
			window.location='".Conectar::ruta().".?accion=misarchivos';
			</script>";
		}
	}

	public function edit_archivo()
	{
		if(empty($_POST["titulo"]))
		{
			header("Location: ".Conectar::ruta()."?accion=editarchivo&m=1&id_archivo=".$_POST["id_archivo"]);
			exit;
		}
		//Validando que titulo de archivo no repita
		$id_arch = $_GET["id_archivo"];
		parent::con();
		$sql=sprintf
		(
			"select * from archivos where titulo=%s and id_archivo!='$id_arch'",
			parent::comillas_inteligentes($_POST["titulo"])
		);
		$res=mysql_query($sql);
		if(mysql_num_rows($res)==0)
		{
			parent::con();
			$sql=sprintf
			(
				"update archivos set titulo=%s, categoria=%s, descripcion=%s, fecha_archivo=now() where id_archivo=%s",
				parent::comillas_inteligentes($_POST["titulo"]),
				parent::comillas_inteligentes($_POST["categoria"]),
				parent::comillas_inteligentes($_POST["descripcion"]),
				parent::comillas_inteligentes($_POST["id_archivo"])
			);
			mysql_query($sql);
			header("Location: ".Conectar::ruta()."?accion=editarchivo&m=2&id_archivo=".$_POST["id_archivo"]); //Archivo editado con exito
		}
		else // el titulo de archivo ya existe
		{
			header("Location: ".Conectar::ruta()."?accion=editarchivo&m=3&id_archivo=".$_POST["id_archivo"]);
		}
	}

	public function volverasubir()
	{
		if(empty($_FILES["archivo"]["name"]))
		{
			header("Location: ".Conectar::ruta()."?accion=volverasubir&m=4&id_archivo=".$_POST["id_archivo"]);
			exit;
		}
		else
		{
			if($_FILES["archivo"]["type"]=="application/pdf" or $_FILES["archivo"]["type"]=="application/msword" or $_FILES["archivo"]["type"]=="application/vnd.openxmlformats-officedocument.wordprocessingml.document" or $_FILES["archivo"]["type"]=="application/vnd.ms-powerpoint" or $_FILES["archivo"]["type"]=="application/vnd.openxmlformats-officedocument.presentationml.presentation" or $_FILES["archivo"]["type"]=="text/plain")
			{
				if($_FILES["archivo"]["size"] < 6291456)
				{
					//Eliminando archivo actual
					parent::con();
					$query=sprintf
					(
						"select archivo from archivos where id_archivo=%s",
						parent::comillas_inteligentes($_POST["id_archivo"])
					);
					$res=mysql_query($query);
					if($reg=mysql_fetch_array($res))
					{
						unlink("archivos/".$reg["archivo"]);
					}
					//Subiendo el otro archivo
					$documento=date("d-m-Y")."_".date("h-i-s")."_".$_FILES["archivo"]["name"];
					$documentoutf=utf8_decode(date("d-m-Y")."_".date("h-i-s")."_".$_FILES["archivo"]["name"]);
					copy($_FILES["archivo"]["tmp_name"],"archivos/$documentoutf");
					$query=sprintf
					(
						"update archivos set archivo='$documento', fecha_archivo=now() where id_archivo=%s",
						parent::comillas_inteligentes($_POST["id_archivo"])
					);
					mysql_query($query);
					header("Location: ".Conectar::ruta()."?accion=volverasubir&m=1&id_archivo=".$_POST["id_archivo"]);
				}
				else// El archivo no debe exceder los 6 mb
				{
					header("Location: ".Conectar::ruta()."?accion=volverasubir&m=2&id_archivo=".$_POST["id_archivo"]);
				}
			}
			else //solo archivos doc, docx, etc.
			{
				header("Location: ".Conectar::ruta()."?accion=volverasubir&m=3&id_archivo=".$_POST["id_archivo"]);
			}
		}
	}

	public function delete_archivo()
	{
		if(isset($_GET["id_archivo"]))
		{
			parent::con();
			$query=sprintf
			(
				"select archivo from archivos where id_archivo=%s",
				parent::comillas_inteligentes($_GET["id_archivo"])
			);
			$res=mysql_query($query);
			if($reg=mysql_fetch_array($res))
			{
				unlink("archivos/".utf8_decode($reg["archivo"]));
			}
			$sql=sprintf
			(
				"delete from archivos where id_archivo=%s",
				parent::comillas_inteligentes($_GET["id_archivo"])
			);
			mysql_query($sql);
			header("Location: ".Conectar::ruta()."?accion=misarchivos&m=1");
			exit;

		}
		else
		{
			header("Location: ".Conectar::ruta()."?accion=misarchivos&m=2");
			exit;
		}
	}

	public function delete_su_archivo()
	{
		if(isset($_GET["id_archivo"]))
		{
			parent::con();
			$query=sprintf
			(
				"select archivo from archivos where id_archivo=%s",
				parent::comillas_inteligentes($_GET["id_archivo"])
			);
			$res=mysql_query($query);
			if($reg=mysql_fetch_array($res))
			{
				unlink("archivos/".utf8_decode($reg["archivo"]));
			}
			$sql=sprintf
			(
				"delete from archivos where id_archivo=%s",
				parent::comillas_inteligentes($_GET["id_archivo"])
			);
			mysql_query($sql);
			header("Location: ".Conectar::ruta()."?accion=archivosubidos&m=1&id_usuario=".$_GET["id_usuario"]);
			exit;
		}
		else
		{
			header("Location: ".Conectar::ruta()."?accion=archivosubidos&m=2&id_usuario=".$_GET["id_usuario"]);
			exit;
		}
	}

	public function get_usuario_sus_archivos()
	{
		$user_actual = $_GET["id_usuario"];
		$sql="select archivos.id_archivo, archivos.titulo, archivos.categoria, archivos.descripcion, archivos.archivo, archivos.id_usuario, usuarios.id_usuario, usuarios.nombre_usuario, date_format(fecha_archivo,'%d-%m-%Y') as fecha_archivo from usuarios, archivos where archivos.id_usuario=$user_actual and usuarios.id_usuario=$user_actual order by archivos.id_archivo desc";
		$res=mysql_query($sql,parent::con());
		while($reg=mysql_fetch_assoc($res))
		{
			$this->get_usuario_suarchivo[]=$reg;
		}
		return $this->get_usuario_suarchivo;
	}
}
?>