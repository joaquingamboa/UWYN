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
    
    
    function editUserById(){ 
    try{   
    $this->open_conecction();
    $this->beginTransaction();
    $id = $this->getId();
    $username = $this->getUsername();
    $status = $this->getStatus();
    $tnoticias = explode(',', $this->getTnoticias());
    $tpaginas = explode(',', $this->getTpaginas());
    $isAdmin = $this->getAdmin();
        $stmt = $this->prepare("UPDATE SITIO.users set user_status = :data1, isAdmin = :data2 WHERE ID=:data3;");  
        $stmt->bindValue(':data1', $status, PDO::PARAM_INT);
        $stmt->bindValue(':data2', $isAdmin, PDO::PARAM_INT);
        $stmt->bindValue(':data3', $id, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->errorCode()) {
               $arr = $stmt->errorInfo();
               if ($arr[0]!='00000'){   
                    throw new Exception($arr[2]);     
                } 
                                   }
        $stmt = $this->prepare("DELETE FROM users_privileges WHERE user_ID = :data1;");
        $stmt->bindValue(':data1', $id);
        $stmt->execute();
                if ($stmt->errorCode()) {
                        $arr = $stmt->errorInfo();
                        if ($arr[0]!='00000'){   
                             throw new Exception($arr[2]);     
                         } 
                                   }
                                   
       if($isAdmin != 1){
            if (count($tnoticias)>0 && $tnoticias[0] != ''){            
        for($i=0;$i<count($tnoticias);$i++){    
        $stmt = $this->prepare("INSERT INTO users_privileges VALUES(:data1,:data2,:data3);");
        $stmt->bindParam(':data1', $id, PDO::PARAM_INT);
        $stmt->bindValue(':data2', $tnoticias[$i]);
        $stmt->bindValue(':data3','NEWS');
        $stmt->execute();
                 if ($stmt->errorCode()) {
                        $arr = $stmt->errorInfo();
                            if ($arr[0]!='00000'){           
                                 throw new Exception($arr[2]);     
                             }
                       }
         }
                   }
         
         
        if (count($tpaginas)>0 && $tpaginas[0] != ''){              
        for($i=0;$i<count($tpaginas);$i++){    
        $stmt = $this->prepare("INSERT INTO users_privileges VALUES(:data1,:data2,:data3);");
        $stmt->bindParam(':data1', $id, PDO::PARAM_INT);
        $stmt->bindValue(':data2', $tpaginas[$i]);
        $stmt->bindValue(':data3','PAGES');
        $stmt->execute();
                  if ($stmt->errorCode()) {
                        $arr = $stmt->errorInfo();
                            if ($arr[0]!='00000'){           
                                 throw new Exception($arr[2]);     
                                                   }
                                            }
                                        }  
                                    }
                      }
        $this->commit();
        $this->close_conecction();
        return true;  
        }catch(Exception $e){
             $this->rollBack();
             $this->close_conecction();
             echo $e->getMessage()."\n";
                                 }                  
    }
    
    
    
    
    function getInfoTEdit(){
    try{        
        $this->open_conecction();
        $id = $this->getId();
        $stmt = $this->prepare("SELECT * FROM users WHERE ID = :data1;");
        $stmt->bindParam(':data1', $id);
        $stmt->execute();
        $count =  $stmt->rowCount();
        $result = $stmt->fetchObject();
           if ($count==1) {     
              $this->setNickname($result->user_nickname);
              $this->setAdmin($result->isAdmin);
              $this->setStatus($result->user_status);
              $this->setUsername($result->username);
            if($this->getUsername()=='admin'){
                    $UPATH = "http://".$_SERVER['HTTP_HOST'];
                    $url = "$UPATH/sn10/index.php?page=usuarios";
                    $comando = "<script>alert(\"El usuario ADMIN no puede ser Editado\");</script><script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'1000'.");</script>";
                    throw new Exception($comando);       
                                              }else{
        $stmt = $this->prepare("SELECT privilege FROM users_privileges WHERE user_ID = :data1 AND Object='NEWS';");
        $stmt->bindValue(':data1', $id);
        $stmt->execute();
        $cont = 0;
        $rsp=array();     
         while($tnoticias = $stmt->fetchObject()){
               $rsp[$cont] = $tnoticias->privilege;
               $cont++;
            }
        $this->setTnoticias($rsp);      
                 
        $stmt = $this->prepare("SELECT privilege FROM users_privileges WHERE user_ID = :data1 AND Object='PAGES';");
        $stmt->bindValue(':data1', $id);
        $stmt->execute();
        $cont = 0;
        $rsp2=array();     
         while($tpaginas = $stmt->fetchObject()){
               $rsp2[$cont] = $tpaginas->privilege;
               $cont++;
            }
        $this->setTpaginas($rsp2);   
        $this->close_conecction();
        }  
                                           
           }else{    
                    $UPATH = "http://".$_SERVER['HTTP_HOST'];
                    $url = "$UPATH/sn10/index.php?page=usuarios";
                    $comando = "<script>alert('Error al tratar de editar el Usuario');</script><script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'1000'.");</script>";
                    throw new Exception($comando);
            } 
                }catch(Exception $e){
                  echo $e->getMessage();  
                }
    }
    
    function verificarRelacionAEliminar(){
    $iduser = $this->getId();
    $username = $this->getUsername();
    try{
    if($username == 'admin'){
      $UPATH = "http://".$_SERVER['HTTP_HOST'];
      $url = "$UPATH/sn10/index.php?page=usuarios";
       $comando = "<script>alert(\"El usuario no puede ser Eliminado\");</script><script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'1000'.");</script>";
       throw new Exception($comando);     
                            }        
    if($_SESSION['isAdmin']==1){
    $this->open_conecction();
    $stmt = $this->prepare("SELECT * FROM users WHERE ID = :data1;");
    $stmt->bindValue(':data1', $iduser);
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
    $this->close_conecction();                                 
    if($contador1 >= 1 || $contador2 >= 1 || $contador3 >= 1 || $contador4 >= 1){
    $UPATH = "http://".$_SERVER['HTTP_HOST'];
    $url = "$UPATH/sn10/index.php?page=pasarAUser&IdAElim=$iduser&username=$username";    
    $comando = "<script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'1000'.");</script>";    
    echo $comando;   
    }else{
      $this->borrarUsuarioPorId(NULL);
    }
    
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
       $url="/sn10/index.php?page=usuarios";
       $comando = "<script>alert(\"El usuario no puede ser Eliminado\");</script><script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'1000'.");</script>";
       throw new Exception($comando);    
                            }                                                                
    $this->open_conecction();
    $this->beginTransaction();
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
    $stmt = $this->prepare("DELETE FROM users_privileges WHERE user_ID = :data1");
    $stmt->bindValue(':data1', $iduser);
    $stmt->execute(); 
          if ($stmt->errorCode()) {
               $arr = $stmt->errorInfo();
                 if ($arr[0]!='00000'){
                        throw new Exception($arr[2]);     
                                       } 
                                    }
    $stmt = $this->prepare("DELETE FROM users WHERE ID = :data1");
    $stmt->bindValue(':data1', $iduser);
    $stmt->execute(); 
          if ($stmt->errorCode()) {
               $arr = $stmt->errorInfo();
                 if ($arr[0]!='00000'){
                        throw new Exception($arr[2]);     
                                       } 
                                    }
      $this->commit();
      $this->close_conecction();
      $UPATH = "http://".$_SERVER['HTTP_HOST'];
      $url="$UPATH/sn10/index.php?page=usuarios";
      $comando = "<script>alert(\"El usuario Fue Eliminado\");</script><script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'1000'.");</script>";                            
      echo $comando;  
            }catch(Exception $e){
               $rsp = $e->getMessage();
               $this->rollBack();
               $this->close_conecction();
               $UPATH = "http://".$_SERVER['HTTP_HOST'];
               $url="$UPATH/sn10/index.php?page=usuarios";
               $comando = "<script>alert(\"$rsp\");</script><script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'1000'.");</script>";                            
               echo $comando;
                                 }     
      }
   
    
    
    function verifica_UserEnUso(){
    $usuario = $this->getUsername();
    $this->open_conecction();
    $stmt = $this->prepare("SELECT * FROM users WHERE username = :data1;");    
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
    $this->open_conecction();
    $stmt = $this->prepare("SELECT * FROM users WHERE user_nickname = :data1;");    
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
                $url="index.php?page=index";
                $comando = "<script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'1000'.");</script>";
                echo ($comando);
                }else{
                        // Si no hay sesion regresa al login
                header( "Location: index.php" );
                    }
   
            //Si email o pass tienen algo verifica el usuario     
            }else{
                $this->verifica_usuario($tiempo, $username, $pass);
            }
        }   
        
    //  Verifica login
    private function verifica_usuario($tiempo, $usuario, $clave) {  
        $stmt = $this->prepare("SELECT * FROM users WHERE username = :data1 AND user_password = :data2 AND user_status=1;");
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
            $_SESSION['isAdmin'] = $result->isAdmin;
       }else{
            // Si la clave es incorrecta
                $url="login.php";
                $comando = "<script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'1000'.");</script>";
                echo ($comando);
        }

    }

    
     public function getUsers($start, $per_page){
        $this->open_conecction();
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
        $this->open_conecction();
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
        $this->open_conecction();
        $stmt = $this->prepare("SELECT * FROM users");
        $stmt->execute();
        $count = $stmt->rowCount();
        $this->close_conecction();
        return ceil($count/$per_page);
        }

        public function addUser(){
        try{  
        $this->open_conecction();  
        $this->beginTransaction();
        $rsp = $this->verificarPrivilegio('INSERT', 'NEWS');
        if ($rsp === false){
         throw new Exception('No tiene privilegios para realizar esta accion');         
        }
        $tnoticias = explode(',', $this->getTnoticias());
        $tpaginas = explode(',', $this->getTpaginas());
        $username = $this->getUsername();
        $password = $this->getPass();
        $nickname = $this->getNickname();
        $status = $this->getStatus();
        $registertime = $this->getRegistertime();
        $isAdmin = $this->getAdmin();  
        $stmt = $this->prepare("INSERT INTO sitio.users(username,user_nickname,user_registertime,user_status,users_ID,isAdmin,user_password) VALUES(:data1, :data2, :data3, :data4, :data5, :data6, :data7);");
        $stmt->bindParam(':data1', $username);
        $stmt->bindParam(':data2', $nickname);
        $stmt->bindParam(':data3', $registertime);
        $stmt->bindParam(':data4', $status);
        $stmt->bindParam(':data5', $_SESSION['user_id']);
        $stmt->bindParam(':data6', $isAdmin, PDO::PARAM_INT);
        $stmt->bindParam(':data7', $password);
        $stmt->execute();
        $uid = $this->lastInsertId();
        if ($stmt->errorCode()) {
               $arr = $stmt->errorInfo();
               if ($arr[0]!='00000'){           
        throw new Exception($arr[2]);     
                }
          }

        if($isAdmin != 1){
            if (count($tnoticias)>0 && $tnoticias[0] != ''){            
        for($i=0;$i<count($tnoticias);$i++){    
        $stmt = $this->prepare("INSERT INTO users_privileges VALUES(:data1,:data2,:data3);");
        $stmt->bindParam(':data1', $uid, PDO::PARAM_INT);
        $stmt->bindValue(':data2', $tnoticias[$i]);
        $stmt->bindValue(':data3','NEWS');
        $stmt->execute();
                 if ($stmt->errorCode()) {
                        $arr = $stmt->errorInfo();
                            if ($arr[0]!='00000'){           
                                 throw new Exception($arr[2]);     
                             }
                       }
         }
                   }
         
         
        if (count($tpaginas)>0 && $tpaginas[0] != ''){              
        for($i=0;$i<count($tpaginas);$i++){    
        $stmt = $this->prepare("INSERT INTO users_privileges VALUES(:data1,:data2,:data3);");
        $stmt->bindParam(':data1', $uid, PDO::PARAM_INT);
        $stmt->bindValue(':data2', $tpaginas[$i]);
        $stmt->bindValue(':data3','PAGES');
        $stmt->execute();
                  if ($stmt->errorCode()) {
                        $arr = $stmt->errorInfo();
                            if ($arr[0]!='00000'){           
                                 throw new Exception($arr[2]);     
                                                   }
                                            }
                                        }  
                                    }
                      }
        $this->commit();
        $this->close_conecction();
        return true;  
        }catch(Exception $e){
             $this->rollBack();
             $this->close_conecction();
             echo $e->getMessage()."\n";
                            }
        }
        
        private function verificarPrivilegio($privilegio,$tabla){
        $uid = $_SESSION['user_id'];
        $stmt = $this->prepare("SELECT isAdmin FROM users WHERE ID = :data1;");
        $stmt->bindValue(':data1', $uid);
        $stmt->execute();
        $result = $stmt->fetchObject();
        $isAdmin = $result->isAdmin;
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
        

}

?>
