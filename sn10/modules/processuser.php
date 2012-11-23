<?php
session_start();
require('../class/users.php');
if(isset($_SESSION['user_id']) && $_SESSION['isAdmin'] == 1){
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function registrarUser(){
$admin = $_POST['administrador'];
$tnoticias = $_POST['tnoticias'];
$tpaginas = $_POST['tpaginas'];
$usuario = $_POST['usuario'];
$nickname = $_POST['nombredepila'];
$password = md5($_POST['contrasena']);
$status = $_POST['estado'];
$usuarioEU = getUsernameInUse($usuario, 'register');
$nicknameEU = getNicknameInUse($nickname, 'register');
date_default_timezone_set('Chile/Continental'); 
$registertime=date("Y-m-d H:i:s");
if($usuarioEU == 'false' || $nicknameEU == 'false'){
    exit("USUARIO O NICKNAME EN USO");
}
$creacion = new User(null, $usuario, $password, $nickname, $registertime, $status,$tpaginas,$tnoticias, $admin);
$rsp = $creacion->addUser();
if($rsp == true){
   echo "USUARIO AGREGADO CON EXITO"; 
        }else{
        echo "ERROR AL AGREGAR USUARIO";
        }
}

function getUsernameInUse($username,$from){
$usuario = new User(null, $username, null, null, null, null,null,null,null);  
$rsp = $usuario->verifica_UserEnUso();
if($from =='register'){
    return $rsp;
}else{
    echo $rsp; 
}
}

function getNicknameInUse($nickname,$from){
$usuario = new User(null, null, null, $nickname, null, null,null,null,null);  
$rsp = $usuario->verifica_NickEnUso();
if($from =='register'){
    return $rsp;
}else{
    echo $rsp; 
     }
}

function deleteUserById($id,$username){
$usuario = new User($id, $username, null, null, null, null, null, null, null);  
//$usuario->borrarUsuarioPorId();
$rsp = $usuario->verificarRelacionAEliminar();
echo $rsp;
}

function deleteFinal(){
$usuario = new User($_POST['IdAElim'], $_POST['username'], null, null, null, null, null, null, null);
$IdTPass = $_POST['IdTPass'];
$usuario->borrarUsuarioPorId($IdTPass);
}

function editarUser(){
$id = $_POST['idTEdit'];
$admin = $_POST['administrador'];
$tnoticias = $_POST['tnoticias'];
$tpaginas = $_POST['tpaginas'];
$usuario = $_POST['usuario'];
$nickname = $_POST['nombredepila'];
$password = $_POST['contrasena'];
$status = $_POST['estado'];    
$usuario = new User($id, $usuario, $password, $nickname, null, $status, $tpaginas, $tnoticias, $admin);
$rsp = $usuario->editUserById();
if($rsp == true){
   echo "USUARIO MODIFICADO CON EXITO"; 
        }else{
        echo "ERROR AL MODIFICAR USUARIO";
        }
}


if($_POST){
        switch($_POST["tarea"]){
                case "add-user":registrarUser();
                break;
                case "finalDelete":deleteFinal();
                break;
                case "edit-user":editarUser();
                break;
        }
    }


if($_GET){
        switch($_GET["tarea"]){
                case "getUsernameInUse":getUsernameInUse($_GET['username'],'');
                break;
                case "getNicknameInUse":getNicknameInUse($_GET['nickname'],'');
                break;
                case "deleteUser":deleteUserById($_GET['id'],$_GET['username']);
                break;
        }
    }
}else{
    echo "ACCESO RESTRINGIDO";
}
?>


