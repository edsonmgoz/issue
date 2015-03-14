function validar_logueo()
{
	var form=document.form;
	if (form.login.value==0)
	{
		alert("Ingrese su login");
		form.login.value="";
		form.login.focus();
		return false;
	}
	if (form.pass.value==0)
	{
		alert("Ingrese su password");
		form.pass.value="";
		form.pass.focus();
		return false;
	}
	form.pass.value=calcMD5(form.pass.value);
	form.submit();
}
function registro()
{
	var form=document.form;
	if (form.nombre.value==0)
	{
		alert("Ingrese su nombre completo");
		form.nombre.value="";
		form.nombre.focus();
		return false;
	}
	if (form.user.value==0)
	{
		alert("Ingrese su login");
		form.user.value="";
		form.user.focus();
		return false;
	}
	if (form.pass.value==0)
	{
		alert("Ingrese su password");
		form.pass.value="";
		form.pass.focus();
		return false;
	}
	if (form.pass_1.value==0)
	{
		alert("Repita el password");
		form.pass_1.value="";
		form.pass_1.focus();
		return false;
	}
	if (form.pass.value != form.pass_1.value)
	{
		alert("Los password ingresados no coinciden");
		form.pass.value="";
		form.pass_1.value="";
		form.pass.focus();
		return false;
	}
	form.pass.value=calcMD5(form.pass.value);
	form.pass_1.value=calcMD5(form.pass_1.value);
	form.submit();
}
function cambiar_pass()
{
	var form=document.form;
	if (form.pass_actual.value==0)
	{
		alert("Ingrese password actual");
		form.pass_actual.value="";
		form.pass_actual.focus();
		return false;
	}
	if (form.pass.value==0)
	{
		alert("Ingrese el nuevo password");
		form.pass.value="";
		form.pass.focus();
		return false;
	}
	if (form.pass_1.value==0)
	{
		alert("Repita el nuevo password");
		form.pass_1.value="";
		form.pass_1.focus();
		return false;
	}
	if (form.pass.value != form.pass_1.value)
	{
		alert("Los password ingresados no coinciden");
		form.pass.value="";
		form.pass_1.value="";
		form.pass.focus();
		return false;
	}
	form.pass_actual.value=calcMD5(form.pass_actual.value);
	form.pass.value=calcMD5(form.pass.value);
	form.pass_1.value=calcMD5(form.pass_1.value);
	form.submit();
}
function tr(id,color)
{
	document.getElementById(id).style.backgroundColor=color;
}
function eliminar(ruta)
{
	if(confirm("Realmente desea eliminar este registro ?"))
	{
		window.location=ruta;
	}
}
function deshabilitar(ruta)
{
	if(confirm("Desea deshabilitar usuario ?"))
	{
		window.location=ruta;
	}
}
function habilitar(ruta)
{
	if(confirm("Desea habilitar usuario ?"))
	{
		window.location=ruta;
	}
}