<?php
//require('mysql_pdo.php');
require_once('conexion.php');

class User extends PDO{
    protected $id;
    public $username;
    protected $pass;
    public $nickname;
    private $registertime;
    public $status;
    public $tnoticias;
    public $tpaginas;
    
    function __construct($id, $username, $pass, $nickname, $registertime, $status) {
        $this->id = $id;
        $this->username = $username;
        $this->pass = $pass;
        $this->nickname = $nickname;
        $this->registertime = $registertime;
        $this->status = $status;
             
    }

    
    function open_conecction(){
        try {
            $dsn="mysql:dbname=".DB_NAME.";host=".DB_HOST;
            $this->db = parent::__construct($dsn, DB_USER, DB_PASS);
        }catch (PDOException $e ) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
    
    function open_UserConecction(){
        try {
            $dsn="mysql:dbname=".DB_NAME.";host=".DB_HOST;
            $this->db = parent::__construct($dsn, $_SESSION['user_username'], $_SESSION['user_password']);
        }catch (PDOException $e ) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
                                }

    
    function close_conecction(){
            $this->db==null;
        }

    public function getTnoticias(){
        return $this->tnoticias;
    }
    
    public function setTnoticias($tnoticias){
        $this->tnoticias = $tnoticias;
    }
    
    public function getTpaginas(){
        return $this->tpaginas;
    }
    
    public function setTpaginas($tpaginas){
        $this->tpaginas = $tpaginas;
    }
            
    public function getId() {
        return $this->id;
    }


    public function setId($id) {
        $this->id = $id;
    }


    public function getUsername() {
        return $this->username;
    }


    public function setUsername($username) {
        $this->username = $username;
    }


    public function getPass() {
        return $this->pass;
    }


    public function setPass($pass) {
        $this->pass = $pass;
    }


    public function getNickname() {
        return $this->nickname;
    }


    public function setNickname($nickname) {
        $this->nickname = $nickname;
    }


    public function getRegistertime() {
        return $this->registertime;
    }


    public function setRegistertime($registertime) {
        $this->registertime = $registertime;
    }


    public function getStatus() {
        return $this->status;
    }


    public function setStatus($status) {
        $this->status = $status;      
    }

    function verifica_UserEnUso(){
    $usuario = $this->getUsername();
    $this->open_conecction();
    $stmt = $this->prepare("SELECT t1.* FROM sitio.users t1 INNER JOIN mysql.user t2 ON t1.username=t2.User WHERE t2.User = :data1;");    
    $stmt->bindParam(':data1', $usuario);
    $stmt->execute();
    $count =  $stmt->rowCount();
    $true = "true";
    $false = "false";
    if($count==1){
        return $false;
    }
    
    if($count==0){
        return $true;
    }  
    }
    
    function verifica_NickEnUso(){
    $nickname = $this->getNickname();
    $this->open_conecction();
    $stmt = $this->prepare("SELECT * FROM sitio.users WHERE user_nickname = :data1;");    
    $stmt->bindParam(':data1', $nickname);
    $stmt->execute();
    $count =  $stmt->rowCount();
    $true = "true";
    $false = "false";
    if($count==1){
        return $false;
    }
    
    if($count==0){
        return $true;
    }  
    } 
        
    public function inicia($tiempo=3600) { 
        $this->open_conecction();
        $username = $this->getUsername();
        $pass = $this->getPass();
            if ($username==NULL && $pass==NULL) {
                // Verifica sesion
                if (isset($_SESSION['user_id'])) {
                $url="http://localhost/modular/sn10/index.php?page=index";
                $comando = "<script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'1000'.");</script>";
                echo ($comando);
                }else{
                        // Si no hay sesion regresa al login
                header( "Location: http://localhost/modular/sn10/index.php" );
                    }
   
            //Si email o pass tienen algo verifica el usuario     
            }else{
                $this->verifica_usuario($tiempo, $username, $pass);
            }

        $this->close_conecction();
        }   
        
