<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	include 'session/post.php';
	Post();
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
	include 'session/delete.php';
	Delete();
}