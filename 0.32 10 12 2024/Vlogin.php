<?php

	//Vlogin = Verificação de login
	//Esse arquivo verifica se o usuário fez login

	if (file_exists('../conexao.php')) {
		require_once '../conexao.php';
	} elseif (file_exists('conexao.php')) {
		require_once 'conexao.php';
	} else {
		die("Erro: arquivo de conexão não encontrado.");
	}


	session_start();

	if (!isset($_SESSION['logado'])) // Não logado
	{
		$dadosLogin = "";
		$logado = 0;
	}
	else
	{
		$idUsuarioSessao = $_SESSION['idUsuario'];
		$sql = "SELECT * FROM usuario WHERE idUsuario = '$idUsuarioSessao'";
		$resultado = mysqli_query($conexao, $sql);
		$dadosLogin = mysqli_fetch_array($resultado);
		$logado = 1;
	}
    
?>