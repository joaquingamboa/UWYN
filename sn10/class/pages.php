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
                   /* $UPATH = "http://".$_SERVER['HTTP_HOST'];
                    $url = "$UPATH/sn10/index.php?page=paginas";*/
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
      $stmt = $this->prepare("SELECT page_id, page_title FROM pages WHERE page_category != NULL;");   
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

        
 
}
?>
