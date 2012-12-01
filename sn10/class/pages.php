<?php
require_once('conexion.php');

class Pages extends PDO{
        protected $page_id;
        public $page_title;
        public $page_url;
        public $page_date;
        public $page_modified;
        public $html_title;
        public $html_description;
        public $html_keywords;
        public $html_content;
        public $user_mod;
        public $page_author;
        public $nombre_author;
        public $nombre_modificador;
        public $page_category;
        private $db;
        
        
        public function getPage_category() {
            return $this->page_category;
        }

        public function setPage_category($page_category) {
            $this->page_category = $page_category;
        }

        public function getNombre_author() {
            return $this->nombre_author;
        }

        public function setNombre_author($nombre_author) {
            $this->nombre_author = $nombre_author;
        }

        public function getNombre_modificador() {
            return $this->nombre_modificador;
        }

        public function setNombre_modificador($nombre_modificador) {
            $this->nombre_modificador = $nombre_modificador;
        }
                
        public function getPage_id() {
            return $this->page_id;
        }

        public function setPage_id($page_id) {
            $this->page_id = $page_id;
        }

        public function getPage_title() {
            return $this->page_title;
        }

        public function setPage_title($page_title) {
            $this->page_title = $page_title;
        }

        public function getPage_url() {
            return $this->page_url;
        }

        public function setPage_url($page_url) {
            $this->page_url = $page_url;
        }

        public function getPage_date() {
            return $this->page_date;
        }

        public function setPage_date($page_date) {
            $this->page_date = $page_date;
        }

        public function getPage_modified() {
            return $this->page_modified;
        }

        public function setPage_modified($page_modified) {
            $this->page_modified = $page_modified;
        }

        public function getHtml_title() {
            return $this->html_title;
        }

        public function setHtml_title($html_title) {
            $this->html_title = $html_title;
        }

        public function getHtml_description() {
            return $this->html_description;
        }

        public function setHtml_description($html_decription) {
            $this->html_decription = $html_decription;
        }

        public function getHtml_keywords() {
            return $this->html_keywords;
        }

        public function setHtml_keywords($html_keywords) {
            $this->html_keywords = $html_keywords;
        }

        public function getHtml_content() {
            return $this->html_content;
        }

        public function setHtml_content($html_content) {
            $this->html_content = $html_content;
        }

        public function getUser_mod() {
            return $this->user_mod;
        }

        public function setUser_mod($user_mod) {
            $this->user_mod = $user_mod;
        }

        public function getPage_author() {
            return $this->page_author;
        }

        public function setPage_author($page_author) {
            $this->page_author = $page_author;
        }

        function __construct($page_id, $page_title, $page_url, $page_date, $page_modified, $html_title, $html_description, $html_keywords, $html_content, $user_mod, $page_author, $nombre_author, $nombre_modificador, $page_category) {
            $this->page_id = $page_id;
            $this->page_title = $page_title;
            $this->page_url = $page_url;
            $this->page_date = $page_date;
            $this->page_modified = $page_modified;
            $this->html_title = $html_title;
            $this->html_description = $html_description;
            $this->html_keywords = $html_keywords;
            $this->html_content = $html_content;
            $this->user_mod = $user_mod;
            $this->page_author = $page_author;
            $this->nombre_author = $nombre_author;
            $this->nombre_modificador = $nombre_modificador;
            $this->page_category = $page_category;
        }

        
        
