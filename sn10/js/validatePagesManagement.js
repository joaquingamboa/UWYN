$(document).ready(function(){	
    var pageTitle="";
    var permalink="";
    var html_title="";
    var html_description="";
    var html_keywords=""
    var Cat_princ="";
    var html_content="";
    var idtedit="";
    var $myID = $('#idtedit');
    var $myPageTitle = $("#page_title");
    var $myPermaLink = $("#permalink");
    var $myHtmlTitle = $("#html_title");
    var $myHtmlKeywords = $("#html_keywords");
    var $myHtmlDescription = $("#html_description");
    var $myCategory = $("#categoria");
    var ppagetitle = $myPageTitle.val();
    var $myeditor = $("#editor");
    var $myfrom = $("#from");
    var from = "";
    
         
jQuery.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /^[a-z\s,]+$/i.test(value);
});             
function Display_Load(){
	  $("#loading").fadeIn(900,0);
          $("#loading").html("<img src='bigLoader.gif' />");
                        }

function Hide_Load(){
		$("#loading").fadeOut('slow');
                    };
	

$("#add-page").validate({
	rules:{
                page_title:{ required: true , minlength: 4, maxlength: 255},
		html_description:{ maxlength: 170,lettersonly: true } ,
                html_title:{ maxlength: 128 },
                html_keywords: { maxlength: 400, lettersonly: true }
	},
	messages:{
                page_title:{ required: "Campo Requerido", minlength: "Minimo 4 caracteres", maxlength: "Maximo 255 caracteres"},
		html_description:{ maxlength: "Maximo 170 caracteres", lettersonly: "Solo letras porfavor(Se aceptan comas [,])"},
                html_title: { maxlength: "Maximo 128 caracteres" },
                html_keywords:{ maxlength: "Maximo 400 caracteres", lettersonly: "Solo letras porfavor(Se aceptan comas [,])"}
	},
        submitHandler: function(form) {										   	
               $.ajax({
			type:"POST",
			dataType:"html",
			url: "modules/processpages.php",
			data:"&page_title="+pageTitle+"&titulo_html="+html_title+"&descripcion_html="+html_description+"&keywords="+html_keywords+"&contenido_html="+html_content+"&url="+permalink+"&principal_cat="+Cat_princ+"&tarea=add-page",
                        beforeSubmit: Display_Load(),
                        success:function(msg){
				alert(msg);
				window.setTimeout('window.location="index.php?page=paginas"',500);
								}
				});                   
                                                    
                                                    }
									}); 
                                                                        
 $("#edit-page").validate({
	rules:{
                page_title:{ required: true , minlength: 4, maxlength: 255},
		html_description:{ maxlength: 170,lettersonly: true } ,
                html_title:{ maxlength: 128 },
                html_keywords: { maxlength: 400, lettersonly: true }
	},
	messages:{
                page_title:{ required: "Campo Requerido", minlength: "Minimo 4 caracteres", maxlength: "Maximo 255 caracteres"},
		html_description:{ maxlength: "Maximo 170 caracteres", lettersonly: "Solo letras porfavor(Se aceptan comas [,])"},
                html_title: { maxlength: "Maximo 128 caracteres" },
                html_keywords:{ maxlength: "Maximo 400 caracteres", lettersonly: "Solo letras porfavor(Se aceptan comas [,])"}
	},
	submitHandler: function(form) {										   	
               $.ajax({
			type:"POST",
			url: "modules/processpages.php",
                        dataType: 'json',
			data:"&from="+from+"&cpermalink="+ppagetitle+"&idAEditar="+idtedit+"&page_title="+pageTitle+"&titulo_html="+html_title+"&descripcion_html="+html_description+"&keywords="+html_keywords+"&contenido_html="+html_content+"&url="+permalink+"&principal_cat="+Cat_princ+"&tarea=edit-page",
			beforeSubmit: Display_Load(),
                        success:function(msg){
                                Hide_Load();
                                if(msg[0]!=null){
                                 alert(msg[0]);    
                                }
                                if(msg[1]!=null){
                                $('#loading').html(msg[1]);   
                                }
                               
                           
								}
				});                   
                                                    
                                                    }
									}); 
 
                                                                     
$('#sentaddpage').click(function(){                                                                    
    pageTitle = $.trim($myPageTitle.val()); 
    permalink = $.trim($myPermaLink.val());
    html_title = $.trim($myHtmlTitle.val());
    html_description = $.trim($myHtmlDescription.val());
    html_keywords = $.trim($myHtmlKeywords.val());
    Cat_princ = $myCategory.val();
    html_content = $myeditor.elrte('val');
    });
    
$('#senteditpage').click(function(){                                                                    
    pageTitle = $.trim($myPageTitle.val()); 
    permalink = $.trim($myPermaLink.val());
    html_title = $.trim($myHtmlTitle.val());
    html_description = $.trim($myHtmlDescription.val());
    html_keywords = $.trim($myHtmlKeywords.val());
    Cat_princ = $myCategory.val();
    html_content = $myeditor.elrte('val');
    idtedit = $myID.val();
    from = $myfrom.val();
    });    
    
$('#iremove').click(function(){
                    $myPermaLink.val("");
                    });
	
$myPageTitle.focusout(function(){
		var pl = $myPermaLink.val();
		pl = pl.trim();
		var pagetitle = $.trim($(this).val());
		if(pagetitle!="" && pl=="" && pagetitle!=ppagetitle){
			$.ajax({
				type:"POST",
				dataType:"html",
				url: "modules/processpages.php",
				data:"pagetitle="+pagetitle+"&tarea=permlink",
				success:function(msg){
                                if (msg == 1){
                                 alert("Titulo de la pagina ya existe");
                                }else{
				$myPermaLink.val(msg.toString());
                                }
                                                    }				
				});
                                                                    }
	
		});	
    
    
    });