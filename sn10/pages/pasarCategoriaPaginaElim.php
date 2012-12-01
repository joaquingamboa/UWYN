<?php
if (isset($_SESSION['user_id'])){
require('class/pages.php');
$pages = new Pages(null, null, null, null, null, null, null, null, null, null, null, null, null, null);
$paginas = $pages->obtenerCategoriasParaPasar($_GET['IdAElim']);
?>
La Pagina/Categoria principal <span style="font-weight:bold;">"<?php echo $_GET['page_title'];?>"</span> tiene subpaginas asociadas a ella.<br />

Porfavor Seleccione a que Pagina/Categoria principal le traspasara las subpaginas;

<form action="modules/processpages.php" method="POST">
<input type="hidden" name="IdAElim" value="<?php echo $_GET['IdAElim'];?>"/>
<input type="hidden" name="page_title" value="<?php echo $_GET['page_title'];?>"/>
<input type="hidden" name="tarea" value="finalDelete"/>
<br />
<table class="lst">
    <tr>
    <td><label for="IdTPass">Pasar a la Pagina/Categoria:</label></td>
   
<td><select id="IdTPass" name="IdTPass">
 <?php  if(count($paginas)) {
      foreach($paginas as $pages) {          
 ?>
        <option value="<?php echo $pages->getPage_id();?>"><?php echo $pages->getPage_title();?></option>   
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