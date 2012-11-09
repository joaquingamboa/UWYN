<?php
if (isset($_SESSION['user_id'])){
?>
<h2 style="text-align:center;">Agregar nueva noticia</h2>
<form action="modules/processnews.php" method="post" name="nnews" id="nnews">
<div class="centered">


<table class="lst">
<tr>
<td style="width:291px;"><label for="newstitle">T&iacute;tulo:</label></td>
<td colspan="2"><input style="float:left" id="newstitle" name="newstitle" type="text" class="required"/></td>
</tr>
<tr>
<td><label for="permalink">Link Permanente:<br /> http://localhost/modular/noticias/</label></td>
<td><input id="permalink" name="permalink" type="text" style="background-color:#E5E5E5;" readonly="readonly" /></td>
<td><button type="button" id="iremove" class="iremove"></button></td>
</tr>
<tr>
<td><label for="mininewsimage">Imagen miniatura noticia:</label></td>
<td><input id="mininewsimage" name="mininewsimage" type="text" style="background-color:#E5E5E5;" readonly="readonly" /></td>
<td><button type="button" id="ichange" onclick="selectFile2('listFiles.php','src');"></button></td>
</tr>
<tr>
<td><label for="estado">Estado:</label></td>
    <td colspan="2">
    <select style="float:left;" id="estado" name="estado">
        <option value="1" selected="selected">P&uacute;blico</option>
        <option value="0">No publicado</option>
    </select>
    </td> 
</tr>
<tr>
    <td><label for="fechaRegistro">Fecha/Hora:</label></td>
    <td colspan="2"><input style="float:left;width: 130px;" type="input" id="fechaRegistro" name="fechaRegistro" class="required" readonly="readonly"></td>
</tr>
</table>

<br style="clear:both;"/><h4>Resumen</h4>
<textarea id="area1" name="area1" class="required"></textarea>
<textarea id="area3" name="area3" class="required" style="visibility:hidden;" ></textarea>
<h4>Texto noticia</h4>
<textarea id="area2" name="area2" class="required"></textarea>
<textarea id="area4" name="area4" class="required" style="visibility:hidden;" ></textarea>
<br />
<input type="submit" id="sentnews" />
</div>
</form>
<?php
}
?>