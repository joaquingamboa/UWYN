$(document).ready(function(){	
    var user="";
    var pass="";
jQuery.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /^[a-z]+$/i.test(value);
});    
    $("#login").validate({
	rules:{            
		password:{ required: true, maxlength: 8, minlength: 5},
                username:{ required: true, maxlength: 16, minlength: 4, lettersonly: true}    
	},

        
	messages:{
	       password:{
                    required : "Campo Requerido",
                    maxlength: "Maximo 8 caracteres",
                    minlength: "Minimo 5 caracteres"
                           },
               username: {
                    required : "Campo Requerido",
                    maxlength: "Maximo 16 caracteres",
                    minlength: "Minimo 4 caracteres",
                    lettersonly: "Solo letras porfavor"
                           }
	},
		  submitHandler: function(form) {    										   	
  		  $.ajax({
			type:"POST",
			url: "modules/processlogin.php",
			data:"&user="+user+"&pass="+pass+"&tarea=ajax",
			success:function(msg){
			window.location.href="index.php?page=inicio";
								}
				});
									 }
									});
                                                                        
    $("#submit").click(function(){
      user = $("#username").val();  
      pass = $("#password").val();  
      user = $.trim(user);
      pass = $.trim(pass);
    });                                 
								});