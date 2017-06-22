<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	include 'challenge/post.php';
	Post();
}