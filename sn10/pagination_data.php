<?php
require('class/news.php');
if($_GET)
{
$pagina=$_GET['pagina'];
}
$per_page = 10;
$start = ($pagina-1)*$per_page;

$news = new News(null,null,null,null,null,null,null,null,null,null,null,null,null);
$noticias = $news->getNews($start, $per_page);




//get table contents

/*$sql = "SELECT t1.*, t2.user_nickname, t3.user_nickname as user_modificador 
                                FROM news t1 INNER JOIN users t2 ON t1.news_author = t2.ID 
                                INNER JOIN users t3 ON t1.news_usermodified = t3.ID ORDER BY t1.news_date DESC limit $start,$per_page";*/
/*$rsd = mysql_query($sql);*/
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
