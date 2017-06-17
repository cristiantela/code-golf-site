<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	include 'session/post.php';
	Post();
}