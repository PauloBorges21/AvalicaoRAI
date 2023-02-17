<?php

//require_once "environment.php";

//if($_SERVER['SERVER_NAME'] == "localhost"){
//
//    $endereco = "http://localhost/apollo/";
//    $endereco_url = "http://localhost/apollo/";
//    $login_url = "http://localhost/apollo/";
//
//}elseif($_SERVER['SERVER_NAME'] == "10.0.0.14"){
//
//    $endereco = "https://deploy.rai.com.br/apollo/homologacao/apolloTYRES/";
//    $endereco_url = "https://deploy.rai.com.br/apollo/homologacao/";
//    $login_url = "https://deploy.rai.com.br/apollo/homologacao/";
//
//}else{
//
//    $endereco = "https://www.apollotyres.com.br/";
//    $endereco_url = "https://www.apollotyres.com.br/";
//    $login_url = "https://www.apollotyres.com.br/";
//}
//
//$config = array();
//
//if (ENVIRONMENT == 'development') {
//    define('URL_SITE', 'http://localhost/apollo/');
//    //$config['dbname'] = 'db_eucatex';
//    $config['dbname'] = 'db_apollo_tyres';
//    $config['host'] = 'localhost';
//    $config['dbuser'] = 'root';
//    $config['dbpass'] = '';
//} elseif (ENVIRONMENT == 'deploy') {
//    define("BASE_URL", "https://deploy.rai.com.br/");
//    $config['dbname'] = 'db_apollo_homolog';
//    $config['host'] = 'localhost';
//    $config['dbuser'] = 'root';
//    $config['dbpass'] = 'Suporte01';
//} else {
//    define("BASE_URL", "https://producao.com.br/");
//    $config['dbname'] = 'db_apollo_tyres';
//    $config['host'] = 'localhost';
//    $config['dbuser'] = 'root';
//    $config['dbpass'] = '';
//}

if($_SERVER['SERVER_NAME'] == "localhost"){

   $dbName = "db_apollo_tyres";
   $dbPass = "";

}elseif($_SERVER['SERVER_NAME'] == "10.0.0.14"){

    $dbName = "db_apollo_homolog";
    $dbPass = "Suporte01";

}else{

    $dbName = "db_apollo_tyres";
    $dbPass = "Suporte01";
}

try {
    $db = new stdClass;
    $db->driver = 'mysql';
    $db->host = 'localhost';
    $db->port = 3306;
    //$db->database = 'db_apollo_homolog';
    $db->database = $dbName;
    $db->username = 'root';
    //$db->password = 'Suporte01';
    $db->password = $dbPass;
    $db->unixSocket = '';
    $db->charset = 'utf8';
    $db->options = [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_PERSISTENT => true
    ];
    $db->dns = "mysql:dbname={$db->database};port={$db->port};host={$db->host}";
    $pdo = new PDO($db->dns, $db->username, $db->password, $db->options);
} catch (PDOException $e) {
    echo "ERRO: " . $e->getMessage();
    exit;
}


