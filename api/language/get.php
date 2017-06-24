<?php

function Get () {
	include 'util/link.php';

	$link = Lin();

	$getLanguage = $link->prepare('
		SELECT id, name
		FROM language
	');

	$result = $getLanguage->execute();

	if (!$result) {
		echo json_encode([
			'error' => 'Não foi possível completar a consulta de desafio ativo',
		]);
		exit();
	}

	$return = [];
	$result = $getLanguage->fetchAll();

	foreach ($result as $value) {
		$return[] = [
			'id' => $value['id'],
			'name' => $value['name'],
		];
	}

	echo json_encode($return);
	exit();
}