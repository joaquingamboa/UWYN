<?php
if (!isset($_GET['page'])) {
    include("pages/index.php");
} else {
    include("pages/".$_GET['page'].".php");
}
?>