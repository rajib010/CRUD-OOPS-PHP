<?php
include "database.php";
$db= new Database();

$db->select('information');
$result=$db->getResult();
$db->pagination('information');

echo "<table border='1'>";
foreach($result as list("id"=>$id,"Name"=>$name,"Address"=>$address,"Contact"=>$contact)){
    echo "$id-$name-$address-$contact \n";
}
echo "</table>";


?>