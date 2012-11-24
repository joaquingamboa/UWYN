<?php
require('../class/pages.php');
session_start();  
if(isset($_SESSION['user_id'])){    
function registerPage(){
	$titulo = $_POST['page_title'];
        $html_title = $_POST['titulo_html'];
        $html_description = $_POST['descripcion_html'];
        $html_keywords = $_POST['keywords'];
        $html_content = $_POST['contenido_html'];
	$url = $_POST['url'];
	if($url==""){
		$url=getPermLink($titulo,"registerPage");
	}
        date_default_timezone_set('Chile/Continental');
        $fechaCreacion=date("Y-m-d H:i:s");
        $fechaModificacion=date("Y-m-d H:i:s");
        $user_id=$_SESSION['user_id'];
        $nickname = $_SESSION['user_nickname'];
        $page_category = $_POST['principal_cat'];
	$pagina = new Pages(null, $titulo, $url, $fechaCreacion, $fechaModificacion, $html_title, $html_description, $html_keywords, $html_content, $user_id, $user_id, $nickname, $nickname, $page_category);
	if($page_category == ""){
            $pagina->setPage_category(NULL);
        }
        $count = $pagina->agregarPagina();
        if($count[0]){
        echo "Pagina Creada";
         }else{
         echo "La Pagina No ha sido Creada";
              }                       
                    }

function updateNews(){
    $titulo = $_POST['newstitle'];
    $url = $_POST['url'];
    $firsttitle = $_POST['cpermalink'];
    $estado = $_POST['estado'];
     if($estado==""){
            $estado = 1;
        }
     $imageurl = $_POST['imageurl'];
     if($url==""){
         $url = $firsttitle;
     }
     $contenido = $_POST['contenido'];
     $resumen=$_POST['resumen'];
     date_default_timezone_set('Chile/Continental');
     $fechaModificacion=date("Y-m-d H:i:s");
     $user_id=$_SESSION['user_id']; 
     $user_modificador = $_SESSION['user_nickname'];
     $fecha = $_POST['fecha'];
     $noticia = new News(null,null,$titulo,$url,$contenido,$fecha,$fechaModificacion,$resumen,$estado,$imageurl,$user_id,null,$user_modificador);
     $count = $noticia->updateNewsById($firsttitle);

        if($count[0] == 1){
        echo "Noticia Actualizada";
     }else{
         if($count[0] == 0){
         echo "Noticia no Actualizada"; 
         }else{
          echo "Error";
         }       
     }             
					}

function permLinkUsed($value){
         $pagina = new Pages(null, null, $value, null, null, null, null, null, null, null, null, null, null, null);
         $cont = $pagina->verificarUrlEnUso();
         return $cont;   
			   }                                                             
                                                                

function getPermLink($value,$from){
    $url = $value;
    $url = preg_replace('~[^\\pL0-9_]+~u', '-', $url); // substitutes anything but letters, numbers and '_' with separator
    $url = trim($url, "-");
    $url = iconv("utf-8", "us-ascii//TRANSLIT", $url); // TRANSLIT does the whole job
    $url = strtolower($url);
    $url = preg_replace('~[^-a-z0-9_]+~', '', $url); // keep only letters, numbers, '_' and separator
    $dat = permLinkUsed($url);
    if($dat == 0 && $from == "registerPage"){
    return $url; 
                }else{
                      if($dat == 1){
                        echo $dat;   
                        }elseif($dat == 0 && $from != "registerPage"){
                        echo $url;    
                        }    
                      }
}

function deleteBI($id){
     $noticia = new News($id,null,null,null,null,null,null,null,null,null,null,null,null);
     $count = $noticia->deleteNewsById();
        if($count[0] == 1){
        echo "<script>alert(\"Noticia Eliminada.\");</script>";
     }else{
         if($count[0] == 0){
         echo "<script>alert(\"Noticia no Eliminada.\");</script>";     
         }else{
          echo "<script>alert(\"Error.\");</script>";
         }       
     }  
    $UPATH = "http://".$_SERVER['HTTP_HOST'];
    $url = "$UPATH/sn10/index.php?page=noticias";
    $comando = "<script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'500'.");</script>";
    echo ($comando);
}



if($_POST){
        switch($_POST["tarea"]){
                case "permlink":getPermLink($_POST['pagetitle'],null);
                break;		
		case "add-page":registerPage();
                break;
                case "edit-page":updatePage();
                break;
        }
    }

if($_GET){
        switch($_GET["tarea"]){
                case "deletePage":deleteBI($_GET['id']);
                break;		
        }
    }
?>


<?php
}
?>