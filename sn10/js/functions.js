	$(document).ready(function(){	
	var area1="";
	var area2="";
	var newstitle="";
	var permalink="";
	var mininewsimage="";
        var estado=0;
$("#nnews").validate({
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
			data:"&resumen="+area1+"&contenido="+area2+"&newstitle="+newstitle+"&url="+permalink+"&imageurl="+mininewsimage+"&estado="+estado+"&tarea=ajax",
			success:function(msg){
				alert(msg);
				window.location.href="index.php?page=noticias";
								}
				});
									 }
									});
	
$("#sentnews").click(function(){
	  newstitle=$("#newstitle").val();
	  permalink=$("#permalink").val();
          estado=$("#estado").val();
          estado=parseInt(estado);
	  mininewsimage=$("#mininewsimage").val();
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
		if(newstitle!="" && pl==""){
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