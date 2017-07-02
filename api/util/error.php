<?php

function error($expression, $message) {
	if (!$expression) {
		echo json_encode([
			'error' => $message,
		]);
		exit();
	}
}