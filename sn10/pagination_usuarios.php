<?php
session_start();
if (isset($_SESSION['user_id'])){
require('class/users.php');

if($_GET){
$pagina=$_GET['pagina'];
}
$per_page = 10;
$start = ($pagina-1)*$per_page;

$users = new User(null, null, null, null, null, null, null, null, null);
$usuarios = $users->getUsers($start, $per_page);




//get table contents

/*$sql = "SELECT t1.*, t2.user_nickname, t3.user_nickname as user_modificador 
                                FROM news t1 INNER JOIN users t2 ON t1.news_author = t2.ID 
                                INNER JOIN users t3 ON t1.news_usermodified = t3.ID ORDER BY t1.news_date DESC limit $start,$per_page";*/
/*$rsd = mysql_query($sql);*/

?>


<table class="lst" style="width:100%;">
    <tr>
    <th>Nickname</th>
    <th>Fecha de registro</th> 
    <th>Es Administrador</th>  
    <th>Estado</th>
    <th>Eliminar</th>   
    <th>Editar</th>
    </tr>   
		
<?php
if(count($usuarios)) {
     foreach($usuarios as $users) {
?>
<tr>
<!--<td> 
    <?php // echo "http://localhost/modular/".$news->getUrl();?>
</td>-->
<td> 
    <?php echo $users->getNickname();?>
</td>   
<td> 
    <?php
     echo $users->getRegistertime();
    ?>
</td>
<td> 
    <?php
      if($users->getAdmin()==1){
        echo "SI";
    }elseif ($users->getAdmin()==0){
        echo "NO";            
                }   
    ?>
</td>
<td> 
    <?php 
    if($users->getStatus()==1){
        echo "Activo";
    }elseif ($users->getStatus()==0){
        echo "Bloqueado";            
                }             
    ?>
</td>
<td> 
    <a href="modules/processuser.php?tarea=deleteUser&amp;id=<?php echo $users->getId();?>&amp;username=<?php echo $users->getUsername();?>" onClick="if(confirm('Seguro de Eliminar Usuario?'))return true;else return false;"><img src="img/user_delete.png" alt="Eliminar Usuario" height="16" width="16" style="border:none;" /></a>
</td>
<td>
    <a href="index.php?page=edit-user&amp;id=<?php echo $users->getId();?>"><img src="img/user_edit.png" alt="Editar Usuario" height="16" width="16" style="border:none;" /></a>
</td>
</tr> 
<?php
                                }
                       } else {
                           echo "Ninguna Usuario ingresado."; 
                              }      
                                ?>

</table>
<?php
}
?>
