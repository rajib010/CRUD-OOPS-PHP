<?php
include "database.php";
$db = new Database();
$db->insert('information', $_POST);
