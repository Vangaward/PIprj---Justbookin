<?php

include_once('conexao.php');
include_once('rsnl.php');
include_once('Vlogin.php');

$idUsuario = $dadosLogin['idUsuario'];

if(!isset($_SESSION['litAtual']))
{ header('Location: index.php'); }
$idLit = $_SESSION['litAtual'];
$idComent = $_GET['i'];
/**//**//**//**/

$queryLike = mysqli_query($conexao, "SELECT * FROM ComCurtida WHERE sha1(idComentario) = '$idComent' AND idUsuario = '$idUsuario'");

if (!$queryLike) {
    $_SESSION['msgComent'] = 6;
	header('Location: livro.php?i=' . sha1($idLit) . '#divMsgComsSup');
    die("Erro na consulta: " . mysqli_error($conexao));
}

$queryComent = mysqli_query($conexao, "SELECT * FROM comentarios WHERE sha1(idComentario) = '$idComent';");

if (!$queryComent) {
    $_SESSION['msgComent'] = 6;
	header('Location: livro.php?i=' . sha1($idLit) . '#divMsgComsSup');
    die("Erro na consulta: " . mysqli_error($conexao));
}
$dadosComent = mysqli_fetch_array($queryComent);
$idComent = $dadosComent['idComentario'];

$qtdeLinhas = mysqli_num_rows($queryLike);

if ($_POST['TokenLikeDeslCom'] != $_SESSION['TSFLikeDeslCom'])
{
	$_SESSION['msgComent'] = 7;
	header('Location: livro.php?i=' . sha1($idLit) . '#divMsgComsSup');
	die();
}
else
{
	unset($_SESSION['TSFLikeDeslCom']);
}

/* No banco, se curtida = 1 então é "Like", 
   se curtida = 0 então é "deslike".*/
$dadosLike = mysqli_fetch_array($queryLike);

if (isset($_POST['btnLikeComent']))
{
	if ($qtdeLinhas > 0)
	{
		if ($dadosLike['curtida'] == 0) //Já havia um "deslike"
		{
			$queryLike = mysqli_query($conexao, "update ComCurtida set curtida= 1 where idComentario = '$idComent' && idUsuario = '$idUsuario'");
			if (!$queryLike) {
				$_SESSION['msgComent'] = 6;
				header('Location: livro.php?i=' . sha1($idLit) . '#divMsgComsSup');
				die("Erro na consulta: " . mysqli_error($conexao));
			}
			header('Location: livro.php?i=' . sha1($idLit) . '#divMsgComsSup');
			die();
		}
		else //Já havia um like
		{
			$queryLike = mysqli_query($conexao, "delete from ComCurtida where idComentario = '$idComent' && idUsuario = '$idUsuario'");
			if (!$queryLike) {
				$_SESSION['msgComent'] = 6;
				header('Location: livro.php?i=' . sha1($idLit) . '#divMsgComsSup');
				die("Erro na consulta: " . mysqli_error($conexao));
			}
			$queryAutoIncr = "ALTER TABLE ComCurtida AUTO_INCREMENT = 1";
			// Executar a query
			if ($conexao->query($queryAutoIncr) === FALSE) {
				$_SESSION['msgComent'] = 6;
				header('Location: livro.php?i=' . sha1($idLit) . '#divMsgComsSup');
				die ("Erro ao redefinir auto incremento: " . $conn->error);
			}
			header('Location: livro.php?i=' . sha1($idLit) . '#divMsgComsSup');
			die();
		}
	}
	else
	{
		$queryInsertLike = mysqli_query($conexao, "INSERT INTO ComCurtida (curtida, idUsuario, idComentario) values (1, '$idUsuario', '$idComent')");

			if (!$queryInsertLike) {
				$_SESSION['msgComent'] = 6;
				header('Location: livro.php?i=' . sha1($idLit) . '#divMsgComsSup');
				die("Erro: " . mysqli_error($conexao));
			}
			header('Location: livro.php?i=' . sha1($idLit) . '#divMsgComsSup');
			die();
	}
}
else if (isset($_POST['btnDeslikeComent']))
{
	if ($qtdeLinhas > 0)
	{
		if ($dadosLike['curtida'] == 1) //Já havia um "like"
		{
			$queryLike = mysqli_query($conexao, "update ComCurtida set curtida= 0 where idComentario = '$idComent' && idUsuario = '$idUsuario'");
			if (!$queryLike) {
				$_SESSION['msgComent'] = 6;
				header('Location: livro.php?i=' . sha1($idLit) . '#divMsgComsSup');
				die("Erro na consulta: " . mysqli_error($conexao));
			}
			header('Location: livro.php?i=' . sha1($idLit) . '#divMsgComsSup');
			die();
		}
		else //Já havia um deslike
		{
			$queryLike = mysqli_query($conexao, "delete from ComCurtida where idComentario = '$idComent' && idUsuario = '$idUsuario'");
			if (!$queryLike) {
				$_SESSION['msgComent'] = 6;
				header('Location: livro.php?i=' . sha1($idLit) . '#divMsgComsSup');
				die("Erro na consulta: " . mysqli_error($conexao));
			}
			$queryAutoIncr = "ALTER TABLE ComCurtida AUTO_INCREMENT = 1";
			// Executar a query
			if ($conexao->query($queryAutoIncr) === FALSE) {
				$_SESSION['msgComent'] = 6;
				header('Location: livro.php?i=' . sha1($idLit). '#divMsgComsSup');
				die ("Erro ao redefinir auto incremento: " . $conn->error);
			}
		
			header('Location: livro.php?i=' . sha1($idLit) . '#divMsgComsSup');
			die();
		}
	}
	else
	{
		$queryInsertLike = mysqli_query($conexao, "INSERT INTO ComCurtida (curtida, idUsuario, idComentario) values (0, '$idUsuario', '$idComent')");

			if (!$queryInsertLike) {
				$_SESSION['msgComent'] = 6;
				header('Location: livro.php?i=' . sha1($idLit) . '#divMsgComsSup');
				die("Erro: " . mysqli_error($conexao));
			}
			header('Location: livro.php?i=' . sha1($idLit) . '#divMsgComsSup');
			die();
	}
}
else //Form não enviado
{
	header('Location: index.php');
}

?>