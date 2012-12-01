<?php
if (isset($_SESSION['user_id']) && $_SESSION['isAdmin'] == 1){
include('class/users.php');
$per_page = 10; 
$users = new User(null, null, null, null, null, null, null, null, null);
$paged = $users->getAllUsersPagination($per_page);
?>

<div id="content">
<h2>Usuarios
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
<?php
}else{
    echo "ACCESO RESTRINGIDO";
}
?>