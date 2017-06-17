<?php

error_reporting(0);

function Lin () {
	$config = parse_ini_file('access.ini');

	$driver = $config['driver'];
	$host = $config['host'];
	$name = $config['name'];
	$user = $config['user'];
	$pass = $config['pass'];

	$dns = "$driver:host=$host;dbname=$name;";

	try {
		$link = new PDO($dns, $user, $pass);
	} catch (PDOException $e) {
		echo json_encode([
			'error' => "Problema ao seu comunicar com o banco de dados"
		]);
		exit();
	}

	return $link;
}