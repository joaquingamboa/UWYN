<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mi pagina modular Parte 2</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="tables.css" rel="stylesheet" type="text/css" />	
<?php if ($_SERVER['REQUEST_URI']=="/modular/sn10/index.php?page=add-news" || substr($_SERVER['REQUEST_URI'],0,38)=="/modular/sn10/index.php?page=edit-news"){
echo "
<script type=\"text/javascript\" src=\"js/jquery-1.8.2.min.js\"></script>  
<script type=\"text/javascript\" src=\"js/jquery-ui-1.9.1.custom/js/jquery-ui-1.9.1.custom.min.js\"></script>
<link href=\"css/smoothness/jquery-ui-1.9.1.custom.min.css\" rel=\"stylesheet\" type=\"text/css\" />
<script type=\"text/javascript\" src=\"js/jquery-ui-timepicker-addon.js\"></script>
<script type=\"text/javascript\" src=\"editor/nicEdit.js\"></script>
<script type=\"text/javascript\" src=\"js/functions.js\"></script>
<script type=\"text/javascript\" src=\"js/jquery.validate.js\"></script>";}?>

<?php if ($_SERVER['REQUEST_URI']=="/modular/sn10/index.php?page=noticias" || $_SERVER['REQUEST_URI']=="/modular/sn10/index.php?page=usuarios"){
echo "<script type=\"text/javascript\" src=\"js/jquery-1.8.2.min.js\"></script>
<script type=\"text/javascript\" src=\"js/pagination.js\"></script>";

}?> 

<?php if ($_SERVER['REQUEST_URI']=="/modular/sn10/index.php?page=files-management") {
echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css\">
<script type=\"text/javascript\" src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js\"></script>
<script type=\"text/javascript\" src=\"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js\"></script> 
<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"css/elfinder.min.css\">
 <link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"css/theme.css\">
<script type=\"text/javascript\" src=\"js/elfinder.min.js\"></script>
<script type=\"text/javascript\" src=\"js/i18n/elfinder.es.js\"></script>
<script type=\"text/javascript\" charset=\"utf-8\">
$().ready(function(){
        var elf = $('#elfinder').elfinder({
        url : 'class/connector.php', // connector URL (REQUIRED)
        lang: 'es'             // language (OPTIONAL)
                                }).elfinder('instance');
			});
</script>";
}
?>
<style type="text/css">
label.error { 
			float: none; color: red; padding-left: .5em;
			}

/* .submit { margin-left: 12em; }*/

</style>
</head>

<body<?php if($_SERVER['REQUEST_URI']=="/modular/sn10/index.php?page=add-news") echo " onLoad=\"window_onload()\"";?>>