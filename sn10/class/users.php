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
    public $admin;
    public $db;
   
        function __construct($id, $username, $pass, $nickname, $registertime, $status, $tpaginas, $tnoticias, $admin) {
        $this->id = $id;
        $this->username = $username;
        $this->pass = $pass;
        $this->nickname = $nickname;
        $this->registertime = $registertime;
        $this->status = $status;
        $this->tpaginas = $tpaginas;
        $this->tnoticias = $tnoticias;
        $this->admin = $admin;
    }
    
    function open_conecction($username, $pass){
        try{
            $dsn="mysql:dbname=".DB_NAME.";host=".DB_HOST;
            $this->db = parent::__construct($dsn, $username, $pass);
        }catch (PDOException $e ) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
    
    function open_UserConecction(){ //cuando esta logueado
        try {
            $dsn="mysql:dbname=".DB_NAME.";host=".DB_HOST;
            $this->db = parent::__construct($dsn, $_SESSION['user_username'], $_SESSION['user_password']);
        }catch (PDOException $e ) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
                                }                         

    
   function close_conecction(){
            $this->db=null;
        }
        
    public function getAdmin() {
        return $this->admin;
    }

    public function setAdmin($admin) {
        $this->admin = $admin;
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
    
    function verificarRelacionAEliminar(){
    $iduser = $this->getId();
    $username = $this->getUsername();
    try{
    if($username == 'admin'){
       $url="http://localhost/modular/sn10/index.php?page=usuarios";
       $comando = "<script>alert(\"El usuario no puede ser Eliminado\");</script><script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'1000'.");</script>";
       throw new Exception($comando);     
                            }        
    $this->open_UserConecction();
    $stmt = $this->prepare("SELECT t1.* FROM sitio.users t1 INNER JOIN mysql.user t2 ON t1.username=t2.User WHERE t2.User = :data1 AND t2.Host='localhost';");
    $stmt->bindValue(':data1', $username);
    $stmt->execute();
    $count =  $stmt->rowCount();
              if ($stmt->errorCode()) {
               $arr = $stmt->errorInfo();
                 if ($arr[0]!='00000'){
                        throw new Exception($arr[2]);     
                                       } 
                                    }
    if($count == 1){
    $stmt = $this->prepare("SELECT * FROM news where news_author = :data1;");
    $stmt->bindValue(':data1', $iduser, PDO::PARAM_INT);
    $stmt->execute();
    $contador1 = $stmt->rowCount();
              if ($stmt->errorCode()) {
               $arr = $stmt->errorInfo();
                 if ($arr[0]!='00000'){
                        throw new Exception($arr[2]);     
                                       } 
                                    }
    $stmt = $this->prepare("SELECT * FROM news where news_usermodified = :data1;");
    $stmt->bindValue(':data1', $iduser, PDO::PARAM_INT);
    $stmt->execute();
    $contador2 = $stmt->rowCount();
              if ($stmt->errorCode()) {
               $arr = $stmt->errorInfo();
                 if ($arr[0]!='00000'){
                        throw new Exception($arr[2]);     
                                       } 
                                    }
    $stmt = $this->prepare("SELECT * FROM pages where page_author = :data1;");
    $stmt->bindValue(':data1', $iduser, PDO::PARAM_INT);
    $stmt->execute();
    $contador3 = $stmt->rowCount();
              if ($stmt->errorCode()) {
               $arr = $stmt->errorInfo();
                 if ($arr[0]!='00000'){
                        throw new Exception($arr[2]);     
                                       } 
                                    }
    $stmt = $this->prepare("SELECT * FROM pages WHERE user_mod = :data1;");
    $stmt->bindValue(':data1', $iduser, PDO::PARAM_INT);
    $stmt->execute();
    $contador4 = $stmt->rowCount();
              if ($stmt->errorCode()) {
               $arr = $stmt->errorInfo();
                 if ($arr[0]!='00000'){
                        throw new Exception($arr[2]);     
                                       } 
                                    } 
    if($contador1 >= 1 || $contador2 >= 1 || $contador3 >= 1 || $contador4 >= 1){
    $url="http://localhost/modular/sn10/index.php?page=pasarAUser&IdAElim=$iduser&username=$username";
    $comando = "<script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'1000'.");</script>";    
    return $comando;   
    }else{
      $this->borrarUsuarioPorId(NULL);
    }
    
    }
   
    }catch(Exception $e){
           echo $e->getMessage();  
    }
    
    }
    
    
    function borrarUsuarioPorId($idTPass){
    $username = $this->getUsername();
    $iduser = $this->getId();
    $TPass = $idTPass;
    try{  
    if($username == 'admin'){
       $url="http://localhost/modular/sn10/index.php?page=usuarios";
       $comando = "<script>alert(\"El usuario no puede ser Eliminado\");</script><script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'1000'.");</script>";
       throw new Exception($comando);    
                            }                                                                
    $this->open_UserConecction();                        
    if($idTPass != NULL){
    $stmt = $this->prepare("UPDATE news SET news_author = :data2 WHERE news_author = :data1;");
    $stmt->bindValue(':data1', $iduser, PDO::PARAM_INT);
    $stmt->bindValue(':data2', $TPass, PDO::PARAM_INT);
    $stmt->execute(); 
          if ($stmt->errorCode()) {
               $arr = $stmt->errorInfo();
                 if ($arr[0]!='00000'){
                        throw new Exception($arr[2]);     
                                       } 
                                    }
    $stmt = $this->prepare("UPDATE news SET news_usermodified = :data2 WHERE news_usermodified = :data1;");
    $stmt->bindValue(':data1', $iduser, PDO::PARAM_INT);
    $stmt->bindValue(':data2', $TPass, PDO::PARAM_INT);
    $stmt->execute(); 
          if ($stmt->errorCode()) {
               $arr = $stmt->errorInfo();
                 if ($arr[0]!='00000'){
                        throw new Exception($arr[2]);     
                                       } 
                                    } 
    $stmt = $this->prepare("UPDATE pages SET page_author = :data2 WHERE page_author = :data1;");
    $stmt->bindValue(':data1', $iduser, PDO::PARAM_INT);
    $stmt->bindValue(':data2', $TPass, PDO::PARAM_INT);
    $stmt->execute(); 
          if ($stmt->errorCode()) {
               $arr = $stmt->errorInfo();
                 if ($arr[0]!='00000'){
                        throw new Exception($arr[2]);     
                                       } 
                                    }
    $stmt = $this->prepare("UPDATE pages SET user_mod = :data2 WHERE user_mod = :data1;");
    $stmt->bindValue(':data1', $iduser, PDO::PARAM_INT);
    $stmt->bindValue(':data2', $TPass, PDO::PARAM_INT);
    $stmt->execute(); 
          if ($stmt->errorCode()) {
               $arr = $stmt->errorInfo();
                 if ($arr[0]!='00000'){
                        throw new Exception($arr[2]);  
                                       } 
                                    }                                 
    }                         
    $stmt = $this->prepare("DELETE FROM sitio.users WHERE users.ID = :data1");
    $stmt->bindValue(':data1', $iduser);
    $stmt->execute(); 
          if ($stmt->errorCode()) {
               $arr = $stmt->errorInfo();
                 if ($arr[0]!='00000'){
                        throw new Exception($arr[2]);     
                                       } 
                                    }
     $stmt = $this->prepare("DROP USER :data1@'localhost';"); //
     $stmt->bindValue(':data1', $username);
     $stmt->execute();                       
            if ($stmt->errorCode()) {
                  $arr = $stmt->errorInfo();
                      if ($arr[0]!='00000'){
                         throw new Exception($arr[2]);     
                                             } 
                                       }
                                       
      $url="http://localhost/modular/sn10/index.php?page=usuarios";
      $comando = "<script>alert(\"El usuario Fue Eliminado\");</script><script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'1000'.");</script>";                            
      echo $comando;  
      
            }catch(Exception $e){
               $rsp = $e->getMessage();
               $url="http://localhost/modular/sn10/index.php?page=usuarios";
               $comando = "<script>alert(\"$rsp\");</script><script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'1000'.");</script>";                            
               echo $comando;
                                 }     
      }
   
    
    
    function verifica_UserEnUso(){
    $usuario = $this->getUsername();
    $this->open_UserConecction();
    $stmt = $this->prepare("SELECT t1.* FROM sitio.users t1 INNER JOIN mysql.user t2 ON t1.username=t2.User WHERE t2.User = :data1;");    
    $stmt->bindParam(':data1', $usuario);
    $stmt->execute();
    $count =  $stmt->rowCount();
    $true = "true";
    $false = "false";
    $this->close_conecction();
    if($count==1){
        return $false;
    }
    
    if($count==0){
        return $true;
    }
    }
    
    function verifica_NickEnUso(){
    $nickname = $this->getNickname();
    $this->open_UserConecction();
    $stmt = $this->prepare("SELECT * FROM sitio.users WHERE user_nickname = :data1;");    
    $stmt->bindParam(':data1', $nickname);
    $stmt->execute();
    $count =  $stmt->rowCount();
    $this->close_conecction();
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
        $username = $this->getUsername();
        $pass = $this->getPass();
        $this->open_conecction($username, $pass);
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
            $_SESSION['isAdmin'] = $result->isAdmin;
       }else{
            // Si la clave es incorrecta
                $url="http://localhost/modular/sn10/login.php";
                $comando = "<script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'1000'.");</script>";
                echo ($comando);
        }

    }

    
     public function getUsers($start, $per_page){
        $this->open_UserConecction();
        $cont=0;    
        $stmt = $this->prepare("SELECT ID, username, user_nickname, user_registertime, user_status, isAdmin
                                FROM users LIMIT $start,$per_page");
        $stmt->execute();
        $usuarios=array();     
         while($fila = $stmt->fetch()){
               $usuario = new User($fila['ID'],$fila['username'],null,$fila['user_nickname'],$fila['user_registertime'],
               $fila['user_status'],null,null, $fila['isAdmin']);
               $usuarios[$cont]=$usuario;
               $cont++;
            }
 
         $this->close_conecction();
         return $usuarios;            
        }
        
        public function getUsersTPass($where){
        $id = $where;
        $this->open_UserConecction();
        $cont=0;    
        $stmt = $this->prepare("SELECT ID,user_nickname
                                FROM users WHERE ID!= :data1");
        $stmt->bindValue(':data1', $id);
        $stmt->execute();
        $usuarios=array();     
         while($fila = $stmt->fetch()){
               $usuario = new User($fila['ID'],null,null,$fila['user_nickname'],null,
               null,null,null,null);
               $usuarios[$cont]=$usuario;
               $cont++;
            }
         $this->close_conecction();
         return $usuarios;            
        }

        
        public function getAllUsersPagination($per_page){
        $this->open_UserConecction();
        $stmt = $this->prepare("SELECT * FROM users");
        $stmt->execute();
        $count = $stmt->rowCount();
        $this->close_conecction();
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
        $isAdmin = $this->getAdmin();
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
        
        if($isAdmin == 1){
         $stmt = $this->prepare("GRANT ALL PRIVILEGES ON *.* TO :data1@'localhost' WITH GRANT OPTION;");  
        $stmt->bindValue(':data1', $username);
        $stmt->execute();
          if ($stmt->errorCode()) {
               $arr = $stmt->errorInfo();
               if ($arr[0]!='00000'){
        $stmt = $this->prepare("DROP USER :data1@'localhost';"); //Si no pudo dar privilegios el usuario se borra automaticamente.
        $stmt->bindValue(':data1', $username);
        $stmt->execute();
        throw new Exception($arr[2]);     
                } 
                                   }    
        }else{
               
        if($tnoticias!=''){
        $stmt = $this->prepare("GRANT ".$tnoticias." ON sitio.news TO :data1@'localhost';");  
        $stmt->bindValue(':data1', $username);
        $stmt->execute();
          if ($stmt->errorCode()) {
               $arr = $stmt->errorInfo();
               if ($arr[0]!='00000'){
        $stmt = $this->prepare("DROP USER :data1@'localhost';"); //Si no pudo dar privilegios el usuario se borra automaticamente.
        $stmt->bindValue(':data1', $username);
        $stmt->execute();
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
        $stmt = $this->prepare("DROP USER :data1@'localhost';"); //Si no pudo dar privilegios el usuario se borra automaticamente.
        $stmt->bindValue(':data1', $username);
        $stmt->execute();          
        throw new Exception($arr[2]);     
                } 
                                   }
        }
        
        $stmt = $this->prepare("GRANT SELECT ON mysql.user TO :data1@'localhost';");  
        $stmt->bindParam(':data1', $username);
        $stmt->execute();
          if ($stmt->errorCode()) {
               $arr = $stmt->errorInfo();
               if ($arr[0]!='00000'){
        $stmt = $this->prepare("DROP USER :data1@'localhost';"); //Si no pudo dar privilegios el usuario se borra automaticamente.
        $stmt->bindValue(':data1', $username);
        $stmt->execute();          
        throw new Exception($arr[2]);     
                } 
                                   }
                                   
        $stmt = $this->prepare("GRANT SELECT ON sitio.users TO :data1@'localhost';");  
        $stmt->bindParam(':data1', $username);
        $stmt->execute();
          if ($stmt->errorCode()) {
               $arr = $stmt->errorInfo();
               if ($arr[0]!='00000'){
        $stmt = $this->prepare("DROP USER :data1@'localhost';"); //Si no pudo dar privilegios el usuario se borra automaticamente.
        $stmt->bindValue(':data1', $username);
        $stmt->execute();          
        throw new Exception($arr[2]);     
                } 
                                   } 
                                   
        
        
          }
        $stmt = $this->prepare("INSERT INTO sitio.users(username,user_nickname,user_registertime,user_status,users_ID,isAdmin) VALUES(:data1, :data2, :data3, :data4, :data5, :data6);");
        $stmt->bindParam(':data1', $username);
        $stmt->bindParam(':data2', $nickname);
        $stmt->bindParam(':data3', $registertime);
        $stmt->bindParam(':data4', $status);
        $stmt->bindParam(':data5', $_SESSION['user_id']);
        $stmt->bindParam(':data6', $isAdmin, PDO::PARAM_INT);
        $stmt->execute();
          if ($stmt->errorCode()) {
               $arr = $stmt->errorInfo();
               if ($arr[0]!='00000'){
        $stmt = $this->prepare("DROP USER :data1@'localhost';"); //Si no pudo crear usuario en BD sitio, se borra de mysql el usuario
        $stmt->bindValue(':data1', $username);
        $stmt->execute();                     
        throw new Exception($arr[2]);     
                }else{
                    return true;
                }
                                   }  
        /* $this->exec("CREATE USER 'admin'@'localhost';") or die(print_r($this->errorInfo(),true));*/
        }catch(Exception $e){
             $this->close_conecction();
             echo $e->getMessage()."\n";
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
