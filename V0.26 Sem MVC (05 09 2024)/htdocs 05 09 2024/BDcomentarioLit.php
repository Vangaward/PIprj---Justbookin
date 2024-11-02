<?php

include_once ('conexao.php');

include_once ('Vlogin.php');

include_once ('Vcli.php');

include_once ('rsnl.php');

$idLitSha1 = $_GET['i'];

	if (isset($_POST["submEnviaComent"]))
	{
		if ($_POST['tokenFrmNoCo'] != $_SESSION['TSFNovoComent'])
		{
			$_SESSION['msgComent'] = 5;
			header('Location: livro.php?i=' . $idLitSha1 . '#divMsgComsSup');
			die();
		}
		else
		{
			unset($_SESSION['TSFNovoComent']);
		}
		
		$queryLiteratura = ("SELECT * from Literatura where sha1(idLit) = '$idLitSha1'");
			if (!$queryLiteratura) {
			die ("Houve um erro ao carregar os recursos necessários. #1");}
		
			$resultado = mysqli_query($conexao, $queryLiteratura);
			$dadosLit = mysqli_fetch_array($resultado);
			
			$dataHoraAtual = date('Y-m-d H:i:s');
			$idLit =  $dadosLit['idLit'];
			$idUsuario = $dadosLogin['idUsuario'];
			$txtComent =  $_POST["nameTxtComent"];
			// Preparar a consulta SQL usando um prepared statement
			$queryComents = "INSERT INTO comentarios (idLit, idUsuario, txtComentario, dataCom) VALUES (?, ?, ?, ?)";
			$stmt = mysqli_prepare($conexao, $queryComents);

			if ($stmt) {
				// Vincular os parâmetros ao prepared statement
				mysqli_stmt_bind_param($stmt, 'iiss', $idLit, $idUsuario, $txtComent, $dataHoraAtual);

				// Executar a consulta
				if (mysqli_stmt_execute($stmt)) {
					$_SESSION['msgComent'] = 1; // Comentário inserido com sucesso
					header('Location: livro.php?i=' . $idLitSha1 . '#divMsgComsSup');
				} else {
					$_SESSION['msgComent'] = 2; // Erro ao inserir comentário
					header('Location: livro.php?i=' . $idLitSha1 . '#divMsgComsSup');
					die("Houve um erro ao carregar inserir o comentário");
				}

				// Fechar o statement
				mysqli_stmt_close($stmt);
			} else {
				$_SESSION['msgComent'] = 2; // Erro ao preparar a consulta
				header('Location: livro.php?i=' . $idLitSha1 . '#divMsgComsSup');
				die("Erro ao preparar a consulta: " . mysqli_error($conexao));
			}

	}
	else
	{
		header('Location: index.php');
	}

?>