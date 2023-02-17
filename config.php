<?php

  try {
    $hostname = "localhost";
    $port = 1433;
    $dbname = "avaliacao_rai_v2";
    $username = "root";
    $pw = "";
    //$pdo = new PDO("sqlsrv:server={$hostname};Database={$dbname}", "$username", "$pw");
    $pdo = new PDO("mysql:dbname={$dbname};host={$hostname}", "{$username}", "{$pw}");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
    //$dbh = new PDO ("dblib:host=$hostname:$port;dbname=$dbname","$username","$pw");
} catch (PDOException $e) {
     echo "Drivers disponiveis: " . implode( ",", PDO::getAvailableDrivers() );
     die ("Erro na conexao com o banco de dados: ".$e->getMessage());
}