    //  Verifica login
    private function verifica_usuario($tiempo, $usuario, $clave) {  
        $stmt = $this->prepare("SELECT t1.*,t2.Password FROM sitio.users t1 INNER JOIN mysql.user t2 ON t1.username=t2.User WHERE t1.username = :data1 AND t2.Password = Password(:data2)  AND t1.user_status=1;");
        $stmt->bindParam(':data1', $usuario);
        $stmt->bindParam(':data2', $clave); 
        $stmt->execute();
        echo $usuario;
        $count =  $stmt->rowCount();
        $result = $stmt->fetchObject();
       if ($count==1) {
            // Si los datos ingresados son correctos  
            session_start();  
            $_SESSION['user_id'] = $result->ID;
            $_SESSION['user_username'] = $usuario;
            $_SESSION['user_nickname'] = $result->user_nickname;   
            $_SESSION['user_password'] = $clave;
        }
 else {
            // Si la clave es incorrecta
                $url="http://localhost/modular/sn10/login.php";
                $comando = "<script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'1000'.");</script>";
                echo ($comando);
        }

    }

    
     public function getUsers($start, $per_page){
        $this->open_conecction();
        $cont=0;    
        $stmt = $this->prepare("SELECT ID, username, user_nickname, user_registertime, user_status
                                FROM users LIMIT $start,$per_page");
        $stmt->execute();
        $usuarios=array();     
         while($fila = $stmt->fetch()){
               $usuario = new User($fila['ID'],$fila['username'],null,$fila['user_nickname'],$fila['user_registertime'],
               $fila['user_status']);
               $usuarios[$cont]=$usuario;
               $cont++;
            }
 
         $this->close_conecction();
         return $usuarios;            
        }

        
        public function getAllUsersPagination($per_page){
        $this->open_conecction();
        $stmt = $this->prepare("SELECT * FROM users");
        $stmt->execute();
        $count = $stmt->rowCount();
        return ceil($count/$per_page);
        }

        public function addUser(){
        $tnoticias = $this->getTnoticias();
        $tpaginas = $this->getTpaginas();
        $username = $this->getUsername();
        $password = $this->getPass();
        $nickname = $this->getNickname();
        $status = $this->getStatus();
        $registertime = $this->getRegistertime();
        try{
         $this->open_UserConecction();  
         $stmt = $this->prepare("CREATE USER :data1@'localhost' IDENTIFIED BY :data2;");
         $stmt->bindValue(':data1', $username);
         $stmt->bindValue(':data2', $password);
         $stmt->execute(); 
        if ($stmt->errorCode()) {
               $arr = $stmt->errorInfo();
               if ($arr[0]!='00000'){
               throw new Exception($arr[2]);     
                } 
        }
        if($tnoticias!=''){
        $stmt = $this->prepare("GRANT ".$tnoticias." ON sitio.news TO :data1@'localhost';");  
        $stmt->bindValue(':data1', $username);
        $stmt->execute();
          if ($stmt->errorCode()) {
               $arr = $stmt->errorInfo();
               if ($arr[0]!='00000'){
               throw new Exception($arr[2]);     
                } 
                                   }
        }

       if($tpaginas!=''){
        $stmt = $this->prepare("GRANT ".$tpaginas." ON sitio.pages TO :data1@'localhost';");  
        $stmt->bindParam(':data1', $username);
        $stmt->execute();
          if ($stmt->errorCode()) {
               $arr = $stmt->errorInfo();
               if ($arr[0]!='00000'){
               throw new Exception($arr[2]);     
                } 
                                   }
        }
        
        $stmt = $this->prepare("INSERT INTO sitio.users(username,user_nickname,user_registertime,user_status,users_ID) VALUES(:data1, :data2, :data3, :data4, :data5);");
        $stmt->bindParam(':data1', $username);
        $stmt->bindParam(':data2', $nickname);
        $stmt->bindParam(':data3', $registertime);
        $stmt->bindParam(':data4', $status);
        $stmt->bindParam(':data5', $_SESSION['user_id']);
        $stmt->execute();
          if ($stmt->errorCode()) {
               $arr = $stmt->errorInfo();
               if ($arr[0]!='00000'){
               throw new Exception($arr[2]);     
                }else{
                    return true;
                }
                                   }

        /* $this->exec("CREATE USER 'admin'@'localhost';") or die(print_r($this->errorInfo(),true));*/
        }catch(Exception $e){
             echo $e->getMessage();
        }
        }
     /*function obtenerNickname() {  
        $tables = array();
        $user_id = $this->getId();
        $stmt = $this->prepare("SELECT user_nickname FROM users WHERE ID = :data1;");
        $stmt->bindParam(':data1', $user_id);
        $stmt->execute();
        $count =  $stmt->rowCount();
        $result = $stmt->fetchObject();
       if ($count==1) {
           $this->setNickname($result->user_nickname);
                      }
      
                                 }
*/

}

?>
