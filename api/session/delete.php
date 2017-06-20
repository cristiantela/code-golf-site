<?php

function Delete () {
	include 'util/link.php';

	$link = Lin();

	include 'session/SetClosedSessionByAuthorization.php';
	SetClosedSessionByAuthorization($link);
}