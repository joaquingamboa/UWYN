<?php
if (isset($_SESSION['user_id'])){
?>
<h1 style="float:left;">UWYN CMS</h1>
<div id="header-info">
   Hola <?php echo $_SESSION['user_nickname'];?>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="modules/processlogin.php?tarea=logout" onClick="if(confirm('Seguro de cerrar sesion?'))return true;else return false;">Cerrar sesi&oacute;n</a>
</div>

<?php
}else{
    echo "ACCESO RESTRINGIDO";
}
?>