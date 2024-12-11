<?php
	if (!isset($_SESSION['rota']))
	{
		header('Location: ' . dirname($_SERVER['PHP_SELF']) . '/' . basename($_SERVER['PHP_SELF'], '.php') . '?' . $_SERVER['QUERY_STRING']);
		exit();
	}
?>