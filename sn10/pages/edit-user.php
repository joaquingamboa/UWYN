<?php
if (isset($_SESSION['user_id'])){
require('class/users.php');
$id = $_GET['id'];
$usuario = new User($id, null, null, null, null, null, null, null, null);
$usuario->getInfoTEdit();
$tnoticias = $usuario->getTnoticias();
$tpaginas = $usuario->getTpaginas();
?>
<h2 style="text-align:center;">Editar Datos Usuario</h2>
<form action="modules/processuser.php" method="post" name="euser" id="euser">
<input type="hidden" name="IdUser" id="IdUser" value="<?php echo $_GET['id'];?>"/>
<div class="centered">
    <table class="lst centrado">
        <tr>
            <td style="width:150px;text-align:right;"><label  for="username">username:</label></td>
            <td ><input style="width:291px;float:left;" type="input" name="username" id="username" readonly="readonly" value="<?php echo $usuario->getUsername();?>"/></td>
        </tr>
        <tr>
            <td style="width:150px;text-align:right;"><label for="nickname">nickname:</label></td>
            <td><input style="width:291px;float:left;" type="input" name="nickname" id="nickname" readonly="readonly" value="<?php echo $usuario->getNickname();?>"/></td>
        </tr>
        <tr>
            <td style="width:150px;text-align:right;"><label for="estado">estado:</label></td>
            <td>  
                <select style="width:297px;float:left;" id="estado" name="estado">
                <option value="1"<?php if($usuario->getStatus()==1){ echo " selected=selected";}?>>Activo</option>
                <option value="0"<?php if($usuario->getStatus()==0){ echo " selected=selected";}?>>Bloqueado</option>
                </select>
            </td>
        </tr> 
        <tr>
            <td style="width:150px;text-align:right;"><label for="Administrador">Administrador General:</label></td>
            <td>  
                <select style="width:297px;float:left;" id="Administrador" name="Administrador">
                    <option value="1"<?php if($usuario->getAdmin()==1){ echo " selected=selected";}?>>SI</option>
                    <option value="0"<?php if($usuario->getAdmin()==0){ echo " selected=selected";}?>>NO</option>
                </select>
            </td>
        </tr>    
        <tr>
            <td style="width:150px;text-align:right;">Tabla Noticias:</td>
            <td style="text-align:left;">                
                <input type="checkbox" name="tnoticias[]" value="Select"<?php for($i=0;$i<count($tnoticias);$i++){ if($tnoticias[$i]=='Select') echo " checked=\"checked\"";}?>> Ver<br/>
                <input type="checkbox" name="tnoticias[]" value="Insert"<?php for($i=0;$i<count($tnoticias);$i++){ if($tnoticias[$i]=='Insert') echo " checked=\"checked\"";}?>> Insertar<br/>
                <input type="checkbox" name="tnoticias[]" value="Update"<?php for($i=0;$i<count($tnoticias);$i++){ if($tnoticias[$i]=='Update') echo " checked=\"checked\"";}?>> Actualizar<br/>
                <input type="checkbox" name="tnoticias[]" value="Delete"<?php for($i=0;$i<count($tnoticias);$i++){ if($tnoticias[$i]=='Delete') echo " checked=\"checked\"";}?>> Eliminar<br/>
            </td>
        </tr>
         <tr>
            <td style="width:150px;text-align:right;">Tabla Paginas:</td>
            <td style="text-align:left;">
                <input type="checkbox" name="tpaginas[]" value="Select"<?php for($i=0;$i<count($tpaginas);$i++){ if($tpaginas[$i]=='Select') echo " checked=\"checked\"";}?>> Ver<br/>
                <input type="checkbox" name="tpaginas[]" value="Insert"<?php for($i=0;$i<count($tpaginas);$i++){ if($tpaginas[$i]=='Insert') echo " checked=\"checked\"";}?>> Insertar<br/>
                <input type="checkbox" name="tpaginas[]" value="Update"<?php for($i=0;$i<count($tpaginas);$i++){ if($tpaginas[$i]=='Update') echo " checked=\"checked\"";}?>> Actualizar<br/>
                <input type="checkbox" name="tpaginas[]" value="Delete"<?php for($i=0;$i<count($tpaginas);$i++){ if($tpaginas[$i]=='Delete') echo " checked=\"checked\"";}?>> Eliminar<br/>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">
               <input type="submit" id="edituser" value="Actualizar"/>       
            </td>
        </tr>
    </table>
</div>  
</form>
<?php
}
?>