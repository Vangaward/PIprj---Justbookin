<?php
	include_once('Vadm.php');
	
	$idLitSha1 = $_GET['i'];
	$statusLit = $_POST['sctAlterarVisibilidade'];
	
	if ($_POST['tokenFrmAltStAdm'] != $_SESSION['TSFAltStAdm'])
	{
		header('Location: ../index.php');
		die();
	}
	else
	{
		unset($_SESSION['TSFAltStAdm']);
	}
	
	//Statement Prepared Buscar Lit
		$sql = "SELECT * FROM Literatura WHERE sha1(idLit) = ?";
		$stmt = $conexao->prepare($sql);
		if (!$stmt) {
			die('Erro ao preparar a consulta: ' . $conexao->error);
		}
		$stmt->bind_param('s', $idLitSha1);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows < 1) {
			$_SESSION['msgLitEdit'] = false;
			header("Location: livro.php?i=" . urlencode($idLitSha1));
			die();
		}
		$dadosLit = $result->fetch_array(MYSQLI_ASSOC);
		$stmt->close();
		
		$idLit = $dadosLit['idLit'];
	/*Fim de*/
	
	/*Update com prepared statements*/
	$sqlupdateLit = "UPDATE Literatura SET status=? WHERE SHA1(idLit) = ?";
	$stmt = mysqli_prepare($conexao, $sqlupdateLit);
	mysqli_stmt_bind_param($stmt, "ss", $statusLit, $idLitSha1);
	$resultado = mysqli_stmt_execute($stmt);
	if (!$resultado) {$_SESSION['msgLitEdit'] = false; header("Location: livro.php?i=" . $idLitSha1); die();}
	mysqli_stmt_close($stmt);
	
	/*fim de*/
	
	$_SESSION['msgLitEdit'] = true;
	header("Location: ../livro.php?i=" . $idLitSha1);
	
?>