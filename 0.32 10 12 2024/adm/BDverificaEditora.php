<?php

	header('Content-Type: text/html; charset=UTF-8');
	include_once ('../conexao.php');
	include_once ('Vlogin.php');
	include_once ('Vadm.php');

	$tokenDeVerificacao = $_GET['token'];
	$idPerfilCripto = $_GET['i'];
	$tipoAtual = $_GET['tipoAtual'];

	if ($tokenDeVerificacao != $_SESSION['TSFVerificaEditora'])
	{
		header('Location: perfil.php?i=' . $idPerfilCripto);
		$_SESSION['perfilMsg'] = 4;
		die();
	}
	else
	{
		unset($_SESSION['TSFVerificaEditora']);
	}
	/**//**/
	if ($tipoAtual == 3)
	{
		$queryUsuario = "UPDATE usuario SET tipoConta = 2 WHERE sha1(idUsuario) = '$idPerfilCripto'";
		$result = mysqli_query($conexao, $queryUsuario);

		if (!$result) {
			die("Houve um erro ao carregar os recursos necessários. #1");
		}
		else
		{
			$_SESSION['perfilMsg'] = 5;
			header('Location: ../perfil?i=' . $idPerfilCripto);
		}
	}
	else if ($tipoAtual == 2)
	{
		$queryUsuario = "UPDATE usuario SET tipoConta = 3 WHERE sha1(idUsuario) = '$idPerfilCripto'";
		$result = mysqli_query($conexao, $queryUsuario);

		if (!$result) {
			die("Houve um erro ao carregar os recursos necessários. #1");
		}
		else
		{
			$queryLitVerif = "DELETE FROM verificacao WHERE sha1(idUsuario) = '$idPerfilCripto';";
			$result = mysqli_query($conexao, $queryLitVerif);
			if (!$result)
			{
				die("Houve um erro ao tentar remover as verificações associadas!");
			}
			else
			{
				$_SESSION['perfilMsg'] = 6;
				header('Location: ../perfil?i=' . $idPerfilCripto);
			}
		}
	}
	else
	{
		header('Location: ../index.php');
	}

?>