<?php
if (isset($_SESSION['user_id'])){
require('class/news.php');
$news = new News(null,null,null,null,null,null,null,null,null,null,null,null,null);
$noticias = $news->getNews();
?>
<div id="column">
<div id="list_table"> 
<h2>Noticias
<a class="add-new" href="index.php?page=add-news" alt="Agregar Noticia"><img src="img/page_add.png" alt="Agregar Noticia" height="16" width="16" style="border:none;" />Agregar Nueva</a>      
</h2>
<table style="width:100%;">
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
<!--<td> 
    <?php // echo "http://localhost/modular/".$news->getUrl();?>
</td>-->
<td> 
    <?php echo $news->getNA();?>
</td>   
<td> 
    <?php
     echo $news->getDatef();
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
    <a href="modules/processnews.php?tarea=deleteNew&amp;id=<?php echo $id;?>" onClick="if(confirm('Seguro de Eliminar noticia?'))return true;else return false;"><img src="img/page_delete.png" alt="Eliminar noticia" height="16" width="16" style="border:none;" /></a>
</td>
<td>
    <a href="index.php?page=edit-news&amp;id=<?php echo $id;?>"><img src="img/page_edit.png" alt="Editar noticia" height="16" width="16" style="border:none;" /></a>
</td>
</tr> 
<?php
                                }
                       } else {
                           echo "Ninguna noticia ingresada.";
                           
                           }      
                                ?>

</table>
        </div>
     
</div>
<?php
}
?>