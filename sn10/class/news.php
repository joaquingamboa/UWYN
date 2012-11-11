<?php
require('conexion.php');
class News extends PDO{
	protected $id;
	public $author;
	public $title;
	public $url;
	public $content;
	public $datef;
	public $modified;
	public $description;
	public $status;
	public $img;
	public $usermod;
    public $nombre_author;
    public $nombre_usermod;
    private $db;
        
        
        
     public function __construct($id,$author,$title,$url,$content,$datef,$modified,$description,$status,$img,$usermod,$nombre_author,$nombre_usermod) {
           	$this->id=$id;
                $this->author=$author;
		$this->title=$title;
		$this->url=$url;
		$this->content=$content;
                $this->datef=$datef;
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
        }
 catch (PDOException $e ) {
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

		
		public function getDatef(){
			return $this->datef;
		}

		
		public function setDatef($value){
			$this->datef=$value;
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
            $this->open_conecction();
            $stmt = $this->prepare('INSERT INTO news (news_author, news_title, news_url, news_content, news_date, news_modified,
                                    news_description, news_usermodified, news_status, url_image)
                                    VALUES(:author, :title, :url, :content, :date, :modified, :description, :usermodified, :status, :image)');       
			$options=array(
            ":author"=>$this->getAuthor(),
            ":title"=>$this->getTitle(),
            ":url"=>$this->getUrl(),
            ":content"=>$this->getContent(),
            ":date"=>$this->getDatef(),
            ":modified"=>$this->getmodified(),
            ":description"=>$this->getDescription(),
            ":usermodified"=>$this->getUserMod(),
            ":status"=>$this->getStatus(),
            ":image"=>$this->getImg()
                       );
			$stmt->execute($options);
			$id = $this->lastInsertId();
			$this->close_conecction();
			return $id;
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
        $cont=0;    
        $stmt = $this->prepare("SELECT t1.*, t2.user_nickname, t3.user_nickname as user_modificador 
                                FROM news t1 INNER JOIN users t2 ON t1.news_author = t2.ID 
                                INNER JOIN users t3 ON t1.news_usermodified = t3.ID ORDER BY t1.news_date DESC LIMIT $start,$per_page");
        $stmt->execute();
        $noticias=array();     
         while($fila = $stmt->fetch()){
               $noticia = new News($fila['ID'],$fila['news_author'],$fila['news_title'],$fila['news_url'],
               $fila['news_content'],$fila['news_date'],$fila['news_modified'],$fila['news_description'],
               $fila['news_status'],$fila['url_image'],$fila['news_usermodified'],$fila['user_nickname'],$fila['user_modificador']);
               $noticias[$cont]=$noticia;
               $cont++;
            }
 
         $this->close_conecction();
         return $noticias;            
        }

        
        public function getAllNewsPagination($per_page){
        $this->open_conecction();
        $stmt = $this->prepare("SELECT * FROM news");
        $stmt->execute();
        $count = $stmt->rowCount();
        return ceil($count/$per_page);
        }

        
        public function getNewsById(){     
            $noticias=array();
            $cont=0;
            $this->open_conecction();
            $id = $this->getId();
            $stmt = $this->prepare('SELECT * from news WHERE ID = ? LIMIT 1');
            $stmt->execute(array($id));
            while($fila = $stmt->fetch()){
                $noticia = new News($fila['ID'],$fila['news_author'],$fila['news_title'],$fila['news_url'],
                $fila['news_content'],$fila['news_date'],$fila['news_modified'],$fila['news_description'],
                $fila['news_status'],$fila['url_image'],null,null,null);
                $noticias[$cont]=$noticia;
                $cont++;
            }
            $this->close_conecction();
            return $noticias;             
        }
 
        
        
        public function deleteNewsById(){
        $this->open_conecction();
        $id = $this->getId();
        $stmt = $this->prepare("DELETE FROM news WHERE ID = ?");
        $stmt->execute(array($id));
        $count = $stmt->rowCount();
        $this->close_conecction();
        return $count;
        }

        
        public function updateNewsById($firsturl){ 
        $this->open_conecction();
        $stmt = $this->prepare("UPDATE news SET news_title = :title, news_content = :content ,news_modified = :modified, 
                               news_date = :date, news_description = :description, news_status = :status, 
                                url_image = :image , news_usermodified = :usermodified, news_url = :url
                                WHERE news_url = :firsturl"); 
        $stmt->bindValue(':title', $this->getTitle(), PDO::PARAM_STR);
        $stmt->bindValue(':content', $this->getContent(), PDO::PARAM_STR);
        $stmt->bindValue(':date', $this->getDatef(), PDO::PARAM_STR);
        $stmt->bindValue(':modified', $this->getModified(), PDO::PARAM_STR);
        $stmt->bindValue(':description', $this->getDescription(), PDO::PARAM_STR);
        $stmt->bindValue(':status', $this->getStatus(), PDO::PARAM_INT);
        $stmt->bindValue(':image', $this->getImg(), PDO::PARAM_STR);
        $stmt->bindValue(':usermodified', $this->getUserMod(), PDO::PARAM_INT);
        $stmt->bindValue(':url', $this->getUrl(), PDO::PARAM_STR);
        $stmt->bindValue(':firsturl', $firsturl, PDO::PARAM_STR);
        $stmt->execute();
        $arr = $stmt->errorInfo();
        print_r($arr);    
        }

	/************************ FUNCIONES ***********************************/
		
		
		
	
	
	
	
	
}


	
?>