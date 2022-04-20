<?php
require 'environment.php';

$config = array();
if(ENVIRONMENT == 'development') {
	define("BASE_URL", "http://localhost/contaazul/");
	$config['dbname'] = 'contaazul';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root';
	$config['dbpass'] = '';
} else {
	define("BASE_URL", "http://awregulagens.com.br/contaazul/");
	$config['dbname'] = 'contaazul';
	$config['host'] = '172.106.0.120';
	$config['dbuser'] = 'contaazul';
	$config['dbpass'] = 'N1e2c3a4contaazul';
}

global $db;
try {
	$db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'], $config['dbuser'], $config['dbpass']);
} catch(PDOException $e) {
	echo "ERRO: ".$e->getMessage();
	exit;
}