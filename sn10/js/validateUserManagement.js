$(document).ready(function(){	
   var tnoticias=[];   
   var tpaginas=[];
   var estado;
   var usuario;
   var nombredepila;
   var contrasena;
   var admin;
   var $myAdmin = $("#Administrador");
   var $myUsername = $("#username");
   var $myNickname = $("#nickname");
   var $myEstado = $("#estado");
   var $myPassword = $("#password");
   var $myId = $("#IdUser");
   var id;
   
jQuery.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /^[a-z]+$/i.test(value);
}); 

 if( $myAdmin.val()==0){
         $('input[name=tnoticias\\[\\]]').attr('disabled',false);   
         $('input[name=tpaginas\\[\\]]').attr('disabled',false);
               }else{
             $('input[name=tpaginas\\[\\]]').attr('disabled','disabled');
             $('input[name=tnoticias\\[\\]]').attr('disabled','disabled');
               }
           

    
$('#sentuser').click(function(){
    /* contnews = 0;
      contpages = 0; */
    tnoticias.length = 0;
    tpaginas.length = 0; 
    admin = $myAdmin.val(); 
    usuario = $myUsername.val();
    nombredepila = $myNickname.val();
    estado = $myEstado.val();
    contrasena = $myPassword.val();
    usuario = $.trim(usuario);
    nombredepila = $.trim(nombredepila);
    estado = $.trim(estado);
    contrasena = $.trim(contrasena);
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
    });

$('#euser').click(function(){
    /* contnews = 0;
      contpages = 0; */
    tnoticias.length = 0;
    tpaginas.length = 0;
    id = $myId.val();
    admin = $myAdmin.val(); 
    usuario = $myUsername.val();
    nombredepila = $myNickname.val();
    estado = $myEstado.val();
    contrasena = $myPassword.val();
    usuario = $.trim(usuario);
    nombredepila = $.trim(nombredepila);
    estado = $.trim(estado);
    contrasena = $.trim(contrasena);
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
    });

$("#euser").validate({
	rules:{
		username:{ required: true, maxlength: 16, minlength: 4, lettersonly: true},
                password:{ required:true, maxlength: 8, minlength: 5},
		nickname:{ required:true, maxlength: 50, minlength: 4}
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
                    maxlength: "Maximo 40 caracteres",
                    minlength: "Minimo 4 caracteres",
                    remote: "Nickname en Uso"
                           }
	},
         submitHandler: function(form) {										   	
  		  $.ajax({
			type:"POST",
			dataType:"html",
			url: "modules/processuser.php",
			data:"&idTEdit="+id+"&usuario="+usuario+"&nombredepila="+nombredepila+"&contrasena="+contrasena+"&estado="+estado+"&tpaginas="+tpaginas+"&tnoticias="+tnoticias+"&administrador="+admin+"&tarea=edit-user",
			success:function(msg){
				alert(msg);
				window.setTimeout('window.location="index.php?page=usuarios"',500)
								}
				});
					 }
									}); 

$("#nuser").validate({
	rules:{
		username:{ required: true, maxlength: 16, minlength: 4, lettersonly: true, remote:"modules/processuser.php?tarea=getUsernameInUse&username="+usuario, async: false},
                password:{ required:true, maxlength: 8, minlength: 5},
		nickname:{ required:true, maxlength: 50, minlength: 4, remote:"modules/processuser.php?tarea=getNicknameInUse&nickname="+nombredepila, async: false}
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
			data:"&usuario="+usuario+"&nombredepila="+nombredepila+"&contrasena="+contrasena+"&estado="+estado+"&tpaginas="+tpaginas+"&tnoticias="+tnoticias+"&administrador="+admin+"&tarea=add-user",
			success:function(msg){
				alert(msg);
				window.setTimeout('window.location="index.php?page=usuarios"',500)
								}
				});
					 }
									});  

     $myAdmin.change(function(){
        if( $myAdmin.val()==0){
         $('input[name=tnoticias\\[\\]]').attr('disabled',false);   
         $('input[name=tpaginas\\[\\]]').attr('disabled',false);
               }else{
             $('input[name=tpaginas\\[\\]]').attr('disabled','disabled');
             $('input[name=tnoticias\\[\\]]').attr('disabled','disabled');
               }
           });

      $myAdmin.click(function(){
        if( $myAdmin.val()==0){
         $('input[name=tnoticias\\[\\]]').attr('disabled',false);  
         $('input[name=tpaginas\\[\\]]').attr('disabled',false);
               }else{
             $('input[name=tnoticias\\[\\]]').attr('disabled','disabled');     
             $('input[name=tpaginas\\[\\]]').attr('disabled','disabled');
             
               }
           });
});
       
