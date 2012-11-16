$(document).ready(function(){	
   var tnoticias=[];   
   var tpaginas=[];
   var estado;
   var usuario;
   var nombredepila;
   var contrasena;
   
jQuery.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /^[a-z]+$/i.test(value);
}); 
    
$('#sentuser').click(function(){
    contnews = 0;
    contpages = 0;
    tnoticias.length = 0;
    tpaginas.length = 0; 
    usuario = $("#username").val();
    nombredepila = $("#nickname").val();
    estado = $("#estado").val();
    contrasena = $("#password").val();
    usuario = usuario.trim();
    nombredepila = nombredepila.trim();
    estado = estado.trim();
    contrasena = contrasena.trim();
    $("input[name=tnoticias\\[\\]]").each(function(){
      if(this.checked == true){
       tnoticias.push($(this).val());  
      }
       });
     $("input[name=tpaginas\\[\\]]").each(function(){
      if(this.checked == true){
       tpaginas.push($(this).val()); 
      }
       });
    //   $.post("modules/processuser.php", { tnoticias: tnoticias, tpaginas: tpaginas} );
    });

$("#nuser").validate({
	rules:{
		username:{ required: true, maxlength: 16, minlength: 4, lettersonly: true, remote:"modules/processuser.php?tarea=getUsernameInUse&username="+usuario, async: false},
                password:{ required:true, maxlength: 8, minlength: 5},
		nickname:{ required:true, maxlength: 50, minlength: 4, remote:"modules/processuser.php?tarea=getNicknameInUse&nickname="+nickname, async: false}
	},
	messages:{
		username: {
                    required : "Campo Requerido",
                    maxlength: "Maximo 16 caracteres",
                    minlength: "Minimo 4 caracteres",
                    lettersonly: "Solo letras porfavor",
                    remote: "Usuario en Uso"
                           },
		password:{
                    required : "Campo Requerido",
                    maxlength: "Maximo 8 caracteres",
                    minlength: "Minimo 5 caracteres"
                           },
		nickname: {
                    required : "Campo Requerido",
                    maxlength: "Maximo 16 caracteres",
                    minlength: "Minimo 4 caracteres",
                    remote: "Nickname en Uso"
                           }
	},
         submitHandler: function(form) {										   	
  		  $.ajax({
			type:"POST",
			dataType:"html",
			url: "modules/processuser.php",
			data:"&usuario="+usuario+"&nombredepila="+nombredepila+"&contrasena="+contrasena+"&estado="+estado+"&tpaginas="+tpaginas+"&tnoticias="+tnoticias+"&tarea=add-user",
			success:function(msg){
				alert(msg);
				window.setTimeout('window.location="http://localhost/modular/sn10/index.php?page=noticias"',500)
								}
				});
					 }
									});  


});
       
