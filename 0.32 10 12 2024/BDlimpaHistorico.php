<?php

include_once ('conexao.php');
include_once ('Vlogin.php');
include_once ('Vcli.php');
include_once ('rsnl.php');
include_once ('configs.php');

$stmt = mysqli_prepare($conexao, "DELETE FROM historico where idUsuario = ?");
	if (!$stmt) {
		// Se ocorreu um erro na preparação da consulta, exibir uma mensagem de erro e interromper o script
		echo '<br><input type="button" onclick="window.location='."'../index.php'".';" value="Voltar ao início"><br><br>';
		die('<style> .erro { background-color: red; color: #ffffff;}</style><div class="erro"><b>Query Inválida:</b><br>Ocorreu um erro inesperado.</div><br>' . mysqli_error($conexao));
	}
	mysqli_stmt_bind_param($stmt, "i", $dadosLogin['idUsuario']);

	mysqli_stmt_execute($stmt);
	$ultimoIdInserido = mysqli_insert_id($conexao);
	mysqli_stmt_close($stmt);
	
	$conexao->close();
	
	header('Location: historico.php');

?>