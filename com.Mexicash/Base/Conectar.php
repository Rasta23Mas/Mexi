<?php
$db_host = 'localhost';
$db_name = 'u672450412_Mexicash';
$db_username = "u672450412_root";
$db_password = "12345";
$db = new mysqli($db_host, $db_username, $db_password, $db_name);

if($db->connect_error){
    die("Unable to connect database: " . $db->connect_error);
}
