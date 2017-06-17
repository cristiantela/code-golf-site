<?php

function random ($length) {
	$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	$text = '';

	for ($i = 0; $i < $length; $i++) {
		$text .= $characters[rand(0, strlen($characters) - 1)];
	}

	return $text;
}