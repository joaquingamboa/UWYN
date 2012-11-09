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
   
	$("#pagination li:first").css({'color' : 'black'}).css({'border' : 'none'});
	
	Display_Load();
	
	$("#contentt").load("pagination_data.php?pagina=1", Hide_Load());



	//Pagination Click
	$("#pagination li").click(function(){
			
		Display_Load();
		
		//CSS Styles
		$("#pagination li")
		.css({'border' : 'solid #dddddd 1px'})
		.css({'color' : 'black'});
		
		$(this)
		.css({'color' : 'blue'})
		.css({'border' : 'none'});

		//Loading Data
		var pageNum = this.id;
		
		$("#contentt").load("pagination_data.php?pagina=" + pageNum, Hide_Load());
	});
});