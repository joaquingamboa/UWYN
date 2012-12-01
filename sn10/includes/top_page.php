<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mi pagina modular Parte 2</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="tables.css" rel="stylesheet" type="text/css" />	
<?php //if ($_SERVER['REQUEST_URI']=="/sn10/index.php?page=add-news" || substr($_SERVER['REQUEST_URI'],0,30)=="/sn10/index.php?page=edit-news"){
if ( strpos($_SERVER['REQUEST_URI'], 'index.php?page=add-news') != false || strpos($_SERVER['REQUEST_URI'], 'index.php?page=edit-news') != false ){
echo "<script type=\"text/javascript\" src=\"js/jquery-1.8.2.min.js\"></script>  
<script type=\"text/javascript\" src=\"js/jquery-ui-1.9.1.custom.min.js\"></script>
<link href=\"css/jquery-ui-1.9.1.custom.min.css\" rel=\"stylesheet\" type=\"text/css\" />
<script type=\"text/javascript\" src=\"js/jquery-ui-timepicker-addon.js\"></script>
<script type=\"text/javascript\" src=\"editor/nicEdit.js\"></script>
<script type=\"text/javascript\" src=\"js/functions.js\"></script>
<script type=\"text/javascript\" src=\"js/jquery.validate.js\"></script>";}?>
<?php if (strpos($_SERVER['REQUEST_URI'], 'index.php?page=add-page') != false || strpos($_SERVER['REQUEST_URI'], 'index.php?page=edit-page') != false){
echo "<link rel=\"stylesheet\" href=\"css/jquery-ui-1.8.13.custom.css\" type=\"text/css\" media=\"screen\" charset=\"utf-8\">
<link rel=\"stylesheet\" href=\"css/elrte.min.css\" type=\"text/css\" media=\"screen\" charset=\"utf-8\">
<script src=\"js/jquery-1.7.2.min.js\" type=\"text/javascript\" charset=\"utf-8\"></script>
<script src=\"js/jquery-ui-1.8.13.custom.min.js\" type=\"text/javascript\" charset=\"utf-8\"></script>
<script src=\"js/elrte.min.js\" type=\"text/javascript\" charset=\"utf-8\"></script>
<script src=\"js/i18n/elrte.es.js\" type=\"text/javascript\" charset=\"utf-8\"></script>
<script type=\"text/javascript\" src=\"js/jquery-ui-timepicker-addon.js\"></script>
<script type=\"text/javascript\" src=\"js/validatePagesManagement.js\"></script>
<link rel=\"stylesheet\" href=\"css/elfinder.min.css\" type=\"text/css\" media=\"screen\" charset=\"utf-8\">
<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"css/theme.css\">
<script type=\"text/javascript\" src=\"js/elfinder.min.js\"></script>
<script type=\"text/javascript\" src=\"js/i18n/elfinder.es.js\"></script>

<script type=\"text/javascript\" charset=\"utf-8\">

$().ready(function() {
			var opts = {
                                cssClass : 'el-rte',
                                lang     : 'es',
                                width    : 900,
				height   : 450,
				toolbar  : 'maxi',
				cssfiles : ['css/elrte-inner.css'],
				fmOpen : function(callback) {
				  $('<div/>').dialogelfinder({
					url : 'class/connector.php', // connector URL (REQUIRED)
				        lang: 'es', // elFinder language (OPTIONAL)
					commandsOptions: {
                                         title: 'Documentos',
					  getfile: {
						oncomplete: 'destroy' // destroy elFinder after file selection
					  }
					},
					getFileCallback: function(file) { callback(file.url); }
				  });
								}
			}						
$('#editor').elrte(opts);	   

		});
</script>
<script type=\"text/javascript\" src=\"js/jquery.validate.js\"></script>";
}?>
<?php if (strpos($_SERVER['REQUEST_URI'], 'index.php?page=noticias') != false || strpos($_SERVER['REQUEST_URI'], 'index.php?page=usuarios') != false || strpos($_SERVER['REQUEST_URI'], 'index.php?page=paginas') != false){
echo "<script type=\"text/javascript\" src=\"js/jquery-1.8.2.min.js\"></script>
<script type=\"text/javascript\" src=\"js/pagination.js\"></script>";
}?> 
<?php if (strpos($_SERVER['REQUEST_URI'], 'index.php?page=add-user') != false || strpos($_SERVER['REQUEST_URI'], 'index.php?page=edit-user') != false){
echo "<script type=\"text/javascript\" src=\"js/jquery-1.8.2.min.js\"></script>
<script type=\"text/javascript\" src=\"js/validateUserManagement.js\"></script>
<script type=\"text/javascript\" src=\"js/jquery.validate.js\"></script>";
}?>     
<?php if (strpos($_SERVER['REQUEST_URI'], 'index.php?page=files-management') != false) {
echo "<link rel=\"stylesheet\" href=\"css/jquery-ui-1.8.13.custom.css\" type=\"text/css\" media=\"screen\" charset=\"utf-8\">
<script src=\"js/jquery-1.7.2.min.js\" type=\"text/javascript\" charset=\"utf-8\"></script>
<script src=\"js/jquery-ui-1.8.13.custom.min.js\" type=\"text/javascript\" charset=\"utf-8\"></script>
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
<body<?php if($_SERVER['REQUEST_URI']=="/sn10/index.php?page=add-news") echo " onLoad=\"window_onload()\"";?>>