<?php
require 'environment.php';

$config = array();

if(ENVIRONMENT == 'development'){
define("BASE_URL", "http://localhost/api/");	
$config['dbname'] = 'bd_api';
$config['host']   = 'localhost';
$config['dbuser'] = 'root';
$config['dbpass'] = '';

}else{
define("BASE_URL", "http://localhost/api/");	
$config['dbname'] = 'bd_api';
$config['host']   = 'localhost';
$config['dbuser'] = 'root';
$config['dbpass'] = '';
}

global $db;
try{
$db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'], $config['dbuser'], $config['dbpass']);
	//$db = new PDO('mysql:dbname=sofdev27_bd_api;host=localhost', 'sofdev27_george', 'Herois40@');
}catch(PDOException $e){
	echo "ERRO: ".$e->getMessage();
	exit;
}