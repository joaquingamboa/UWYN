$(document).ready(function(){	
    //Display Loading Image
	function Display_Load()
	{
	    $("#loading").fadeIn(900,0);
		$("#loading").html("<img src='bigLoader.gif' />");
	}
	//Hide Loading Image
	function Hide_Load()
	{
		$("#loading").fadeOut('slow');
	};
	

   //Default Starting Page Results
   
	$("#paginationNoticias li:first").css({'color' : 'black'}).css({'border' : 'none'});
	
	Display_Load();
	
	$("#contenttNoticias").load("pagination_noticias.php?pagina=1", Hide_Load());



	//Pagination Click
	$("#paginationNoticias li").click(function(){
			
		Display_Load();
		
		//CSS Styles
		$("#paginationNoticias li")
		.css({'border' : 'solid #dddddd 1px'})
		.css({'color' : 'black'});
		
		$(this)
		.css({'color' : 'blue'})
		.css({'border' : 'none'});

		//Loading Data
		var pageNum = this.id;
                
		
	$("#contenttNoticias").load("pagination_Noticias.php?pagina=" + pageNum, Hide_Load());
													});
                 
        
          
	$("#paginationUsuarios li:first").css({'color' : 'black'}).css({'border' : 'none'});
	
	Display_Load();
	
	$("#contenttUsuarios").load("pagination_Usuarios.php?pagina=1", Hide_Load());



	//Pagination Click
	$("#paginationUsuarios li").click(function(){
			
		Display_Load();
		
		//CSS Styles
		$("#paginationNoticias li")
		.css({'border' : 'solid #dddddd 1px'})
		.css({'color' : 'black'});
		
		$(this)
		.css({'color' : 'blue'})
		.css({'border' : 'none'});

		//Loading Data
		var pageNum = this.id;
		
		$("#contenttUsuarios").load("pagination_usuarios.php?pagina=" + pageNum, Hide_Load());
	});
});