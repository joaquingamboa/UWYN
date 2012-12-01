$(document).ready(function(){	
    //Display Loading Image
	function Display_Load(){
                $("#loading").fadeIn(900,0);
		$("#loading").html("<img src='bigLoader.gif' />");
	}
	//Hide Loading Image
	function Hide_Load(){
		$("#loading").fadeOut('slow');
	}
        
        function Display_Load2(){
                $("#loading1").fadeIn(900,0);
		$("#loading1").html("<img src='bigLoader.gif' />");
	}
	//Hide Loading Image
	function Hide_Load2(){
		$("#loading1").fadeOut('slow');
	}
	

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
                
		
	$("#contenttNoticias").load("pagination_noticias.php?pagina=" + pageNum, Hide_Load());
													});
                 
                 /*****************************************************************/                                                                                                        
          
	$("#paginationUsuarios li:first").css({'color' : 'black'}).css({'border' : 'none'});
	
	Display_Load();
	
	$("#contenttUsuarios").load("pagination_Usuarios.php?pagina=1", Hide_Load());



	//Pagination Click
	$("#paginationUsuarios li").click(function(){
			
		Display_Load();
		
		//CSS Styles
		$("#paginationUsuarios li")
		.css({'border' : 'solid #dddddd 1px'})
		.css({'color' : 'black'});
		
		$(this)
		.css({'color' : 'blue'})
		.css({'border' : 'none'});

		//Loading Data
		var pageNum = this.id;
		
		$("#contenttUsuarios").load("pagination_usuarios.php?pagina=" + pageNum, Hide_Load());
	});
        
               /*****************************************************************/   
        
       $("#paginationPaginas li:first").css({'color' : 'black'}).css({'border' : 'none'});
	
	Display_Load();
	
	$("#contenttPaginas").load("pagination_pages.php?pagina=1", Hide_Load());



	//Pagination Click
	$("#paginationPaginas li").click(function(){
			
		Display_Load();
		
		//CSS Styles
		$("#paginationPaginas li")
		.css({'border' : 'solid #dddddd 1px'})
		.css({'color' : 'black'});
		
		$(this)
		.css({'color' : 'blue'})
		.css({'border' : 'none'});

		//Loading Data
		var pageNum = this.id;
		
		$("#contenttPaginas").load("pagination_pages.php?pagina=" + pageNum, Hide_Load());
        });
              /*****************************************************************/   
                      
       $("#PNoticiasPropias li:first").css({'color' : 'black'}).css({'border' : 'none'});
	
	Display_Load();
	
	$("#contenttNoticiasPropias").load("pagination_noticias_propias.php?pagina=1", Hide_Load());



	//Pagination Click
	$("#PNoticiasPropias li").click(function(){
			
		Display_Load();
		
		//CSS Styles
		$("#PNoticiasPropias li")
		.css({'border' : 'solid #dddddd 1px'})
		.css({'color' : 'black'});
		
		$(this)
		.css({'color' : 'blue'})
		.css({'border' : 'none'});

		//Loading Data
		var pageNum = this.id;
		
	$("#contenttNoticiasPropias").load("pagination_noticias_propias.php?pagina=" + pageNum, Hide_Load());
        });
              /*****************************************************************/         
        $("#paginationPaginasPropias li:first").css({'color' : 'black'}).css({'border' : 'none'});
	
	Display_Load2();
	
	$("#contenttPaginasPropias").load("pagination_pages_propias.php?pagina=1", Hide_Load2());



	//Pagination Click
	$("#paginationPaginasPropias li").click(function(){
			
		Display_Load2();
		
		//CSS Styles
		$("#paginationPaginasPropias li")
		.css({'border' : 'solid #dddddd 1px'})
		.css({'color' : 'black'});
		
		$(this)
		.css({'color' : 'blue'})
		.css({'border' : 'none'});

		//Loading Data
		var pageNum = this.id;
		
		$("#contenttPaginasPropias").load("pagination_pages_propias.php?pagina=" + pageNum, Hide_Load2());
        });              
   
              /*****************************************************************/         
                     
              
});