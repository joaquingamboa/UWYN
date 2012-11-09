<?php
include('config.php');
include('class/news.php');
$per_page = 10; 
$news = new News(null, null, null, null, null, null, null, null, null, null, null, null, null);
$paged = $news->getAllNewsPagination($per_page);
?>

<div id="content">  
<h2>Noticias
<a class="add-new" href="index.php?page=add-news" alt="Agregar Noticia"><img src="img/page_add.png" alt="Agregar Noticia" height="16" width="16" style="border:none;" />Agregar Nueva</a>      
</h2>    
<div id="loading" ></div>
 
<div id="contentt" ></div>
   
     <ul id="pagination">
				<?php
				//Show page links
				for($i=1; $i<=$paged; $i++)
				{
					echo '<li id="'.$i.'">'.$i.'</li>';
				}
				?>
	</ul>	       
            
</div>              
            
       