       function open_conecction(){
        try{
            $dsn="mysql:dbname=".DB_NAME.";host=".DB_HOST;
            $this->db = parent::__construct($dsn, DB_USER, DB_PASS);
        }catch (PDOException $e ) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
                             }
                                  }     
    
      function close_conecction(){
            $this->db=null;
        }
        
      private function verificarPrivilegio($privilegio,$tabla){
        $uid = $_SESSION['user_id'];
        $stmt = $this->prepare("SELECT isAdmin FROM users WHERE ID = :data1;");
        $stmt->bindValue(':data1', $uid);
        $stmt->execute();
        $result = $stmt->fetchObject();
        $isAdmin = $result->isAdmin;
        $_SESSION['isAdmin'] = $isAdmin;
        if ($isAdmin == 1) {
            return true;
        }else{
        $stmt = $this->prepare("SELECT * FROM users_privileges WHERE user_ID = :data1 AND privilege = :data2 AND object = :data3");
        $stmt->bindValue(':data1', $uid);
        $stmt->bindValue(':data2', $privilegio);
        $stmt->bindValue(':data3', $tabla);
        $stmt->execute();
        $count = $stmt->rowCount();
                if ($stmt->errorCode()) {
                        $arr = $stmt->errorInfo();
                            if ($arr[0]!='00000'){           
                                 throw new Exception($arr[2]);     
                             }
                       }
        if($count!=1){
            return false;      
        }else{
            return true;
        }   
               
                }
        }
        
      public function agregarPagina(){
       try{
            $this->open_conecction();
            $rsp = $this->verificarPrivilegio('Insert', 'PAGES'); 
                if($rsp === false){
                    $comando = "No tienes privilegios para Crear nuevas paginas\n";  
                    throw new Exception($comando); 
                                     }                    
            $stmt = $this->prepare('INSERT INTO pages (page_category, user_mod, page_author, page_title, page_url, page_date,
                                    page_modified, html_title, html_description, html_keywords, html_content)
                                    VALUES(:data1, :data2, :data3, :data4 , :data5, :data6 , :data7, :data8, :data9, :data10, :data11)');       
            $options=array(
            ":data1"=>$this->getPage_category(),
            ":data2"=>$this->getPage_author(),
            ":data3"=>$this->getPage_author(),
            ":data4"=>$this->getPage_title(),
            ":data5"=>$this->getPage_url(),
            ":data6"=>$this->getPage_date(),
            ":data7"=>$this->getPage_modified(),
            ":data8"=>$this->getHtml_title(),
            ":data9"=>$this->getHtml_description(),
            ":data10"=>$this->getHtml_keywords(),
            ":data11"=>$this->getHtml_content()
                       );
	    $stmt->execute($options);
            $id = $this->lastInsertId();
            $count[0] = $id;
            $count[1] = $stmt->errorInfo();
            $this->close_conecction();
	    return $count;
            }catch(Exception $e){
                $this->close_conecction();
                echo $e->getMessage();
            }
	}   
      
    
      public function verificarUrlEnUso(){
        $url = $this->getPage_url();
        $this->open_conecction();   
        $stmt = $this->prepare("SELECT COUNT(*) FROM pages WHERE page_url = ?;");
        $stmt->execute(array($url));
        $result = $stmt->fetchColumn();
        $this->close_conecction();
        return $result;
        }
      
      public function obtenerCategoriasPrincipales(){
      $this->open_conecction();
      $cont = 0;
      $stmt = $this->prepare("SELECT page_id, page_title FROM pages WHERE page_category IS NULL;");   
      $stmt->execute();
      $categorias=array();     
         while($fila = $stmt->fetch()){
               $categoria = new Pages($fila['page_id'], $fila['page_title'], null, null, null, null, null, null, null, null, null, null, null, null); 
               $categorias[$cont]=$categoria;
               $cont++;
            }
         $this->close_conecction();
         return $categorias;       
      }

      public function obtenerCategoriasParaPasar($page_id){
      $this->open_conecction();
      $cont = 0;
      $stmt = $this->prepare("SELECT page_id, page_title FROM pages WHERE page_id != :data1 AND page_category IS NULL;");
      $stmt->bindValue(':data1', $page_id);
      $stmt->execute();
      $categorias=array();     
         while($fila = $stmt->fetch()){
               $categoria = new Pages($fila['page_id'], $fila['page_title'], null, null, null, null, null, null, null, null, null, null, null, null); 
               $categorias[$cont]=$categoria;
               $cont++;
            }
         $this->close_conecction();
         return $categorias;       
      }
      
      public function obtenerTodasParaPaginacion($per_page){
        $this->open_conecction();
        $stmt = $this->prepare("SELECT * FROM pages");
        $stmt->execute();
        $count = $stmt->rowCount();
        $this->close_conecction();
        return ceil($count/$per_page);
      }
           
      public function obtenerPaginas($start, $per_page){
        $this->open_conecction();  
        try{         
        $rsp = $this->verificarPrivilegio('Select', 'PAGES'); 
        if($rsp === false){
          $comando = "No tienes privilegios para ver registros de la tabla noticias"; 
          throw new Exception($comando); 
        }  
        $cont=0;    
        $stmt = $this->prepare("SELECT t1.*, t2.user_nickname, t3.user_nickname as user_modificador 
                                FROM pages t1 INNER JOIN users t2 ON t1.page_author = t2.ID 
                                INNER JOIN users t3 ON t1.user_mod = t3.ID ORDER BY t1.page_date DESC LIMIT $start,$per_page");
        $stmt->execute();
        $paginas=array();     
         while($fila = $stmt->fetch()){
               $pagina = new Pages($fila['page_id'], $fila['page_title'], $fila['page_url'], $fila['page_date'], $fila['page_modified'], $fila['html_title'],
                                   $fila['html_description'],$fila['html_keywords'], $fila['html_content'], $fila['user_mod'], $fila['page_author'],
                                   $fila['user_nickname'], $fila['user_modificador'], $fila['page_category']);         
               $paginas[$cont]=$pagina;
               $cont++;
            }
         $this->close_conecction();
         return $paginas;
               }catch (Exception $e){
                   $this->close_conecction();
                   echo $e->getMessage();
               }
        }
        
    function verificarRelacionAEliminar(){
     try{
     $idpage = $this->getPage_id();
     $page_title = $this->getPage_title();
     $this->open_conecction();
     $rsp = $this->verificarPrivilegio('Delete', 'PAGES');
     if($rsp === false){
          throw new Exception("No tienes privilegios para borrar registros de la tabla Paginas"); 
                          }       
     $stmt = $this->prepare("SELECT * FROM pages WHERE page_category = :data1;");
     $stmt->bindValue(':data1', $idpage, PDO::PARAM_INT);
     $stmt->execute();
     $count =  $stmt->rowCount();
               if ($stmt->errorCode()) {
                $arr = $stmt->errorInfo();
                  if ($arr[0]!='00000'){
                         throw new Exception($arr[2]);     
                                        } 
                                     }

     $this->close_conecction();                                 
     if($count > 0){
     $url = UPATH."index.php?page=pasarCategoriaPaginaElim&IdAElim=$idpage&page_title=$page_title";    
     $comando = "<script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'1000'.");</script>";    
     echo $comando;   
     }else{
       $this->borrarPaginaPorId(null);
     }

     }catch(Exception $e){
            $rsp = $e->getMessage();
            $url = UPATH."index.php?page=paginas";
            $comando = "<script>alert(\"$rsp\");</script><script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'1000'.");</script>";                    
            echo $comando;
     }
     }
     
    function pasarACategoria($idpage,$idTPass){
    try{
    $this->open_conecction();
    $stmt = $this->prepare("UPDATE pages SET page_category = :data1 WHERE page_category = :data2;");
    $stmt->bindValue(':data1', $idTPass, PDO::PARAM_INT);
    $stmt->bindValue(':data2', $idpage);
    $stmt->execute();
            if ($stmt->errorCode()) {
                $arr = $stmt->errorInfo();
                    if ($arr[0]!='00000'){
                             $url = UPATH."index.php?page=paginas";
                             $comando = "<script>alert(\"$rsp\");</script><script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'1000'.");</script>";   
                                 throw new Exception($comando);     
                                                   }              
                                                }
    $this->close_conecction();                                            
    $url = UPATH."index.php?page=paginas";
    $comando = "<script>alert(\"La Pagina Fue Actualizada Exitosamente\");</script><script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'1000'.");</script>";                            
    echo $comando;                                              
    }catch(Exception $e){
        $this->close_conecction();
          $rsp = $e->getMessage();
          echo $rsp;
                        }    
    }
    
    function editarPaginaPorId(){
    try{
    $this->open_conecction();
    $rsp = $this->verificarPrivilegio('Update', 'PAGES'); 
            if($rsp === false){
            $url = UPATH."index.php?page=paginas";
            $comando = array("No tienes privilegios para Actualizar paginas","<script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'1000'.");</script>");  
            throw new Exception($comando); 
                                }          
    $idpage = $this->getPage_id();
    $page_title = $this->getPage_title();  
    $html_title = $this->getHtml_title();
    $html_description = $this->getHtml_description();
    $html_keywords = $this->getHtml_keywords();
    $html_content = $this->getHtml_content();
    $url = $this->getPage_url();
    $fechaModificacion = $this->getPage_modified();
    $user_mod = $this->getUser_mod();
    $page_category = $this->getPage_category();
                 
            $stmt = $this->prepare('UPDATE pages SET user_mod = :data1, page_title = :data2, page_url = :data3,
                                    page_modified = :data4, html_title = :data5, html_description = :data6, html_keywords = :data7,
                                    html_content = :data8 WHERE page_id = :data9');       
            $options=array(
            ":data1"=>$user_mod,
            ":data2"=>$page_title,
            ":data3"=>$url,
            ":data4"=>$fechaModificacion,
            ":data5"=>$html_title,
            ":data6"=>$html_description,
            ":data7"=>$html_keywords,
            ":data8"=>$html_content,
            ":data9"=>$idpage
                       );
	    $stmt->execute($options);
              if ($stmt->errorCode()) {
               $arr = $stmt->errorInfo();
                 if ($arr[0]!='00000'){
                        throw new Exception($arr[2]);     
                                       } 
                                    }        
           $stmt = $this->prepare("UPDATE pages SET page_category = :data1 WHERE page_id = :data2;");
                $stmt->bindValue(':data1', $page_category, PDO::PARAM_INT);
                $stmt->bindValue(':data2', $idpage, PDO::PARAM_INT);
                $stmt->execute();
                       if ($stmt->errorCode()) {
                           $arr = $stmt->errorInfo();
                             if ($arr[0]!='00000'){
                                  $url = UPATH."index.php?page=paginas";          
                                  $comando = array("ERROR AL ACTUALIZAR PAGINA","<script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'1000'.");</script>");     
                                    throw new Exception($comando);     
                                                   }              
                                                }  
          if($page_category!=null){
                $stmt = $this->prepare("SELECT * FROM pages WHERE page_category = :data1;");
                $stmt->bindValue(':data1', $idpage, PDO::PARAM_INT);
                $stmt->execute();
                $count =  $stmt->rowCount();
                          if ($stmt->errorCode()) {
                           $arr = $stmt->errorInfo();
                             if ($arr[0]!='00000'){
                                    throw new Exception($arr[2]);     
                                                   }              
                                                }
              if($count > 0){
                $url = UPATH."index.php?page=cambioCatPorSubp&IdAEdit=$idpage&page_title=$page_title";          
                $comando = array("Pagina Actualizada, Lea las siguientes instrucciones","<script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'1000'.");</script>");     
                echo json_encode($comando);     
                }
 
                                 }else{
            $url = UPATH."index.php?page=paginas";
            $comando = array("Pagina Actualizada","<script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'1000'.");</script>"); 
            echo json_encode($comando); 
                                 }
                             
        }catch (Exception $e){
            $this->close_conecction();
            $rsp = $e->getMessage();
            echo json_encode($rsp);
        }
    }
     
    function borrarPaginaPorId($idTPass){
    $idpage = $this->getPage_id();
    $TPass = $idTPass;
    try{                                                           
    $this->open_conecction();
    $this->beginTransaction();
     $rsp = $this->verificarPrivilegio('Delete', 'PAGES');
     if($rsp === false){
          throw new Exception("No tienes privilegios para borrar registros de la tabla Paginas."); 
                        }       
    if($idTPass != NULL){
    $stmt = $this->prepare("UPDATE pages SET page_category = :data1 WHERE page_category = :data2;");
    $stmt->bindValue(':data1', $TPass, PDO::PARAM_INT);
    $stmt->bindValue(':data2', $idpage, PDO::PARAM_INT);
    $stmt->execute(); 
          if ($stmt->errorCode()) {
               $arr = $stmt->errorInfo();
                 if ($arr[0]!='00000'){
                        throw new Exception($arr[2]);     
                                       } 
                                    }                              
    }
    $stmt = $this->prepare("DELETE FROM pages WHERE page_id = :data1;");
    $stmt->bindValue(':data1', $idpage);
    $stmt->execute(); 
          if ($stmt->errorCode()) {
               $arr = $stmt->errorInfo();
                 if ($arr[0]!='00000'){
                        throw new Exception($arr[2]);     
                                       } 
                                    }
      $this->commit();
      $this->close_conecction();
      $url = UPATH."index.php?page=paginas";
      $comando = "<script>alert(\"La Pagina Fue Eliminada\");</script><script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'1000'.");</script>";                            
      echo $comando;  
            }catch(Exception $e){
               $rsp = $e->getMessage();
               $this->rollBack();
               $this->close_conecction();
               $url = UPATH."index.php?page=paginas";
               $comando = "<script>alert(\"$rsp\");</script><script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'1000'.");</script>";                            
               echo $comando;
                                 }     
      }
      
      
     function obtenerInformacionParaEditar(){
      try{        
        $this->open_conecction();
        $rsp = $this->verificarPrivilegio('Update', 'PAGES');
        if($rsp === false){
          throw new Exception("No tienes privilegios para Actualizar registros de la tabla Paginas."); 
                          }  
        $id = $this->getPage_id();
        $stmt = $this->prepare("SELECT * FROM pages WHERE page_id = :data1;");
        $stmt->bindParam(':data1', $id);
        $stmt->execute();
        $paginas=array();
        $cont=0;
           if ($stmt->errorCode()) {
               $arr = $stmt->errorInfo();
                 if ($arr[0]!='00000'){
                        $comando = "Error al tratar de editar la Pagina";
                        throw new Exception($comando);   
                                       } 
                                    }
         while($fila = $stmt->fetch()){
                $pagina = new Pages($id, $fila['page_title'], $fila['page_url'], null, null, $fila['html_title'], $fila['html_description'],
                                    $fila['html_keywords'], $fila['html_content'], null, null, null, null, $fila['page_category']);
                $paginas[$cont]=$pagina;
                $cont++;
            }
            $this->close_conecction();
            return $paginas;   
        $this->close_conecction();
            }catch(Exception $e){
                 $rsp = $e->getMessage();
                 $this->close_conecction();
                 $url = UPATH."index.php?page=paginas";
                 $comando = "<script>alert(\"$rsp\");</script><script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'1000'.");</script>";                            
                 echo $comando;
                                }   
    }

}
?>
