<?php

function Get () {
	include 'util/link.php';

	$link = Lin();

	$getChallenge = $link->prepare('
		SELECT id, user, title, description, start, finish
		FROM challenge
		WHERE
			NOW() >= start AND
			NOW() <= finish
	');

	$result = $getChallenge->execute();

	if (!$result) {
		echo json_encode([
			'error' => 'Não foi possível completar a consulta de desafio ativo',
		]);
		exit();
	}

	if ($getChallenge->rowCount() === 0) {
		echo json_encode([
			'error' => 'Nenhum desafio encontrado',
		]);
		exit();
	}

	$result = $getChallenge->fetch();

	include('code/GetCodeRanking.php');

	$rankingREQUEST = GetCodeRanking($link, [
		'challenge' => $result['id'],
	]);

	$ranking = [];

	include_once('user/GetUserById.php');
	include_once('language/GetLanguage.php');

	foreach ($rankingREQUEST as $value) {
		$user = GetUserById($link, $value['user']);
		$language = GetLanguage($link, [
			'id' => $value['language'],
		]);

		$ranking[] = [
			'id' => $value['id'],
			'user' => [
				'id' => $user['id'],
				'name' => $user['name'],
			],
			'language' => [
				'id' => $language['id'],
				'name' => $language['name'],
			],
			'length' => $value['length'],
		];
	}

	echo json_encode([
		'id' => $result['id'],
		'user' => $result['user'],
		'title' => $result['title'],
		'description' => $result['description'],
		'start' => $result['start'],
		'finish' => $result['finish'],
		'ranking' => $ranking,
	]);
	exit();
}