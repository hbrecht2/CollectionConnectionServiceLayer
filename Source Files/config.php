<?php
$url = parse_url(getenv("CLEARDB_DATABASE_URL")); 
 
$server = $url["host"]; 
$username = $url["user"]; 
$password = $url["pass"]; 
$db = substr($url["path"], 1); 
 
$db = new PDO('mysql:host=' . $server . ';dbname=' . $db . ';charset=utf8', $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


?>