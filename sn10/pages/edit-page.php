<?php
if (isset($_SESSION['user_id'])){
require('class/pages.php');
$id = $_GET['id'];
$pages = new Pages($id, null, null, null, null, null, null, null, null, null, null, null, null, null);
$paginas = $pages->obtenerInformacionParaEditar();
$categoria = new Pages(null, null, null, null, null, null, null, null, null, null, null, null, null, null);
$categorias = $categoria->obtenerCategoriasParaPasar($id);

        if(count($paginas)){
            foreach($paginas as $pages){
?>
<div class="centered">
<h2 style="text-align:center;">Editar Pagina</h2>    
<form name="edit-page" id="edit-page" method="post" action="modules/processpages.php">
<input type="hidden" id="idtedit" name="idtedit" value="<?php echo $id;?>"/>
<div id="loading"></div>
<table class="lst" style="width:900px;">
    <tr>
        <td style="width:150px;"><label for="page_title">T&iacute;tulo:</label></td>
        <td colspan="2"><input style="float:left" id="page_title" name="page_title" type="text" class="required" value="<?php echo $pages->getPage_title();?>"/></td>
    </tr>
   <tr>
        <td style="width:150px;"><label for="permalink">Link Permanente:<br /><?php echo $_SERVER['HTTP_HOST'];?>/paginas/</label></td>
        <td><input id="permalink" name="permalink" type="text" style="background-color:#E5E5E5;float:left;" readonly="readonly" value="<?php echo $pages->getPage_url();?>" /></td>
        <td><button type="button" style="float:right;" id="iremove" class="iremove"></button></td>
   </tr>
   <tr>
       <td><label for="categoria">Title HTML TAG</label></td>
       <td colspan="2">
         <select style="float:left;width:456px;" id="categoria" name="categoria">
             <option value="" <?php if($pages->getPage_category()==null){ echo "selected=\"selected\"";}?>>Categoria Principal</option>
         <?php
         foreach($categorias as $categoria){
         ?>
         <option value="<?php echo $categoria->getPage_id();?>"<?php if ($categoria->getPage_id()==$pages->getPage_category()){ echo "selected=\"selected\"";}?>><?php echo $categoria->getPage_title();?></option> 
         <?php
          }
          ?>
         </select>
       </td>
   </tr>
   <tr>
       <td colspan="3" style="text-align:center;">Avanzado(SEO)</td> 
   </tr>
   <tr>
       <td style="width:150px;"><label for="html_title">Title HTML TAG</label></td>
       <td colspan="2"><input style="float:left" id="html_title" name="html_title" type="text" value="<?php echo $pages->getHtml_title();?>"/></td> 
   </tr>
   <tr>
       <td style="width:150px;"><label for="html_description">Description HTML TAG</label></td>
       <td colspan="2"><input style="float:left" id="html_description" name="html_description" type="text" value="<?php echo $pages->getHtml_description();?>"/></td> 
   </tr> 
   <tr>
       <td style="width:150px;"><label for="html_keywords">Keywords HTML TAG</label></td>
       <td colspan="2"><input style="float:left" id="html_keywords" name="html_keywords" type="text" value="<?php echo $pages->getHtml_keywords();?>"/></td> 
   </tr>    
</table><br/><br/><br/><br/><br/>
<?php 
$content = $pages->getHtml_content();
echo "<script>$(document).ready(function(){ $('#editor').elrte('val', '$content'); });</script>";
?>
<div id="editor" class="required">   
</div>
    <input type="submit" name="senteditpage" value="Editar Pagina" id="senteditpage">
</form>
</div>
<?php
            }
        }
}else{
    echo "ACCESO RESTRINGIDO";
}
?>