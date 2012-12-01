<?php
session_start();
if (isset($_SESSION['user_id'])){
if($_GET){
$pagina=$_GET['pagina'];
}
require_once('class/news.php');
$per_page = 10;
$start = ($pagina-1)*$per_page;

$news = new News(null,null,null,null,null,null,null,null,null,null,null,null,null);
$noticias = $news->obtenerNoticiasPropias($start, $per_page);
?>


<table class="lst" style="width:100%;">
    <tr>
    <th>T&iacute;tulo Noticia</th>
    <th>Autor</th>
    <th>Fecha</th>   
    <th>Usuario Modificador</th>
    <th>Fecha Modificaci&oacute;n</th> 
    <th>Estado</th>
    <th>Eliminar</th>
    <th>Editar</th>
    </tr>   
		
<?php
if(count($noticias)) {
     foreach($noticias as $news) {
?>
<tr>
<td> 
    <?php echo $news->getTitle();?>
</td>
<td> 
    <?php echo $news->getNA();?>
</td>   
<td> 
    <?php
     echo $news->getDate();
    ?>
</td>
<td> 
    <?php
    echo $news->getNuserMod();    
    ?>
</td>
<td>
    <?php
    echo $news->getModified();
    ?>
</td>
<?php $id = $news->getId();?>
<td>
<?php
 if($news->getStatus()==1){
        echo "Publicado";
    }elseif ($news->getStatus()==0){
        echo "No publicado";            
                }    
?>
</td>
<td> 
    <a href="modules/processnews.php?tarea=deleteNew&amp;id=<?php echo $id;?>&amp;from=index" onClick="if(confirm('Seguro de Eliminar noticia?'))return true;else return false;"><img src="img/page_delete.png" alt="Eliminar noticia" height="16" width="16" style="border:none;" /></a>
</td>
<td>
    <a href="index.php?page=edit-news&amp;id=<?php echo $id;?>&amp;from=index"><img src="img/page_edit.png" alt="Editar noticia" height="16" width="16" style="border:none;" /></a>
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
