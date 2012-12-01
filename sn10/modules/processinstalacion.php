<?php
function instalar(){
    $path = $_POST['path'];
    $ubd = $_POST['userbd'];
    $cbd = $_POST['contrabd'];
    $passadmin = md5($_POST['passadmin']);
    $nickname = $_POST['nickname'];
     try{
            $dsn="mysql:dbname=mysql;host=localhost";
            $bd = new PDO($dsn, $ubd, $cbd); 
        }catch (PDOException $e ) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
                             }
        try{
        $sql = explode(";",file_get_contents('../script.sql'));
        foreach($sql as $query){
        $stmt = $bd->prepare($query);
        $stmt->execute();
        }                                            
        date_default_timezone_set('Chile/Continental');
        $fechaCreacion=date("Y-m-d H:i:s");                    
        $stmt = $bd->prepare("INSERT INTO users(username,user_password,user_nickname,user_registertime,user_status,isAdmin) VALUES(:data1, :data2, :data3, :data4, :data5, :data6);");
        $stmt->bindValue(':data1', 'admin');
        $stmt->bindValue(':data2', $passadmin);
        $stmt->bindValue(':data3', $nickname);
        $stmt->bindValue(':data4', $fechaCreacion);
        $stmt->bindValue(':data5', '1',PDO::PARAM_INT);
        $stmt->bindValue(':data6', '1', PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->errorCode()) {
               $arr = $stmt->errorInfo();
               if ($arr[0]!='00000'){           
        throw new Exception(2);     
                }
          }  
          $fp = fopen("../class/conexion.php","w");
fwrite($fp, "<?php
define('DB_HOST','localhost');
define('DB_USER', '$ubd');
define('DB_PASS','$cbd');
define('DB_NAME','uwyn');
define('UPATH', '$path');
?>" . PHP_EOL);
fclose($fp);   
sleep(1);
$rsp1 = rename ("../index.php", "../instalacion.usada");
sleep(1);
$rsp2 = rename ("../index2.php", "../index.php");
sleep(1);

if($rsp1 === false){
throw new Exception("ERROR AL RENOMBRAR");   
}

if($rsp2 === false){
rename ("../instalacion.usada", "../index.php");
throw new Exception("ERROR AL RENOMBRAR");
}


echo 1;
        }catch(Exception $e){
          echo $e->getMessage();
          
        }
          
}

if($_POST){
        switch($_POST["tarea"]){
                case "instalar":instalar();
                break;		
        }
    }
?>
