<?php
//require('mysql_pdo.php');
require_once('conexion.php');

class User extends PDO{
    protected $id;
    public $email;
    protected $pass;
    public $nickname;
    private $registertime;
    public $status;
    
    function __construct($id, $email, $pass, $nickname, $registertime, $status) {
        $this->id = $id;
        $this->email = $email;
        $this->pass = $pass;
        $this->nickname = $nickname;
        $this->registertime = $registertime;
        $this->status = $status;
        $dsn="mysql:dbname=".DB_NAME.";host=".DB_HOST;
        parent::__construct($dsn, DB_USER, DB_PASS);       
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
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

        
    public function inicia($tiempo=3600) { 
        $email = $this->getEmail();
        $pass = $this->getPass();
            if ($email==NULL && $pass==NULL) {
                // Verifica sesion
                if (isset($_SESSION['user_id'])) {
                $url="http://localhost/modular/sn10/index.php?page=index";
                $comando = "<script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'1000'.");</script>";
                echo ($comando);
                } else {
                        // Si no hay sesion regresa al login
                header( "Location: http://localhost/modular/sn10/index.php" );
                    }   
            //Si email o pass tienen algo verifica el usuario     
            } else {
                $this->verifica_usuario($tiempo, $email, $pass);
            }
        }  
        
        
    //  Verifica login
    private function verifica_usuario($tiempo, $usuario, $clave) {  
        $tables=array();
        $stmt = $this->prepare("SELECT * FROM users WHERE user_email = :data1 AND user_pass = :data2 AND user_status=1;");
        $stmt->bindParam(':data1', $usuario);
        $stmt->bindParam(':data2', $clave); 
        $stmt->execute();
        $count =  $stmt->rowCount();
        $result = $stmt->fetchObject();
       if ($count==1) {
            // Si los datos ingresados son correctos  
            session_start();  
            $_SESSION['user_id'] = $result->ID;
            $_SESSION['user_email'] = $usuario;
            $_SESSION['user_nickname'] = $result->user_nickname;   
        } else {
            // Si la clave es incorrecta
         $url="http://localhost/modular/sn10/login.php";
                $comando = "<script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'1000'.");</script>";
                echo ($comando);
        }
    }
    
     function obtenerNickname() {  
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

}
?>
