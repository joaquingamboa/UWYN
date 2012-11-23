<?php
if (isset($_SESSION['user_id']) && $_SESSION['isAdmin'] == 1){
require('class/users.php');
$users = new User(null, null, null, null, null, null, null, null, null);
$usuarios = $users->getUsersTPass($_GET['IdAElim']);
?>
El usuario <?php echo $_GET['username'];?> tiene noticias y/o paginas asociadas a él.<br />

Porfavor Seleccione a que usuario le traspasara las noticias/paginas;

<form action="modules/processuser.php" method="POST">
<input type="hidden" name="IdAElim" value="<?php echo $_GET['IdAElim'];?>"/>
<input type="hidden" name="username" value="<?php echo $_GET['username'];?>"/>
<input type="hidden" name="tarea" value="finalDelete"/>
<br />
<table class="lst">
    <tr>
    <td><label for="IdTPass">Pasar al Usuario:</label></td>
   
<td><select id="IdTPass" name="IdTPass">
 <?php  if(count($usuarios)) {
      foreach($usuarios as $users) {          
 ?>
    <option value="<?php echo $users->getId();?>"><?php echo $users->getNickname();?></option>   
 <?php  
                                    }       
 }else{
     echo "HA OCURRIDO UN ERROR";
 }
 ?>  
</select>
</td>
</tr>
</table>
<input type="submit" value="OK"/>        
</form>
<?php
}else{
    echo "ACCESO RESTRINGIDO";
}
?>