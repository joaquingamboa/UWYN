<?php
if (!isset($_GET['page'])) {
    include("pages/inicio.php");
}else{
    include("pages/".$_GET['page'].".php");
}

?>