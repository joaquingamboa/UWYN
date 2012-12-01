<?php
session_start();
if (isset($_SESSION['user_id'])){
require('class/pages.php');

if($_GET){
$pagina=$_GET['pagina'];
}
$per_page = 10;
$start = ($pagina-1)*$per_page;

$pages = new Pages(null, null, null, null, null, null, null, null, null, null, null, null, null, null);
$paginas = $pages->obtenerPaginasPropias($start, $per_page);

?>


<table class="lst" style="width:100%;">
    <tr>
    <th>Titulo</th>
    <th>Autor</th> 
    <th>Fecha</th>  
    <th>Usuario Modificador</th>
    <th>Fecha Modificación</th>  
    <th>Eliminar</th>
    <th>Editar</th>
    </tr>   
		
<?php
if(count($paginas)) {
     foreach($paginas as $pages) {
?>
<tr>
<td> 
    <?php echo $pages->getPage_title();?>
</td>   
<td> 
    <?php echo $pages->getNombre_author();?>
</td>
<td> 
    <?php echo $pages->getPage_date();?>
</td>
<td> 
    <?php echo $pages->getNombre_modificador();?>
</td>
<td>
   <?php echo $pages->getPage_modified();?> 
</td>
<td> 
    <a href="modules/processpages.php?tarea=deletePage&amp;id=<?php echo $pages->getPage_id();?>&amp;page_title=<?php echo $pages->getPage_title();?>&amp;from=index" onClick="if(confirm('Seguro de Eliminar Pagina?'))return true;else return false;"><img src="img/page_delete.png" alt="Eliminar Pagina" height="16" width="16" style="border:none;" /></a>
</td>
<td>
    <a href="index.php?page=edit-page&amp;id=<?php echo $pages->getPage_id();?>&amp;from=index"><img src="img/page_edit.png" alt="Editar Pagina" height="16" width="16" style="border:none;" /></a>
</td>
</tr> 
<?php
                                }
                       }     
                                ?>

</table>
<?php
}
?>
