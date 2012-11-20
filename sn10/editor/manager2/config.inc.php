<?php
// for absolute path http://www.mysite.com/userfiles/ or for relative path userfiles/ 
$UPATH = "http://".$_SERVER['HTTP_HOST'];
define("_path", "$UPATH/sn10/mydocuments/"); 
define("_folder", "mydocuments/"); // For example userfiles/
?>