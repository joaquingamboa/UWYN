<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mi pagina modular Parte 2</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="tables.css" rel="stylesheet" type="text/css" />	
<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.1.custom/js/jquery-ui-1.9.1.custom.min.js"></script>
<link href="css/smoothness/jquery-ui-1.9.1.custom.min.css" rel="stylesheet" type="text/css" />	
<?php if ($_SERVER['REQUEST_URI']=="/modular/sn10/index.php?page=add-news" || substr($_SERVER['REQUEST_URI'],0,38)=="/modular/sn10/index.php?page=edit-news") echo "<script type=\"text/javascript\" src=\"js/jquery-ui-timepicker-addon.js\"></script>\n";?>
<?php if ($_SERVER['REQUEST_URI']=="/modular/sn10/index.php?page=add-news" || substr($_SERVER['REQUEST_URI'],0,38)=="/modular/sn10/index.php?page=edit-news") echo "<script type=\"text/javascript\" src=\"editor/nicEdit.js\"></script>\n";?>
<?php if ($_SERVER['REQUEST_URI']=="/modular/sn10/index.php?page=add-news" || substr($_SERVER['REQUEST_URI'],0,38)=="/modular/sn10/index.php?page=edit-news") echo "<script type=\"text/javascript\" src=\"js/functions.js\"></script>\n";?>
<?php if ($_SERVER['REQUEST_URI']=="/modular/sn10/index.php?page=add-news" || substr($_SERVER['REQUEST_URI'],0,38)=="/modular/sn10/index.php?page=edit-news") echo "<script type=\"text/javascript\" src=\"js/jquery.validate.js\"></script>\n";?>
<?php if ($_SERVER['REQUEST_URI']=="/modular/sn10/index.php?page=noticias") echo "<script type=\"text/javascript\" src=\"js/pagination.js\"></script>";?>
<style type="text/css">
label.error { float: none; color: red; padding-left: .5em;}
/*.submit { margin-left: 12em; }*/
</style>
</head>
<body<?php if ($_SERVER['REQUEST_URI']=="/modular/sn10/index.php?page=add-news") echo " onLoad=\"window_onload()\"";?>>