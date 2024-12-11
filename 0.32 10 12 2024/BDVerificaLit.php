<?php

	header('Content-Type: text/html; charset=UTF-8');
	include_once ('conexao.php');
	include_once ('Vlogin.php');
	include_once('rsnl.php');

	$tokenDeVerificacao = $_GET['token'];
	$idLitCripto = $_GET['i'];

	if ($tokenDeVerificacao != $_SESSION['TSFVerificaLit'])
	{
		$_SESSION['msgVerificaLit'] = 1;
		header('Location: ../livro?i=' . $idLitCripto);
		die();
	}
	else
	{
		unset($_SESSION['TSFVerificaLit']);
	}
	
	$stmt = $conexao->prepare("SELECT * FROM verificacao WHERE sha1(idLit) = ? and idUsuario = ?");
	$stmt->bind_param("ss", $idLitCripto, $dadosLogin['idUsuario']);
	$stmt->execute();
	$result = $stmt->get_result();
	$qtdeLinhasVerif = $result->num_rows;
	$dadosVerif = $result->fetch_assoc();

	$stmt->close();
	
	/**/
	$stmt = $conexao->prepare("SELECT * FROM Literatura WHERE sha1(idLit) = ?;");
	$stmt->bind_param("s", $idLitCripto);
	$stmt->execute();
	$result = $stmt->get_result();
	$dadosLit = $result->fetch_assoc();

	$stmt->close();
	
	/**//**/
	
	if ($qtdeLinhasVerif < 1)
	{
		$idLit = $dadosLit['idLit'];
		$idUsuario = $dadosLogin['idUsuario'];
		$datahHora = date("Y-m-d H:i:s");
		$queryLitVerif = "INSERT INTO verificacao (idLit, idUsuario, data) values ('$idLit', '$idUsuario', '$datahHora');";
		$result = mysqli_query($conexao, $queryLitVerif);

		if (!$result) {
			$_SESSION['msgVerificaLit'] = 1;
			header('Location: ../livro?i=' . $idLitCripto);
			die();
		}
		else
		{
			$_SESSION['msgVerificaLit'] = 3;
			header('Location: ../livro?i=' . $idLitCripto);
			die();
		}
	}
	else if ($qtdeLinhasVerif > 0)
	{
		$idLit = $dadosLit['idLit'];
		$idUsuario = $dadosLogin['idUsuario'];
		$queryLitVerif = "DELETE FROM verificacao WHERE idLit = $idLit AND idUsuario = $idUsuario;";
		$result = mysqli_query($conexao, $queryLitVerif);

		if (!$result) {
			$_SESSION['msgVerificaLit'] = 1;
			header('Location: ../livro?i=' . $idLitCripto);
		}
		else
		{
			$_SESSION['msgVerificaLit'] = 4;
			header('Location: ../livro?i=' . $idLitCripto);
			die();
		}
	}
	else
	{
		header('Location: ../index.php');
		die();
	}

?>