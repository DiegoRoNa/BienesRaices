<?php 

//CONECTAR A LA BD
require 'includes/config/database.php';
$db = conectarDB();

//Crear email y password
$email = 'correo@correo.com';
$password = '123456';

//HASHEAR LA PASSWORD
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

//CONSULTA
$query = "INSERT INTO usuarios (email, password) VALUES ('${email}', '${passwordHash}');";
mysqli_query($db, $query);
