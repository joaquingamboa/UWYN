<?php
require('mysql_pdo.php');

class News extends DB{
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
	$database = new DB();
	$options=array(
            "news_author"=>$this->getAuthor(),
            "news_title"=>$this->getTitle(),
            "news_url"=>$this->getUrl(),
            "news_content"=>$this->getContent(),
            "news_date"=>$this->getDatef(),
            "news_modified"=>$this->getmodified(),
            "news_description"=>$this->getDescription(),
            "news_usermodified"=>$this->getUserMod(),
            "news_status"=>$this->getStatus(),
            "url_image"=>$this->getImg()
                       );
	$dat = $database->insert('news',$options);
        $database = null;
	return $dat;
	}
        
        public function getUrlUse(){
        $url = $this->getUrl();
        $database = new DB();
        $dat = $database->get_count('news',array("news_url"=>$url));
        return $dat[0];
        }
        
        public function getNews(){
            $noticias=array();
            $cont=0;
            $conn = new DB();
            $conn = $conn->getdb();
            $stmt = $conn->prepare('SELECT t1.*, t2.user_nickname, t3.user_nickname as user_modificador FROM news t1 INNER JOIN users t2 ON t1.news_author = t2.ID INNER JOIN users t3 ON t1.news_usermodified = t3.ID');
            $stmt->execute();
            while($fila = $stmt->fetch()){
                $noticia = new News($fila['ID'],$fila['news_author'],$fila['news_title'],$fila['news_url'],
                $fila['news_content'],$fila['news_date'],$fila['news_modified'],$fila['news_description'],
                $fila['news_status'],$fila['url_image'],$fila['news_usermodified'],$fila['user_nickname'],$fila['user_modificador']);
                $noticias[$cont]=$noticia;
                $cont++;
            }     
             return $noticias;             
        }
        
        public function getNewsById(){
            $noticias=array();
            $cont=0;
            $conn = new DB();
            $id = $this->getId();
            $conn = $conn->getdb();
            $stmt = $conn->prepare('SELECT * from news WHERE ID = ? LIMIT 1');
            $stmt->execute(array($id));
            while($fila = $stmt->fetch()){
                $noticia = new News($fila['ID'],$fila['news_author'],$fila['news_title'],$fila['news_url'],
                $fila['news_content'],$fila['news_date'],$fila['news_modified'],$fila['news_description'],
                $fila['news_status'],$fila['url_image'],null,null,null);
                $noticias[$cont]=$noticia;
                $cont++;
            }     
             return $noticias;             
        } 
        
        
        public function deleteNewsById(){
        $conn = new DB();
        $id = $this->getId();
        $conn = $conn->getdb();
        $stmt = $conn->prepare("DELETE FROM news WHERE ID = ?");
        $stmt->execute(array($id));
        $count = $stmt->rowCount();
        return $count;
        }
	/************************ FUNCIONES ***********************************/
		
		
		
	
	
	
	
	
}

	
?>