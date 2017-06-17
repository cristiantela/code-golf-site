<?php

function getUserByUsernameAndPassword ($link, $username, $password) {
	$get = $link->prepare('
		SELECT user FROM credential
		WHERE
			username = :username AND
			password = :password
	');

	$result = $get->execute([
		'username' => $username,
		'password' => $password,
	]);

	if (!$result) {
		echo json_encode([
			'error' => 'Não foi possível completar a verificação de nome de usuário e senha',
		]);
		exit();
	}

	if ($get->rowCount() === 0) {
		echo json_encode([
			'error' => 'Nome de usuário e senha não correspondem',
		]);
		exit();
	}

	return $get->fetch()['user'];
}

function Post () {
	$username = isset($_POST['username']) ? $_POST['username'] : '';
	$password = isset($_POST['password']) ? $_POST['password'] : '';
	$user = null;

	include 'util/link.php';
	$link = Lin();

	$user = getUserByUsernameAndPassword($link, $username, $password);

	include 'session/CreateSession.php';
	CreateSession($link, $user);
}