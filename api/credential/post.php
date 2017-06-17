<?php

function getUserByActivationCode ($link, $activation_code) {
	$user = $link->prepare('
		SELECT id FROM user
		WHERE
			activation_code = :activation_code
	');

	$result = $user->execute([
		'activation_code' => $activation_code,
	]);

	if (!$result) {
		echo json_encode([
			'error' => 'Não foi possível verificar o código de ativação'
		]);
		exit();
	}

	if ($user->rowCount() === 0) {
		echo json_encode([
			'error' => 'Código de ativação não encontrado ou já foi usado'
		]);
		exit();
	}

	return $user->fetch()['id'];
}

function updateActivationCodeToNull ($link, $user) {
	$updateToNull = $link->prepare('
		UPDATE user
		SET
			activation_code = NULL
		WHERE
			id = :user
	');

	$result = $updateToNull->execute([
		'user' => $user,
	]);

	if (!$result) {
		echo json_encode([
			'error' => 'Não foi possível alterar o campo de código de ativação para null'
		]);
		exit();
	}
}

function verifyIfDoesnotExistThisUsername ($link, $username) {
	$get = $link->prepare('
		SELECT id FROM credential
		WHERE
			username = :username
	');

	$result = $get->execute([
		'username' => $username,
	]);

	if (!$result) {
		echo json_encode([
			'error' => 'Não foi possível completar a verificação de nome de usuário',
		]);
		exit();
	}

	if ($get->rowCount() !== 0) {
		echo json_encode([
			'error' => 'Este nome de usuário já está sendo usado no sistema',
		]);
		exit();
	}
}

function Post () {
	$activation_code = isset($_POST['activation_code']) ? $_POST['activation_code'] : '';
	$username = isset($_POST['username']) ? $_POST['username'] : '';
	$password = isset($_POST['password']) ? $_POST['password'] : '';
	$user = null;

	include 'util/link.php';
	$link = Lin();

	$user = getUserByActivationCode($link, $activation_code);

	verifyIfDoesnotExistThisUsername($link, $username);

	$createCredential = $link->prepare('
		INSERT INTO credential
			(user, username, password)
		VALUES
			(:user, :username, :password)
	');

	$result = $createCredential->execute([
		'user' => $user,
		'username' => $username,
		'password' => $password,
	]);

	if (!$result) {
		echo json_encode([
			'error' => 'Não foi possível criar credenciais de usuário',
		]);
		exit();
	}

	updateActivationCodeToNull($link, $user);

	include 'session/CreateSession.php';
	CreateSession($link, $user);
}