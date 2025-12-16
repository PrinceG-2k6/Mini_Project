<?php
$host = "localhost"; 
$username = "root"; 
$password =NULL;
$database = "SeatingPlan";

try{
    $conn = new PDO("mysql:host=$host;dbname=$database",$username,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connect done";
}catch(PDOException $err){
    echo "connect failed" .$err->getMessage();
}

?>