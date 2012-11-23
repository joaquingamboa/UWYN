<?php
if (isset($_SESSION['user_id']) && $_SESSION['isAdmin'] == 1){
?>
<h2 style="text-align:center;">Agregar nuevo Usuario</h2>
<form action="modules/processuser.php" method="post" name="nuser" id="nuser">
<div class="centered">
    <table class="lst centrado">
        <tr>
            <td style="width:150px;text-align:right;"><label  for="username">username:</label></td>
            <td ><input style="width:291px;float:left;" type="input" name="username" id="username"/></td>
        </tr>
        <tr>
            <td style="width:150px;text-align:right;"><label for="nickname">nickname:</label></td>
            <td><input style="width:291px;float:left;" type="input" name="nickname" id="nickname"/></td>
        </tr>
        <tr>
            <td style="width:150px;text-align:right;"><label for="estado">estado:</label></td>
            <td>  
                <select style="width:297px;float:left;" id="estado" name="estado">
                <option value="1" selected="selected">Activo</option>
                <option value="0">Bloqueado</option>
                </select>
            </td>
        </tr> 
        <tr>
            <td style="width:150px;text-align:right;"><label for="Administrador">Administrador General:</label></td>
            <td>  
                <select style="width:297px;float:left;" id="Administrador" name="Administrador">
                <option value="1">SI</option>
                <option value="0" selected="selected">NO</option>
                </select>
            </td>
        </tr>
         <tr>
            <td style="width:150px;text-align:right;"><label for="password">password:</label></td>
            <td><input style="width:291px;float:left;" type="password" name="password" id="password"/></td>
        </tr>
        <tr>
            <td style="width:150px;text-align:right;">Tabla Noticias:</td>
            <td style="text-align:left;">
                <input type="checkbox" name="tnoticias[]" value="Select"> Ver<br/>
                <input type="checkbox" name="tnoticias[]" value="Insert"> Insertar<br/>
                <input type="checkbox" name="tnoticias[]" value="Update"> Actualizar<br/>
                <input type="checkbox" name="tnoticias[]" value="Delete"> Eliminar<br/>
            </td>
        </tr>
         <tr>
            <td style="width:150px;text-align:right;">Tabla Paginas:</td>
            <td style="text-align:left;">
                <input type="checkbox" name="tpaginas[]" value="Select"> Ver<br/>
                <input type="checkbox" name="tpaginas[]" value="Insert"> Insertar<br/>
                <input type="checkbox" name="tpaginas[]" value="Update"> Actualizar<br/>
                <input type="checkbox" name="tpaginas[]" value="Delete"> Eliminar<br/>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">
               <input type="submit" id="sentuser" />       
            </td>
        </tr>
    </table>
</div>  
</form>
<?php
}else{
    echo "ACCESO RESTRINGIDO";
}
?>