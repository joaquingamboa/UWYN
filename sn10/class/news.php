<?php
require('conexion.php');
class News extends PDO{
	protected $id;
	public $author;
	public $title;
	public $url;
	public $content;
	public $date;
	public $modified;
	public $description;
	public $status;
	public $img;
	public $usermod;
        public $nombre_author;
        public $nombre_usermod;
        private $db;
        
        
        
     public function __construct($id,$author,$title,$url,$content,$date,$modified,$description,$status,$img,$usermod,$nombre_author,$nombre_usermod) {
           	$this->id=$id;
                $this->author=$author;
		$this->title=$title;
		$this->url=$url;
		$this->content=$content;
                $this->date=$date;
                $this->modified=$modified;
		$this->description=$description;
		$this->img=$img;
                $this->status=$status;
                $this->usermod=$usermod;
                $this->nombre_author=$nombre_author;
                $this->nombre_usermod=$nombre_usermod;
                   
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
        
        function close_conecction(){
            $this->db==null;
        }

                                       
                
        public function getNuserMod(){
		return $this->nombre_usermod;
		}

		
	public function setNuserMod($value){
		$this->nombre_usermod=$value;
		}

                
	public function getNA(){
		return $this->nombre_author;
		}

		
	public function setNA($value){
		$this->nombre_author=$value;
		}

                
	
	public function getId(){
		return $this->id;
		}

		
	public function setId($value){
		$this->id=$value;
		}

		
	public function getAuthor(){
		return $this->author;
		}

		
	public function setAuthor($value){
		$this->author=$value;
		}

		
	public function getTitle(){
		return $this->title;
		}

		
	public function setTitle($value){
		$this->title=$value;
		}

		
	public function getUrl(){
		return $this->url;
		}

		
	public function setUrl($value){
		$this->url=$value;
		}

		
	public function getContent(){
		return $this->content;
		}

		
	public function setContent($value){
		$this->content=$value;
		}

		
	public function getDate(){
		return $this->date;
		}

		
	public function setDate($value){
		$this->date=$value;
		}

		
	public function getModified(){
		return $this->modified;
		}

		
	public function setModified($value){
		$this->modified=$value;
		}

		
	public function getDescription(){
		return $this->description;
		}

		
	public function setDescription($value){
		$this->description=$value;
		}

		
	public function getStatus(){
		return $this->status;
		}

		
	public function setStatus($value){
		$this->status=$value;
		}

		
	public function getImg(){
		return $this->img;
		}

		
	public function setImg($value){
		$this->img=$value;
		}

		
	public function getUserMod(){
		return $this->usermod;
		}

		
	public function setUserMod($value){
		$this->usermod=$value;
		}

                
		
	/************************ FUNCIONES ***********************************/
	public function addNews(){
            try{
            $this->open_conecction();
              $rsp = $this->verificarPrivilegio('Insert', 'NEWS'); 
                if($rsp === false){
                 $UPATH = "http://".$_SERVER['HTTP_HOST'];
              $url = "$UPATH/sn10/index.php?page=noticias";
              $comando = "No tienes privilegios para Insertar registros en la tabla noticias\n";  
              throw new Exception($comando); 
                }  
            $stmt = $this->prepare('INSERT INTO news (news_author, news_title, news_url, news_content, news_date, news_modified,
                                    news_description, news_usermodified, news_status, url_image)
                                    VALUES(:author, :title, :url, :content, :date, :modified, :description, :usermodified, :status, :image)');       
			$options=array(
            ":author"=>$this->getAuthor(),
            ":title"=>$this->getTitle(),
            ":url"=>$this->getUrl(),
            ":content"=>$this->getContent(),
            ":date"=>$this->getDate(),
            ":modified"=>$this->getmodified(),
            ":description"=>$this->getDescription(),
            ":usermodified"=>$this->getUserMod(),
            ":status"=>$this->getStatus(),
            ":image"=>$this->getImg()
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

        
        public function getUrlUse(){
        $url = $this->getUrl();
        $this->open_conecction();   
        $stmt = $this->prepare("SELECT COUNT(*) FROM news WHERE news_url = ?;");
        //$stmt->bindParam(':data1', $url);
        $stmt->execute(array($url));
        //$count =  $stmt->rowCount();
        $result = $stmt->fetchColumn();
        $this->close_conecction();
        return $result;
        }

        
        public function getNews($start, $per_page){
        $this->open_conecction();  
        try{         
        $rsp = $this->verificarPrivilegio('Select', 'NEWS'); 
        if($rsp === false){
          $comando = "No tienes privilegios para ver registros de la tabla noticias"; 
          throw new Exception($comando); 
        }  
        $cont=0;    
        $stmt = $this->prepare("SELECT t1.*, t2.user_nickname, t3.user_nickname as user_modificador 
                                FROM news t1 INNER JOIN users t2 ON t1.news_author = t2.ID 
                                INNER JOIN users t3 ON t1.news_usermodified = t3.ID ORDER BY t1.news_date DESC LIMIT $start,$per_page");
        $stmt->execute();
        $noticias=array();     
         while($fila = $stmt->fetch()){
               $noticia = new News($fila['news_id'],$fila['news_author'],$fila['news_title'],$fila['news_url'],
               $fila['news_content'],$fila['news_date'],$fila['news_modified'],$fila['news_description'],
               $fila['news_status'],$fila['url_image'],$fila['news_usermodified'],$fila['user_nickname'],$fila['user_modificador']);
               $noticias[$cont]=$noticia;
               $cont++;
            }
         $this->close_conecction();
         return $noticias;
               }catch (Exception $e){
                   $this->close_conecction();
                   echo $e->getMessage();
               }
        }

        
        public function getAllNewsPagination($per_page){
        $this->open_conecction();
        $stmt = $this->prepare("SELECT * FROM news");
        $stmt->execute();
        $count = $stmt->rowCount();
        return ceil($count/$per_page);
        }

        
        public function getNewsById(){ 
            try{ 
            $this->open_conecction();
            $rsp = $this->verificarPrivilegio('Update', 'NEWS');
            if($rsp === false){
             $UPATH = "http://".$_SERVER['HTTP_HOST'];
              $url = "$UPATH/sn10/index.php?page=noticias";
              $comando = "<script>alert(\"No tienes privilegios para Actualizar registros de la tabla noticias\");window.setTimeout('window.location=".chr(34).$url.chr(34).";',".'500'.");</script>";  
              throw new Exception("".$comando); 
            }  
            $noticias=array();
            $cont=0;
            $id = $this->getId();
            $stmt = $this->prepare('SELECT * from news WHERE news_id = ? LIMIT 1');
            $stmt->execute(array($id));
            while($fila = $stmt->fetch()){
                $noticia = new News($fila['news_id'],$fila['news_author'],$fila['news_title'],$fila['news_url'],
                $fila['news_content'],$fila['news_date'],$fila['news_modified'],$fila['news_description'],
                $fila['news_status'],$fila['url_image'],null,null,null);
                $noticias[$cont]=$noticia;
                $cont++;
            }
            $this->close_conecction();
            return $noticias;   
            }catch(Exception $e){
                echo $e->getMessage();
            }
        }
 
        
        
        public function deleteNewsById(){
        $this->open_conecction();
        try{
        $rsp = $this->verificarPrivilegio('Delete', 'NEWS');
        if($rsp === false){
          throw new Exception("<script>alert(\"No tienes privilegios para borrar registros de la tabla noticias.\");</script>"); 
        }   
        $id = $this->getId();
        $stmt = $this->prepare("DELETE FROM news WHERE news_id = ?");
        $stmt->execute(array($id));
        $count = array();
        $count[0] = $stmt->rowCount();
        if ($stmt->errorCode()) {
                        $arr = $stmt->errorInfo();
                            if ($arr[0]!='00000'){           
                                 throw new Exception($arr[2]);     
                             }
                       }            
        $this->close_conecction();
        return $count;
        }catch(Exception $e){
            $this->close_conecction();
            echo $e->getMessage();
        }
        }

        
        public function updateNewsById($firsturl){ 
        $this->open_conecction();
        $stmt = $this->prepare("UPDATE news SET news_title = :title, news_content = :content ,news_modified = :modified, 
                               news_date = :date, news_description = :description, news_status = :status, 
                                url_image = :image , news_usermodified = :usermodified, news_url = :url
                                WHERE news_url = :firsturl"); 
        $stmt->bindValue(':title', $this->getTitle(), PDO::PARAM_STR);
        $stmt->bindValue(':content', $this->getContent(), PDO::PARAM_STR);
        $stmt->bindValue(':date', $this->getDate(), PDO::PARAM_STR);
        $stmt->bindValue(':modified', $this->getModified(), PDO::PARAM_STR);
        $stmt->bindValue(':description', $this->getDescription(), PDO::PARAM_STR);
        $stmt->bindValue(':status', $this->getStatus(), PDO::PARAM_INT);
        $stmt->bindValue(':image', $this->getImg(), PDO::PARAM_STR);
        $stmt->bindValue(':usermodified', $this->getUserMod(), PDO::PARAM_INT);
        $stmt->bindValue(':url', $this->getUrl(), PDO::PARAM_STR);
        $stmt->bindValue(':firsturl', $firsturl, PDO::PARAM_STR);
        $stmt->execute();
        $count[0] = $stmt->rowCount();
        $count[1] = $stmt->errorInfo(); 
        $this->close_conecction();
        return $count;
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

	/************************ FUNCIONES ***********************************/	
	
}


	
?>