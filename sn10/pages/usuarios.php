<?php
include('class/users.php');
$per_page = 10; 
$users = new User(null, null, null, null, null, null, null, null, null);
$paged = $users->getAllUsersPagination($per_page);
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div id="content">
<h2 style="font-size-adjust: 0.5;">Usuarios
<a class="add-user" href="index.php?page=add-user" alt="Agregar Usuario"><img src="img/user_add.png" alt="Agregar Usuario" height="16" width="16" style="border:none;" />Agregar Nuevo</a>      
</h2>    
<div id="loading" ></div>
 
<div id="contenttUsuarios" class="sizeEleven" ></div>
   
     <ul id="paginationUsuarios">
				<?php
				//Show page links
				for($i=1; $i<=$paged; $i++){
					echo '<li class="sizeEleven" id="'.$i.'">'.$i.'</li>';
                                                            }
				?>
	</ul>	          
    
    
</div>