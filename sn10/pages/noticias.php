<?php
include('config.php');
$per_page = 10; 

//getting number of rows and calculating no of pages
$sql = "SELECT * FROM NEWS";
$rsd = mysql_query($sql);
$count = mysql_num_rows($rsd);
$paged = ceil($count/$per_page)
?>
<div id="content">   				
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
            
       