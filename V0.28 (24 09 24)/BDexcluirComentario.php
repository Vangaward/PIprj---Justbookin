<?php

include_once('conexao.php');

include_once('rsnl.php');

include_once('Vlogin.php');

if (isset($_POST["excluirCom"]))
{
	$idComentario = $_GET['i'];
	$idUsuSha1 = $_GET['iu'];
	
	if ($_POST['tokenFrmExCo'] != $_SESSION['TSFExcluiCo'])
	{
		$_SESSION['msgComent'] = 5;
		header('Location: livro.php?i=' . sha1($_SESSION['idLitAtualBDexcuirCom']) . '#divMsgComsSup');
		die();
	}
	else
	{
		unset($_SESSION['TSFExcluiCo']);
	}
	
	if ($idUsuSha1 != sha1($dadosLogin['idUsuario']))
	{
		header('Location: index.php');
		die("Sem autorização");
	}
	else
	{
		// Excluir o comentário
		$sqldeleteCom = "DELETE FROM comentarios WHERE sha1(idComentario) = ? AND sha1(idUsuario) = ?";
		$stmt = mysqli_prepare($conexao, $sqldeleteCom);

		if ($stmt) {
			// Vincular os parâmetros ao prepared statement
			mysqli_stmt_bind_param($stmt, 'ss', $idComentario, $idUsuSha1);

			// Executar a consulta
			if (mysqli_stmt_execute($stmt)) {
				$_SESSION['msgComent'] = 4; // Comentário deletado com sucesso
				header('Location: livro.php?i=' . sha1($_SESSION['idLitAtualBDexcuirCom']) . '#divMsgComsSup');
			} else {
				$_SESSION['msgComent'] = 3; // Erro ao deletar comentário
				header('Location: livro.php?i=' . sha1($_SESSION['idLitAtualBDexcuirCom']) . '#divMsgComsSup');
				die("Erro ao deletar comentário: " . mysqli_error($conexao));
			}

			// Fechar o statement
			mysqli_stmt_close($stmt);
		} else {
			$_SESSION['msgComent'] = 3; // Erro ao preparar a consulta
			header('Location: livro.php?i=' . sha1($_SESSION['idLitAtualBDexcuirCom']) . '#divMsgComsSup');
			die("Erro ao preparar a consulta: " . mysqli_error($conexao));
		}
		
		// Excluir os likes/deslikes dos comentáriod
		$sqldeleteCom = "DELETE FROM ComCurtida WHERE sha1(idComentario) = ?";
		$stmt = mysqli_prepare($conexao, $sqldeleteCom);

		if ($stmt) {
			// Vincular os parâmetros ao prepared statement
			mysqli_stmt_bind_param($stmt, 's', $idComentario);

			// Executar a consulta
			if (mysqli_stmt_execute($stmt)) {
				$_SESSION['msgComent'] = 4; // ComCurtida deletado com sucesso
				header('Location: livro.php?i=' . sha1($_SESSION['idLitAtualBDexcuirCom']) . '#divMsgComsSup');
			} else {
				$_SESSION['msgComent'] = 3; // Erro ao deletar ComCurtida
				header('Location: livro.php?i=' . sha1($_SESSION['idLitAtualBDexcuirCom']) . '#divMsgComsSup');
				die("Erro ao deletar comentário: " . mysqli_error($conexao));
			}

			// Fechar o statement
			mysqli_stmt_close($stmt);
		} else {
			$_SESSION['msgComent'] = 3; // Erro ao preparar a consulta
			header('Location: livro.php?i=' . sha1($_SESSION['idLitAtualBDexcuirCom']) . '#divMsgComsSup');
			die("Erro ao preparar a consulta: " . mysqli_error($conexao));
		}
	}
}
else
{
	header("Location: index.php");
	die();
}

?>