<?php
require_once "bd.php";



$query = $db->query("SELECT * FROM products ORDER BY id DESC");
echo $query;
echo "conexion buena";