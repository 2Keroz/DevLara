<?php 
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'devlara';

try{
    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $error){
    echo("Erreur : " . $error);
}
?>