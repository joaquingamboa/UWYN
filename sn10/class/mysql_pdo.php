<?php
require_once('conexion.php');

  class DB {

    private $db;
    private $sql='';
    public  $debug=true;
    private $replace=array();
       
    // initialize connection
    function __construct(){
        try {
            $dsn="mysql:dbname=".DB_NAME.";host=".DB_HOST;
            $this->db = new PDO($dsn, DB_USER, DB_PASS);
        }
 catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }

    }

    
  /*  function open_conecction(){
        try {
            $dsn="mysql:dbname=".DB_NAME.";host=".DB_HOST;
            $this->db = new PDO($dsn, DB_USER, DB_PASS);
        }
 catch (PDOException $e ) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }

     }
*/
    
    function __destruct() {
        $this->db = null;
    }

    public function getdb(){
        return $this->db;
    }

   
    private function build_where($where){
        if(!empty($where)){       
            $this->sql.=" WHERE ";
            $c=count($this->replace);
            foreach($where as $key=>$w){
                // look for any comparitive symbols within the where array value.
                if(substr($w,0,1)=='%'){
                    // prep the query for PDO->prepare
                    $this->sql.=$key.'=%:'.$c.'% && ';
                    $this->replace[':'.$c]=$w;
                }

                else{
                    if(substr($w,0,2)=='<=')
                        $eq='<=';
                    elseif(substr($w,0,2)=='>=')
                        $eq='>=';
                    elseif(substr($w,0,1)=='>')
                        $eq='>';
                    elseif(substr($w,0,1)=='<')
                        $eq='<';
                    elseif(substr($w,0,1)=='!')
                        $eq='!=';
                    else
                        $eq='=';
                   
                    // prep the query for PDO->prepare
                    $this->sql.=$key.$eq."'".$w."'".' && ';
                    $this->replace[':'.$c]=$w;
                }

                $c++;
            }

            $this->sql=substr($this->sql,0,-4);
        }

    }

   
    // remove slashes from all retrieved variables
    private function prep_vars($vars){
    	$ret="";
        if(is_array($vars)){
            foreach($vars as $key=>$value)
                $ret[$key]=prep_vars($value);
        }

        elseif(is_object($vars)){
            foreach($vars as $key=>$value)
                $ret->$key=prep_vars($value);
        }

        elseif(is_string($vars)){
            $ret=stripslashes($vars);
        }

        else{
            $ret=$vars;
        }

        return $ret;
    }

   
    // general query function
    function query($query,$vals=''){
        $sth=$this->db->prepare($query);
        if($vals)
        $sth->execute($vals);
        else
        $sth->execute();
        $result=$sth->fetchAll(PDO::FETCH_OBJ);
        $e=$sth->errorInfo();
        if($e[0]!='00000'){
            if($this->debug){
                if($e[2])
                    echo '<strong>ERROR:</strong>: '.$e[2];
                else
                    echo '<strong>ERROR:</strong>: General Error';
            }

        }

        if($this->debug)
            $this->_get_query($query,$vals,$e);
        return $this->prep_vars($result);
    }

   
    //select and return only one row
    function select_one($table,$vals='*',$where=array(),$extra=''){
        $s=$this->select($table,$vals,$where);
        return $s[0];
    }

   
    // select function
    function select($table,$vals='*',$where=array(),$extra=''){
        // initialize the sql query
        $this->replace=array();
        $this->sql="SELECT ";
       
        // add all the values to be selected
        if(is_array($vals)){
            foreach($vals as $v)
                $this->sql.=$v.',';
            $this->sql=substr($this->sql,0,-1);
        }

        else
            $this->sql.=$vals;
       
        $this->sql.=' FROM '.$table;
       
        // build the WHERE portion of the query
        $this->build_where($where);
       
        $this->sql.' '.$extra;
        $ret=$this->query($this->sql,$this->replace);
        return $ret;
    }

   
    // insert
    function insert($table,$vals){
        // empty the replace array
        $this->replace=array();
       
        $this->sql="INSERT INTO ".$table." SET ";
       
        // build the replace array and the query
        $c=count($this->replace);
        foreach($vals as $key=>$v){
            $this->sql.=$key.'=:'.$c.', ';
            $this->replace[':'.$c]=$v;
            $c++;
        }

        $this->sql=substr($this->sql,0,-2);
        // run and return the query
        $ret=$this->query($this->sql,$this->replace);
        $id=$this->db->lastInsertId();
       
        if($id)
        	return $id;
        else
        	return $ret;
		
              
    }

   
    // update
    function update($table,$vals,$where=array()){
        // empty the replace array
        $this->replace=array();
       
        $this->sql="UPDATE ".$table." SET ";
       
        // build the replace array and the query
        $c=count($this->replace);
        foreach($vals as $key=>$v){
            $this->sql.=$key.'=:'.$c.', ';
            $this->replace[':'.$c]=$v;
            $c++;
        }

        $this->sql=substr($this->sql,0,-2);
       
        // build the WHERE portion of the query
        $this->build_where($where);
       
        // run and return the query
        return $this->query($this->sql,$this->replace);
    }

    
    function update_ConFechas($table,$vals,$where=array()){
        // empty the replace array
        $this->replace=array();
       
        $this->sql="UPDATE ".$table." SET ";
       
        // build the replace array and the query
        $c=count($this->replace);
        foreach($vals as $key=>$v){
            $this->sql.=$key.'=:'.$c.', ';
            $this->replace[':'.$c]=$v;
            $c++;
        }

        $this->sql=substr($this->sql,0,-2);
       
        // build the WHERE portion of the query
        $this->build_where($where);
       
        // run and return the query
        return $this->query($this->sql,$this->replace);
    }

    
    function delete($table,$where){
        // empty the replace array
        $this->replace=array();
       
        $this->sql="DELETE FROM ".$table;
       
        // build the WHERE portion of the query
        $this->build_where($where);
       
        // run and return the query
        return $this->query($this->sql,$this->replace);
    }

   
    // get the number of records matching the requirements
    function get_count($table,$where=false){
       
        // start query
        $this->sql="SELECT COUNT(*) FROM ".$table;
       
        // build the WHERE portion of the query
        if($where)
            $this->build_where($where);
       
        // run and return the query
        $sth=$this->db->prepare($this->sql);
        
        $sth->execute();
       
        // return the row count
        return $sth->fetch(PDO::FETCH_NUM);
    }

    
    function select_count($table,$where){
        $this->sql="SELECT count(*) FROM ".$table;
        $this->build_where($where);
        return $this->sql;
        /*$sth = $this->db->prepare($sql);
        $sth->execute(array($key));
        $rows = $sth->fetch(PDO::FETCH_NUM);*/
        
    }

   
    // gets value of requested column
    function get_value($table,$val,$where=array()){
        // run query
        $o=$this->select($table,$val,$where);
       
        // convert first object in associative array to array
        $v=get_object_vars($o[0]);
       
        // return requested value
        return $v[$val];
    }

   
    //debugging function
    private function _get_query($query,$val,$er=0){
        echo '<p>';
        foreach($val as $key=>$value)
            $query=str_replace($key,"'".$value."'",$query);
        echo '<strong>QUERY:</strong><br />'.$query;
        if($er){
            echo '<br /><br /><strong>Raw error:</strong><pre>';
            print_r($er);
            echo '</pre>';
        }

        echo '</p><hr />';
    }

}

?>

