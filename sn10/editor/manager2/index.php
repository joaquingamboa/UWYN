<?php
session_start();
if (isset($_SESSION['user_id'])){
error_reporting(E_ALL ^ E_NOTICE);
include("config.inc.php");
// upload
if ($_GET['action']=="upload") {
	$file_name=$_FILES["ffoto"]["name"];
	$file_size=$_FILES["ffoto"]["size"];
	$file_type=$_FILES["ffoto"]["type"];
	$path=$_POST['folder'];
	copy($_FILES['ffoto']['tmp_name'], $path.$file_name) ;
	$message='<p><b>Your file has been uploaded successfully</b></p>';
} else if ($_GET['action']=="delete") {
	unlink($_GET['file']);
}
// Crear carpeta
if ($_GET['action']=="create_folder") {
	$path=$_POST['folder'];
	mkdir($path.$_POST['fname'], 0777);
}
if ($_GET['action']=="delete_folder") {
	//echo 'folder deleted:'.$_GET['id'];
	rmdir($_GET['id']);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Editor</title>
<script language="javascript" src="js/jquery-1.2.6.min.js"></script>
<script language="javascript" src="js/jqueryFileTree.js"></script>
<script language="javascript" src="js/jquery.form.js"></script>
<script language="javascript" src="js/jquery.jframe.js"></script>
<link href="css/jqueryFileTree.css" rel="stylesheet" type="text/css" media="screen" />
<link href="css/file_manager.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function loadMyFrame(url,target){
	jQuery(target).loadJFrame(url);
	$(target).loadJFrame(url);
}
</script>
<script language="javascript">
$(document).ready(function(){
   	$('#navBar').fileTree({ 
		root: '<?php echo '../../'._folder; ?>', 
		script: 'jqueryFileTree.php', 
		loadMessage: 'Loading...',
		exts: 'jpeg,jpg,png,gif,tiff,pdf' }
		, function(file) { 
			//alert(file);
			loadMyFrame('file_details.php?file='+file, '#fileDetails');
	});
	jQuery.fn.waitingJFrame = function () {
    	$(this).html("<b>loading...</b>");
	};		
});
</script>
</head>
<body>
<div id="fileWrapper" src="#">		
	<h2>File Manager</h2>
    <a href="http://www.miguelmanchego.com/2008/file-manager-para-nicedit/" style="text-decoration:none; color:#666666; font-size:9px;" target="_blank">Designed by http://www.miguelmanchego.com</a>
	<div id="navBar" class="demo" src="#"></div>
    <div id="fileDetails">
    	<?php
			echo $message;
		?>
    	Please select file to edit
    </div>
</div>	
<script language="javascript">
function upload_file(cual) {
	//alert(cual);
	loadMyFrame('file_upload.php?folder='+cual, '#fileDetails');	
}
</script>    
</body>
</html>

<?php
}
?>