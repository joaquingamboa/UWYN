$(document).ready(function(){	
    var user="";
    var pass="";
    $("#login").validate({
	rules:{
		password:"required"
	},
        username: {
				required: true,
				email: true
			},
	messages:{
		password: "Campo requerido",
                username: "Debe ser un Email valido"
	},
		  submitHandler: function(form) {										   	
  		  $.ajax({
			type:"POST",
			url: "modules/processlogin.php",
			data:"&user="+user+"&pass="+pass+"&tarea=ajax",
			success:function(msg){
			window.location.href="index.php?page=index";
								}
				});
									 }
									});
                                                                        
    $("#submit").click(function(){
      user = $("#username").val();  
      pass = $("#password").val();  
      user = user.trim();
      pass = pass.trim();
    });                                                                   
                                                                        
                                                                        });