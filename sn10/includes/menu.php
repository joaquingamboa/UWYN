<?php
if(isset($_SESSION['user_id'])){   
?>  

    <a href="index.php">Inicio</a>&nbsp;&nbsp;|&nbsp;&nbsp;    
    <a href="index.php?page=noticias">Noticias</a>&nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="services.html">Usuarios</a>&nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="contactus.html">Contact Us</a>&nbsp;&nbsp;|&nbsp;&nbsp;

<?php
}else{
    echo "ACCESO RESTRINGIDO";
}
?>