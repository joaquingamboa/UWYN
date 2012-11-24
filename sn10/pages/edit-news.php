<?php
if(isset($_SESSION['user_id'])){
$id = $_GET['id'];
require('class/news.php');
$news = new News($id,null,null,null,null,null,null,null,null,null,null,null,null);
$noticias = $news->getNewsById();
/*echo $_SERVER['REQUEST_URI'];*/
if(count($noticias)) {
    foreach($noticias as $news) {
?>
<h2 style="text-align:center;">Editar Noticia</h2>
<form action="modules/processnews.php" method="post" name="enews" id="enews">
<div class="centered">
<table class="lst">
<tr>
<td style="width:291px;"><label for="newstitle">T&iacute;tulo:</label></td>
<td><input style="float:left;" id="newstitle" name="newstitle" type="text" class="required" value="<?php echo $news->getTitle();?>" /></td>
</tr>
<tr>
<td><label for="permalink">Link Permanente:<br /> http://localhost/modular/noticias/</label></td>
<td><input id="permalink" name="permalink" type="text" style="background-color:#E5E5E5;float:left;" readonly="readonly" value="<?php echo $news->getUrl();?>" /></td>
<td><button type="button" id="iremove" class="iremove"></button></td>
</tr><?php $url = $news->getUrl();?>
<tr>
<td><label for="mininewsimage">Imagen miniatura noticia:</label></td>
<td><input id="mininewsimage" name="mininewsimage" type="text" style="background-color:#E5E5E5;float:left;" readonly="readonly" value="<?php echo $news->getImg();?>" /></td>
<td><button type="button" id="ichange" onclick="selectFile2('listFiles.php','src');"></button></td>
</tr>
<tr>
<td><label for="estado">Estado:</label></td>
    <td>
    <select style="float:left;" id="estado" name="estado">
        <?php $status = $news->getStatus(); ?>
        <option value="1" <?php if($status==1){ echo "selected";}?>>P&uacute;blico</option>
        <option value="0" <?php if($status==0){ echo "selected";}?>>No publicado</option>
    </select>
    </td> 
</tr>
<tr>
    <td><label for="fechaRegistro">Fecha/Hora:</label></td>
    <td colspan="2"><input style="float:left;width: 130px;" type="input" id="fechaRegistro" name="FechaRegistro" class="required" readonly="readonly" value="<?php echo $news->getDate(); ?>" /></td>
</tr>
</table>

<br style="clear:both;"/><h4>Resumen</h4>
<textarea id="area1" name="area1" class="required"></textarea>
<textarea id="area3" name="area3" class="required" style="visibility:hidden;" ></textarea>
<?php 
$description = $news->getDescription();
$comando = "<script type=\"text/javascript\">myNicEditor1 = new nicEditor({fullPanel : false, iconsPath : 'editor/nicEditorIcons.gif'}).panelInstance('area1');nicEditors.findEditor('area1').setContent('$description');</script>";
echo ($comando); 
?>

<h4>Texto noticia</h4>
<textarea id="area2" name="area2" class="required"></textarea>
<textarea id="area4" name="area4" class="required" style="visibility:hidden;" ></textarea>
<?php 
$content = $news->getContent();
$comando = "<script type=\"text/javascript\">myNicEditor2 = new nicEditor({fullPanel : false, iconsPath : 'editor/nicEditorIcons.gif'}).panelInstance('area2');nicEditors.findEditor('area2').setContent('$content');</script>";
echo ($comando); 
?>
<br />
<input type="submit" id="updatenews" />
</div>
</form>
<?php 
                      }
                       }                         
                         } 
?>

