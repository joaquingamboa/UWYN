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

function updatePage(){
    $idpage = $_POST['idAEditar'];
    $firsttitle = $_POST['cpermalink'];
    $titulo = $_POST['page_title'];
    $html_title = $_POST['titulo_html'];
    $html_description = $_POST['descripcion_html'];
    $html_keywords = $_POST['keywords'];
    $html_content = $_POST['contenido_html'];
    $url = $_POST['url'];
    if($url==""){
         $url = $firsttitle;
     }
    date_default_timezone_set('Chile/Continental');
    $fechaModificacion=date("Y-m-d H:i:s");
    $page_category = $_POST['principal_cat'];
    $pagina = new Pages($idpage, $titulo, $url, null, $fechaModificacion, $html_title, $html_description, $html_keywords, $html_content, $_SESSION['user_id'], null, null, null, $page_category);
    if($page_category == ""){
            $pagina->setPage_category(NULL);
                             }
    $rsp = $pagina->editarPaginaPorId();
    echo $rsp;
			}
                                        
function updateFinal(){
 $idpage = $_POST['IdAEdit'];   
 $TPass = $_POST['IdTPass'];
 $pagina = new Pages(null, null, null, null, null, null, null, null, null, null, null, null, null, null);
 $rsp = $pagina->pasarACategoria($idpage, $TPass);
 echo $rsp;
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

function deleteById($id, $page_title){
    $pagina = new Pages($id, $page_title, null, null, null, null, null, null, null, null, null, null, null, null);
    $rsp = $pagina->verificarRelacionAEliminar();
    echo $rsp;
}

function deleteFinal(){
$pagina = new Pages($_POST['IdAElim'], null, null, null, null, null, null, null, null, null, null, null, null, null);
$IdTPass = $_POST['IdTPass'];
$pagina->borrarPaginaPorId($IdTPass);
}



if($_POST){
        switch($_POST["tarea"]){
                case "permlink":getPermLink($_POST['pagetitle'],null);
                break;		
		case "add-page":registerPage();
                break;
                case "edit-page":updatePage();
                break;
                case "finalUpdate":updateFinal();
                break;
        }
    }

if($_GET){
        switch($_GET["tarea"]){
                case "deletePage":deleteById($_GET['id'], $_GET['page_title']);
                break;		
        }
    }
?>


<?php
}
?>