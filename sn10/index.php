<?php
$path = "http://".$_SERVER['HTTP_HOST']."/".basename(getcwd())."/";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mi pagina modular Parte 2</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="tables.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript">
$(document).ready(function(){	
    var ubd="";
    var cbd="";
    var adminpass="";
    var anick="";
    var $myubd = $("#ubd");
    var $mycbd = $("#cbd");
    var $myadminpass = $("#adminpass");
    var $mynick = $("#anick");
    var $mypath = $("#path");
    
         
jQuery.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /^[a-z\s,]+$/i.test(value);
});             

$("#instalacion").validate({
	rules:{
                ubd:{ required: true , minlength: 4, maxlength: 20, lettersonly:true},
                adminpass:{ maxlength: 20, required:true },
                anick:{required: true, maxlength: 40, minlength: 4}
	},
	messages:{
                ubd:{ required: "Campo Requerido", minlength: "Minimo 4 caracteres", maxlength: "Maximo 20 caracteres", lettersonly: "Solo letras"},
                adminpass: { maxlength: "Maximo 20 caracteres", required: "Campo Requerido" },
                anick:{required: "Campo Requerido", maxlength: "Maximo 40 caracteres",  minlength: "Minimo 4 caracteres"}
	},
		  submitHandler: function(form) {										   	
               $.ajax({ 
			type:"POST",
			dataType:"html",
			url: "modules/processinstalacion.php",
			data:"&userbd="+ubd+"&contrabd="+cbd+"&passadmin="+adminpass+"&nickname="+anick+"&path="+path+"&tarea=instalar",
			success:function(msg){
                            if (msg == 3){
                            alert('Error al crear archivo de inicio');
                            window.setTimeout('window.location="index.php"',500);    
                            }
                            if (msg == 2){
                            alert('Hubo un error al crear el usuario');
                            window.setTimeout('window.location="index.php"',500);    
                            }
                             if (msg == 1){
                            alert('Instalacion Completada');
                            window.setTimeout('window.location="index.php"',500);    
                            }  
                       
								}
				});                   
                                                    
                                                    }
									}); 
                                                                     
$('#instalar').click(function(){                                                                    
    ubd = $.trim($myubd.val()); 
    cbd = $.trim($mycbd.val());
    adminpass = $.trim($myadminpass.val());
    anick = $.trim($mynick.val());
    path = $mypath.val();
    });
});
</script>   
<style type="text/css">
label.error { 
			float: none; color: red; padding-left: .5em;
			}

/* .submit { margin-left: 12em; }*/

</style>
</head>
    <body>
<div style="width:580px;margin:0 auto;">        
<h1 style="text-align:center;">Instalador UWYN CMS</h1>
<span style="font-weight: bold;font-size: 12px;text-align:center;">Yo me encargare de crear la base de datos, y configurar las rutas de los archivos</span><br/>
<span style="color:red;font-size:10px;font-weight: bold;text-align:center;">***ASEGURESE DE QUE LA BASE DE DATOS NO ESTE CREADA, SI LO ESTA LA BORRARE</span><br/>
<form id="instalacion" name="instalacion" action="#" method="POST">
    <input type="hidden" id="path" name="path" value="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/" . basename(getcwd()) . "/";?>" />
<table class="lst" style="margin: 0 auto;">
    <tr>
        <td colspan="2" style="text-align:center;"><h2>DATOS DE INSTALACION</h2></td>
    </tr>
    <tr>
        <td>Ruta de instalación del sistema :</td>
        <td> <?php echo "http://".$_SERVER['HTTP_HOST']."/".basename(getcwd())."/" ?></td>
    </tr>
    <tr>
        <td><label for="ubd">Usuario base de datos :</label></td>
        <td><input style="float:left;" type="input" name="ubd" id="ubd" /></td>
    </tr>
    <tr>
        <td><label for="cbd">Contrasena base de datos :</label></td>  
        <td><input style="float:left;" type="password" name="cbd" id="cbd" /></td>
    </tr>
    <tr>
        <td>Nombre de la base de datos :</td>
        <td><span style="font-weight: bold">uwyn</span>&nbsp;&nbsp; </td>
    </tr>
    <tr>
        <td>Usuario administrador sistema:</td>
        <td><span style="font-weight: bold">admin</span></td>
    </tr>
    <tr>
        <td><label for="anick">Nickname para admin:</label></td>
        <td><input style="float:left;" type="input" name="anick" id="anick"/></td>
    </tr>
    <tr>
        <td><label for="adminpass">Contrasena para admin:</label></td>
        <td><input style="float:left;" type="password" name="adminpass" id="adminpass"/></td>
    </tr>
    <tr>
        <td colspan="2"><input style="float:right;" type="submit" id="instalar" value="Instalar"/></td>
    </tr>
</table>

</form>
</div>
  </body>
  
</html>