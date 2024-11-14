<?php

$nameServer = 'localhost';

$user = 'root';

$pass  = '';

$database = 'dh_commerce';


try{
    $conn = new PDO("mysql:host=$nameServer;dbname=$database",$user,$pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo "Conexão falhou : ".$e->getMessage();
}