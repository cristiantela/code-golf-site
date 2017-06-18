<?php

function GetUser ($link, $id) {

}

function Get () {
	include 'util/link.php';

	$link = Lin();

	include 'session/GetUserSessionByAuthorization.php';
	$user = GetUserSessionByAuthorization($link);

	if ($user) {
		include 'user/GetUserById.php';
		$user = GetUserById($link, $user);

		echo json_encode([
			'id' => $user['id'],
			'name' => $user['name'],
			'paper' => $user['paper'],
		]);
		exit();
	} else {
		echo json_encode([
			'error' => 'Nenhum usuário encontrado',
		]);
		exit();
	}
}