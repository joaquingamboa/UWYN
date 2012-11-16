<?php
require('../class/users.php');
session_start();
if(isset($_SESSION['user_id']) && $_SESSION['user_username'] == 'admin'){
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function registrarUser(){
$tnoticias = $_POST['tnoticias'];
$tpaginas = $_POST['tpaginas'];
$usuario = $_POST['usuario'];
$nickname = $_POST['nombredepila'];
$password = $_POST['contrasena'];
$status = $_POST['estado'];
$usuarioEU = getUsernameInUse($usuario, 'register');
$nicknameEU = getNicknameInUse($nickname, 'register');
date_default_timezone_set('Chile/Continental'); 
$registertime=date("Y-m-d H:i:s");
if($usuarioEU == 'false' || $nicknameEU == 'false'){
    exit("USUARIO O NICKNAME EN USO");
}
$creacion = new User(null, $usuario, $password, $nickname, $registertime, $status);
$creacion->setTnoticias($tnoticias);
$creacion->setTpaginas($tpaginas);
$rsp = $creacion->addUser();
if($rsp == true){
   echo "USUARIO AGREGADO CON EXITO"; 
        }else{
            echo "ERROR AL AGREGAR USUARIO";
        }
}

function getUsernameInUse($username,$from){
$usuario = new User(null, $username, null, null, null, null);  
$rsp = $usuario->verifica_UserEnUso();
if($from =='register'){
    return $rsp;
}else{
    echo $rsp; 
}
}

function getNicknameInUse($nickname,$from){
$usuario = new User(null, null, null, $nickname, null, null);  
$rsp = $usuario->verifica_NickEnUso();
if($from =='register'){
    return $rsp;
}else{
    echo $rsp; 
}
}

if($_POST){
        switch($_POST["tarea"]){
                case "add-user":registrarUser();
                break;			
        }
    }


if($_GET){
        switch($_GET["tarea"]){
                case "getUsernameInUse":getUsernameInUse($_GET['username'],'');
                break;
                case "getNicknameInUse":getNicknameInUse($_GET['nickname'],'');
                break;
        }
    }
}
?>


