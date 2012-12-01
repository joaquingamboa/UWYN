<?php
if (isset($_SESSION['user_id'])){
include('class/pages.php');
$per_page = 10; 
$pages = new Pages(null, null, null, null, null, null, null, null, null, null, null, null, null, null);
$paged = $pages->obtenerTodasParaPaginacion($per_page);   
?>
<div id="content">  
<h2>Paginas
<a class="add-new" href="index.php?page=add-page" alt="Agregar Pagina"><img src="img/page_add.png" alt="Agregar Pagina" height="16" width="16" style="border:none;" />Agregar Nueva</a>      
</h2>   
<div id="loading" ></div>
 
<div id="contenttPaginas" class="sizeEleven" ></div>
   
     <ul id="paginationPaginas">
				<?php
				//Show page links
				for($i=1; $i<=$paged; $i++){
					echo '<li class="sizeEleven" id="'.$i.'">'.$i.'</li>';
                                                            }
				?>
	</ul>	          
    
              
</div>     
<?php
}else{
    echo "ACCESO RESTRINGIDO";
}
?>