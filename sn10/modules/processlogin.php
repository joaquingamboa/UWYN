<?php
session_start();
require('../class/users.php');
function getUserLogin(){
    $username=$_POST['user'];
    $password=$_POST['pass'];
    $usuario = new User(null, $username, $password, null, null, null,null,null,null);
    $usuario->inicia(3600);   
}
//http://localhost/modular/sn10/modules/processlogin.php?tarea=logout                                                
if (isset($_SESSION['user_id'])){
function destroySession(){
    session_unset();
    session_destroy();
    echo "<script>alert(\"Desconectando.\");</script>";
    $url="../index.php";
    $comando = "<script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'1000'.");</script>";
    echo ($comando);
    echo "Redireccionando a Login";
                        }                                                        
								}


if($_POST){
        switch($_POST["tarea"]){
                case "ajax":getUserLogin();
                break;
        }
    }
if (isset($_SESSION['user_id'])){   
if($_GET){
        switch($_GET["tarea"]){
                case "logout":destroySession();
                break;
        }
    }
								}
?>
