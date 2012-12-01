<?php
if (isset($_SESSION['user_id'])){
require('class/pages.php');
$pages = new Pages(null, null, null, null, null, null, null, null, null, null, null, null, null, null);
$paginas = $pages->obtenerCategoriasPrincipales();
?>
<div class="centered">
<h2 style="text-align:center;">Agregar nueva pagina</h2>    
<form name="add-page" id="add-page" method="post" action="modules/processpages.php">
<div id="loading"></div>    
<table class="lst" style="width:900px;">
    <tr>
        <td style="width:150px;"><label for="page_title">T&iacute;tulo:</label></td>
        <td colspan="2"><input style="float:left" id="page_title" name="page_title" type="text" class="required"/></td>
    </tr>
   <tr>
        <td style="width:150px;"><label for="permalink">Link Permanente:<br /><?php echo $_SERVER['HTTP_HOST'];?>/paginas/</label></td>
        <td><input id="permalink" name="permalink" type="text" style="background-color:#E5E5E5;float:left;" readonly="readonly" /></td>
        <td><button type="button" style="float:right;" id="iremove" class="iremove"></button></td>
   </tr>
   <tr>
       <td><label for="categoria">Title HTML TAG</label></td>
       <td colspan="2">
         <select style="float:left;width:456px;" id="categoria" name="categoria">
          <option value="" selected="selected">Categoria Principal</option>
         <?php
         foreach($paginas as $pages){
         ?>
         <option value="<?php echo $pages->getPage_id();?>"><?php echo $pages->getPage_title();?></option> 
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
       <td colspan="2"><input style="float:left" id="html_title" name="html_title" type="text"/></td> 
   </tr>
   <tr>
       <td style="width:150px;"><label for="html_description">Description HTML TAG</label></td>
       <td colspan="2"><input style="float:left" id="html_description" name="html_description" type="text"/></td> 
   </tr> 
   <tr>
       <td style="width:150px;"><label for="html_keywords">Keywords HTML TAG</label></td>
       <td colspan="2"><input style="float:left" id="html_keywords" name="html_keywords" type="text"/></td> 
   </tr>    

</table><br/><br/><br/><br/><br/>
<div id="editor" class="required">
    
</div>
    <input type="submit" name="sentaddpage" value="Agregar Pagina" id="sentaddpage">
</form>
</div>
<?php
}else{
    echo "ACCESO RESTRINGIDO";
}
?>