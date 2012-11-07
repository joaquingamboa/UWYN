<?php
require('../class/news.php');
session_start();  
if(isset($_SESSION['user_id'])){    
function registerNews(){
	$titulo = $_POST['newstitle'];
	$url = $_POST['url'];
        $estado = $_POST['estado'];
        if($estado==""){
            $estado=1;
        }
	if($url==""){
		$url=getPermLink($titulo,"registerNews");
	}
	$imageurl = $_POST['imageurl'];
	$contenido = $_POST['contenido'];
	$resumen=$_POST['resumen'];
        date_default_timezone_set('Chile/Continental');
        $fechaInicio=date("Y-m-d H:i:s");
        $fechaModificacion=date("Y-m-d H:i:s");
        $user_id=$_SESSION['user_id'];
        $nickname = $_SESSION['user_nickname'];
	$noticia = new News(null,$user_id,$titulo,$url,$contenido,$fechaInicio,$fechaModificacion,$resumen,$estado,$imageurl,$user_id,$nickname,$nickname);
	$id=$noticia->addNews();
        $noticia = null;
	if($id){
	echo "Registro Exitoso";	
	}else{
        echo "Registro Fallido";
        }
								}

function permLinkUsed($value){
         $noticia = new News(null,1,null,$value,null,null,null,null,null,null,null,null,null);
         $cont = $noticia->getUrlUse();
         return $cont[0];
        
}                                                             
                                                                

function getPermLink($value,$from)
{
    $url = $value;
    $url = preg_replace('~[^\\pL0-9_]+~u', '-', $url); // substitutes anything but letters, numbers and '_' with separator
    $url = trim($url, "-");
    $url = iconv("utf-8", "us-ascii//TRANSLIT", $url); // TRANSLIT does the whole job
    $url = strtolower($url);
    $url = preg_replace('~[^-a-z0-9_]+~', '', $url); // keep only letters, numbers, '_' and separator
    $dat = permLinkUsed($url);
    if($dat == 0 && $from == "registerNews"){
    return $url; 
    }else{
     if($dat == 1){
         echo 1;   
         }elseif($dat == 0){
         echo $url;    
         }    
    }
    
     
 /*   $result = array("link" => $url);
    echo json_encode($result);   */
}

function deleteBI($id){
     $noticia = new News($id,null,null,null,null,null,null,null,null,null,null,null,null);
     $count = $noticia->deleteNewsById();
     if($count == 1){
        echo "Noticia Eliminada";
        echo "<script>alert(\"Noticia Eliminada.\");</script>";
     }else{
         if($count == 0){
         echo "La noticia No ha sido eliminada";
         echo "<script>alert(\"Noticia no Eliminada.\");</script>";
         
         }else{
          echo "Ha ocurrido un error";
          echo "<script>alert(\"Error.\");</script>";
         }
       
     }
    $url="../index.php?page=noticias";
    $comando = "<script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'500'.");</script>";
    echo ($comando);
}



if($_POST){
        switch($_POST["tarea"]){
                case "permlink":getPermLink($_POST['newstitle'],null);
                break;		
		case "ajax":registerNews();
                break;
        }
    }

if($_GET){
        switch($_GET["tarea"]){
                case "deleteNew":deleteBI($_GET['id']);
                break;		
        }
    }
?>


<?php
}
?>