<?php
$servername ="sql102.infinityfree.com";
$username = "if0_38917778";
$password ="Z11MLpoFskZbNuI";
$dbname = "if0_38917778_azul";
$conn = new mysqli($servername,$username, $password, $dbname);
if ($conn->connect_error){
    die("Conexión fallida:".$conn->connect_error);

}
?>