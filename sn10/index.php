<?php
session_start();
//define("_path", "http://localhost/modular/sn10/");
?>

<?php
if (isset($_SESSION['user_id'])){
	include("includes/top_page.php"); 
?>
<div id="wrapper">		
    <div id="header">    	
    	<?php include("includes/header.php"); ?>        
    </div>  
    <div id="menu" style="font-size-adjust: 0.4;">
    		<?php include("includes/menu.php"); ?>
    </div>	
    <div id="content">
    	<?php include("includes/pages.php"); ?>        
        
    </div>
    <div id="footer">   	   
	    <?php include("includes/footer.php"); ?>        
    </div>
</div>
<?php include("includes/bottom_page.php");
}else{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mi pagina modular Parte 2</title>
<link href="login.css" rel="stylesheet" type="text/css" />
<link href="tables.css" rel="stylesheet" type="text/css" />	
<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="js/validateLogin.js"></script>
<style type="text/css">
label.error { float: none; color: red; padding-left: .5em;}

/*.submit { margin-left: 12em; }
*/
</style>
</head>
<body>
<form id="login" name="login" method="post" action="modules/processlogin.php">
   <h1>Log In</h1>
    <fieldset id="inputs">
        <input id="username" name="username" type="input" autofocus placeholder="Username" class="required" />   
        <input id="password" name="password" type="password" placeholder="Password" class="required" />
    </fieldset>
    <fieldset id="actions">
        <input type="submit" id="submit" value="Log in">
        <a href="">Forgot your password?</a>
    </fieldset>
</form>
</body>
</html>
<?php } ?>
