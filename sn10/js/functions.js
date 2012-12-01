$(document).ready(function(){	
	var area1="";
	var area2="";
	var newstitle="";
	var permalink="";
	var mininewsimage="";
        var estado=0;
        var cpermalink=$("#permalink").val();
        var pnewstitle=$("#newstitle").val();
        var tiempo="";
        var datefield=document.createElement("input")
            datefield.setAttribute("type", "date")    
            if (datefield.type!="date"){ //if browser doesn't support input type="date", initialize date picker widget:
                jQuery(function($){ //on document.ready
                    $('#fechaRegistro').datetimepicker({ dateFormat:'yy-mm-dd ', timeFormat: "HH:mm:ss", showSecond: true, showButtonPanel: true, changeMonth: true, changeYear: true, currentText: "Hoy", hourText: "Hora", minuteText: "minuto", timeText: "Tiempo", secondText: "Segundo",closeText: "Cerrar", dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],monthNamesShort: ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"] });
            })
            }else{
              jQuery(function($){ //on document.ready
                    $('#fechaRegistro').datetimepicker({ dateFormat:'yy-mm-dd ', timeFormat: "HH:mm:ss", showSecond: true, showButtonPanel: true, changeMonth: true, changeYear: true, currentText: "Hoy", hourText: "Hora", minuteText: "minuto", timeText: "Tiempo", secondText: "Segundo",closeText: "Cerrar", dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],monthNamesShort: ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"] });
            })   
            }
            
function Display_Load(){
	  $("#loading").fadeIn(900,0);
          $("#loading").html("<img src='bigLoader.gif' />");
                        }

function Hide_Load(){
		$("#loading").fadeOut('slow');
                    };          
           
$("#nnews").validate({
	rules:{
		area3:"required",
		area4:"required",
		newstitle:"required",
                fechaRegistro:"required"                           
	},
	messages:{
		area3: "Texto de Resumen Requerido",
		area4: "Texto de Contenido Requerido",
		newstitle: "Campo requerido",
                fechaRegistro: "Fecha requerida y Hora"
	},
		  submitHandler: function(form) {										   	
  		  $.ajax({
			type:"POST",
			dataType:"html",
			url: "modules/processnews.php",
			data:"&resumen="+area1+"&contenido="+area2+"&newstitle="+newstitle+"&url="+permalink+"&imageurl="+mininewsimage+"&estado="+estado+"&fecha="+tiempo+"&tarea=add-new",
			beforeSubmit: Display_Load(),
                        success:function(msg){
                                Hide_Load();
				alert(msg);
				window.setTimeout('window.location="index.php?page=noticias"',500)
								}
				});
									 }
									});
$("#enews").validate({
	rules:{
		area3:"required",
		area4:"required",
		newstitle:"required"
	},
	messages:{
		area3: "Texto de Resumen Requerido",
		area4: "Texto de Contenido Requerido",
		newstitle: "Campo requerido"
	},
		  submitHandler: function(form) {										   	
  		  $.ajax({
			type:"POST",
			dataType:"html",
			url: "modules/processnews.php",
			data:"&resumen="+area1+"&contenido="+area2+"&newstitle="+newstitle+"&url="+permalink+"&imageurl="+mininewsimage+"&estado="+estado+"&cpermalink="+cpermalink+"&fecha="+tiempo+"&tarea=edit-new",
			beforeSubmit: Display_Load(),
                        success:function(msg){
                                Hide_Load();
				alert(msg);
				window.setTimeout('window.location="index.php?page=noticias"',500)
								}
				});
									 }
									});                                                                       
	
$("#sentnews").click(function(){
	  newstitle=$("#newstitle").val();
	  permalink=$("#permalink").val();
          tiempo=$("#fechaRegistro").val();
          estado=$("#estado").val();
          estado=parseInt(estado);
	  mininewsimage=$("#mininewsimage").val();
          if(mininewsimage=""){
              mininewsimage=null;
          }
	  if (typeof nicEditors.findEditor("area1") != "undefined"){	
	  	  area1=myNicEditor1.instanceById('area1').getContent();
                  area1=area1.trim();		                
                 $("#area3").val(area1);
                 
	  if (nicEditors.findEditor("area1").getContent()=="<br>"){	                
                $("#area3").val("");
				/*nicEditors.findEditor("area1").setContent("");
                                myNicEditor1.instanceById('area1').setContent("");
                                myNicEditor1.instanceById('area1').saveContent("");*/
								  }
								    }	
	  
	  if (typeof nicEditors.findEditor("area2") != "undefined"){	            
              area2=myNicEditor2.instanceById('area2').getContent();             
              area2=area2.trim();
              $("#area4").val(area2); 
              /*area2=nicEditors.findEditor("area2").getContent();
              myNicEditor2.instanceById('area2').setContent(area2);
              myNicEditor2.instanceById('area2').saveContent(area2);*/
          if (nicEditors.findEditor("area2").getContent()=="<br>"){
		/*nicEditors.findEditor("area2").setContent("");
               myNicEditor2.instanceById('area2').setContent("");
               myNicEditor2.instanceById('area2').saveContent("");*/
                $("#area4").val(""); 
							          }
								    }
    
    /*    if (typeof nicEditors.findEditor("area1") != "undefined"){
        myNicEditor1.removeInstance('area1');	   
        }
	sleep(1000);
        
	if (typeof nicEditors.findEditor("area2") != "undefined"){
        myNicEditor2.removeInstance('area2');	    
        }*/
        			
		});
                
$("#updatenews").click(function(){
	  newstitle=$("#newstitle").val();
	  permalink=$("#permalink").val();
          estado=$("#estado").val();
          estado=parseInt(estado);
          tiempo=$("#fechaRegistro").val();
	  mininewsimage=$("#mininewsimage").val();
	  if (typeof nicEditors.findEditor("area1") != "undefined"){	
	  	  area1=myNicEditor1.instanceById('area1').getContent();
                  area1=area1.trim();		                
                 $("#area3").val(area1);
                 
	  if (nicEditors.findEditor("area1").getContent()=="<br>"){	                
                $("#area3").val("");				
								  }
								    }	
	  
	  if (typeof nicEditors.findEditor("area2") != "undefined"){	            
              area2=myNicEditor2.instanceById('area2').getContent();             
              area2=area2.trim();
              $("#area4").val(area2);         
          if (nicEditors.findEditor("area2").getContent()=="<br>"){	
              $("#area4").val(""); 
							          }                                                                 
								    }
                                                              
            });	
	
	/*$('#area1').focus(function(){
	  myNicEditor1.panelInstance('area1');	
	});
	
	$('#area2').focus(function(){
	  myNicEditor2.panelInstance('area2');		
	});*/
	
function sleep(milliSeconds){
var startTime = new Date().getTime(); // get the current time
while (new Date().getTime() < startTime + milliSeconds); // hog cpu
}	

$('#iremove').click(function(){
                    $("#permalink").val("");
                    });
	
$('#newstitle').focusout(function(){
		var pl = $('#permalink').val();
		pl = pl.trim();
		var newstitle = $(this).val();
		newstitle = newstitle.trim();
		if(newstitle!="" && pl=="" && newstitle!=pnewstitle){
			$.ajax({
				type:"POST",
				dataType:"html",
				url: "modules/processnews.php",
				data:"newstitle="+newstitle+"&tarea=permlink",
				success:function(msg){
                                if (msg == 1){
                                 alert("Titulo de la noticia ya existe");
                                }else{
				$('#permalink').val(msg.toString());
                                }
                                                    }
				
				});
                                                                    }
	
		});	
});


var myNicEditor1,myNicEditor2,myNicEditor3;

function window_onload(){
	myNicEditor1 = new nicEditor({fullPanel : false, iconsPath : 'editor/nicEditorIcons.gif'}).panelInstance('area1');
	myNicEditor2 = new nicEditor({fullPanel : false, iconsPath : 'editor/nicEditorIcons.gif'}).panelInstance('area2');
}


