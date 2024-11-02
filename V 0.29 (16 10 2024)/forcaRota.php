<?php
	if (!isset($_SESSION['rota']))
	{
		header('Location: /' . pathinfo($_SERVER['REQUEST_URI'], PATHINFO_FILENAME) . '?' . $_SERVER['QUERY_STRING']);
		exit();
	}
?>