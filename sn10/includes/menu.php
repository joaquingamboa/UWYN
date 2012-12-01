<?php
if(isset($_SESSION['user_id'])){   
?>  
    <a href="index.php?page=inicio">Inicio</a>&nbsp;&nbsp;|&nbsp;&nbsp;    
    <a href="index.php?page=noticias">Noticias</a>&nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="index.php?page=files-management">Administrador de Archivos - Galer&iacute;a</a>&nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="index.php?page=paginas">Paginas</a>&nbsp;&nbsp;|&nbsp;&nbsp; 
    <a href="index.php?page=usuarios">Usuarios</a>&nbsp;&nbsp;|&nbsp;&nbsp;
   
    

<?php
}else{
    echo "ACCESO RESTRINGIDO";
}

?>