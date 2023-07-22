<?php

include "database.php";
$db = new Database();
// insert info into the database
$result = $db->insert('information',['Name'=>'Ram','Address'=>'Ayodha','Contact'=>'1234']); 

//update records in the database
// $result= $db->update('information',['Name'=>'Ronaldhino','Address'=>'Rio','Contact'=>'30'],'id=3');

//delete from tables..
// $db->delete('information','id="3"');

//select from tables
$db->select('information');

//select data from databases...


?>
