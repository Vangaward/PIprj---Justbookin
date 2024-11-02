<?php

include_once('conexao.php');
include_once('rsnl.php');
include_once('Vcli.php');

$idLitSha1 = $_GET['i'];

if (isset($_POST['btnPublicarSemCapitulos']) || isset($_POST['btnPublicarHaCapitulos']))
{
	
	if ($_POST['tokenFrmPublicaLitP2'] != $_SESSION['TSFPublicaLitP2'])
	{
		$_SESSION['msgLike'] = 1;
		header('Location: livro.php?i=' . $idLitSha1);
		die();
	}
	else
	{
		unset($_SESSION['TSFPublicaLitP2']);
	}
	
	/*Verificar se a literatura pertence à conte logada*/

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
	
	if ($dadosLit['status'] == 2)
	{
		header('Location: index.php');
		die();
	}
	
	if ($dadosLit['idUsuario'] != $dadosLogin['idUsuario'])
	{
		header("Location: index.php");
	}
	/*fim de*/
	
	$queryDeletCaps = mysqli_query($conexao, "DELETE FROM capituloLit where idLit = '$idLit'");
	
	if (isset($_POST['btnPublicarHaCapitulos']))
	{
		$capitulosNome = $_POST['capitulo'];
        $paginas = $_POST['pagina'];
        $quantidade = count($capitulosNome);
		
		$stmt = $conexao->prepare("INSERT INTO capituloLit (idLit, nomeCapitulo, paginaInicial, numCapitulo, dataCapitulo) VALUES (?, ?, ?, ?, ?)");

		for ($i = 0; $i < $quantidade; $i++) {
			$nomeCapitulo = $capitulosNome[$i];
			$paginaInicial = $paginas[$i];
			$numCapitulo = $i + 1;
			$dataHoraAtual = date('Y-m-d H:i:s');
			echo $nomeCapitulo;
			$stmt->bind_param("sssss", $dadosLit['idLit'], $nomeCapitulo , $paginaInicial, $numCapitulo, $dataHoraAtual);
			$stmt->execute();
		}
			$stmt->close();
	}

	/*Buscar na tabela Categoria*/
	$queryCategoria = mysqli_query($conexao, "SELECT * FROM Categoria");
			if (!$queryCategoria) {$_SESSION['msgLitEdit'] = false; header("Location: livro.php?i=" . $idLitSha1); die();}
	/*fim de*/
	
	//Lógicas para atualizar a tabela literatura
	
	$titulo = $_POST['tituloLivroName'];
	$descricao = $_POST['descricaoLivroName'];
	$status = $_POST['sctAlterarVisibilidade'];
	
	/*Update com prepared statements*/
	$sqlupdateLit = "UPDATE Literatura SET titulo=?, descricao=?, status=? WHERE SHA1(idLit) = ?";
	$stmt = mysqli_prepare($conexao, $sqlupdateLit);
	mysqli_stmt_bind_param($stmt, "ssss", $titulo, $descricao, $status, $idLitSha1);
	$resultado = mysqli_stmt_execute($stmt);
	if (!$resultado) {$_SESSION['msgLitEdit'] = false; header("Location: livro.php?i=" . $idLitSha1); die();}
	mysqli_stmt_close($stmt);
	
	/*fim de*/
	
	//Lógicas para atualizar a tabela itemCategoria
	
	$sqlDeleteItemCat = "DELETE FROM itemCategoria WHERE SHA1(idLit) = ?";
	$stmt = mysqli_prepare($conexao, $sqlDeleteItemCat);
	mysqli_stmt_bind_param($stmt, "s", $idLitSha1);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	
	if (isset($_POST['checkboxCat'])) {
		$selectedCheckboxesCats = $_POST['checkboxCat'];
		foreach ($selectedCheckboxesCats as $id) {
			$queryCategoria = mysqli_query($conexao, "SELECT idCategoria FROM Categoria where sha1(idCategoria) = '$id'");
			$categoria = mysqli_fetch_assoc($queryCategoria);
			$idCategoria = $categoria['idCategoria'];
			
			$sqlInsertItemCat = "INSERT INTO itemCategoria (idCategoria, idLit) VALUES (?, ?)";
			$stmt_insert_itemCategoria = mysqli_prepare($conexao, $sqlInsertItemCat);
			mysqli_stmt_bind_param($stmt_insert_itemCategoria, "ii", $idCategoria, $dadosLit['idLit']);
			mysqli_stmt_execute($stmt_insert_itemCategoria);
			mysqli_stmt_close($stmt_insert_itemCategoria);
		}
		$dataAtual = date('Y-m-d H:i:s');
		$queryDeletCaps = mysqli_query($conexao, "UPDATE Literatura set dataEdit = '$dataAtual' where idLit = '$idLit'");
	}
	/*fim de*/
	
	/*Editar capítulos*/
	
	//if (isset)
	
	/*fim de*/
	
	$conexao->close();
	
	$_SESSION['msgLitEdit'] = true;
	header("Location: livro.php?i=" . $idLitSha1);
	
}
else //if isset($_POST['salvAltsEditLit'])
{header("Location: index.php");}
?>