<?php

//assigning my database information
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','sitio');


/*
 * 
 $database->closeCursor();     <--- free results
 * 
 * 
//instantiate class
$database = new DB();

//select all rows in a table
$database->select('MyDatabaseTable');

//select based on criteria
$database->select('MyDatabaseTable','*',array('id'=>1));

//select certain values based on criteria
$database->select('MyDatabaseTable','name,id',array('id'=>1));

//select based on criteria with a set order
$database->select('MyDatabaseTable','*',array('id'=>1),'ORDER BY name ASC');

//select single row based on criteria
$database->select_one('MyDatabaseTable','*',array('id'=>1));

//insert into table; returns primary key of that row
$options=array(
    id=>1,
    name=>'test'
);
$database->insert('MyDatabaseTable',$options);

//update table
$options=array(
    name=>'test_again'
);
$database->update('MyDatabaseTable',$options,array('id'=>1));

//delete from table
$database->delete('MyDatabaseTable',array(id=>1));

//get a count of rows matching the criteria
$database->get_count('MyDatabaseTable',array(id=>1));

//select a single value from a table
$database->get_value('MyDatabaseTable','name',array('id'=>1));

//run your own query; NOT AS SECURE AS USING THE OTHER FUNCTIONS
$database->query("SELECT * FROM MyDatabaseTable WHERE id=1");

//debugging
$database->debug=true;
 * 
 */

?>
