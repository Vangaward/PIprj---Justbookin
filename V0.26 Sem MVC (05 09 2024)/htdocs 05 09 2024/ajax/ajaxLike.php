<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest')
{
    exit('403 Acesso proibido');
}

include_once('../conexao.php');
include_once('../Vlogin.php');

$idLitSha1 = $_GET['i'];

$queryDesdlikes = mysqli_query($conexao, "SELECT * FROM curtidasLit WHERE sha1(idLit) = '$idLitSha1' and curtida = 0");
$qtdeDeslikes = mysqli_num_rows($queryDesdlikes);
if (!$queryDesdlikes) {
    die("Erro na consulta: " . mysqli_error($conexao));
}
/**//**/
$queryLikes = mysqli_query($conexao, "SELECT * FROM curtidasLit WHERE sha1(idLit) = '$idLitSha1' and curtida = 1");
$qtdeLikes = mysqli_num_rows($queryLikes);
if (!$queryLikes) {
    die("Erro na consulta: " . mysqli_error($conexao));
}
/*Cálculo de porcentagem:*/
$qtdeLikeDeslike = $qtdeLikes + $qtdeDeslikes;
if ($qtdeLikeDeslike != 0)
{
	$porcentLikes = ($qtdeLikes / $qtdeLikeDeslike) * 100;
}
else
{
	$porcentLikes = 0;
}

/*Saber se o usuário logado curtiu ou não:*/
if ($logado == 1)
{
	$idUsuario = $dadosLogin['idUsuario'];
	$queryLike = mysqli_query($conexao, "SELECT * FROM curtidasLit WHERE sha1(idLit) = '$idLitSha1' AND idUsuario = '$idUsuario'");

	if (!$queryLike) {
		die("Erro na consulta: " . mysqli_error($conexao));
	}
	$qtdeLinhasLike = mysqli_num_rows($queryLike);
	$dadosLike = mysqli_fetch_array($queryLike);
	$likeDeslike = null; //Para saber se o usuário deu like/deslike
	if ($qtdeLinhasLike > 0)
		{
			if ($dadosLike['curtida'] == 0){$likeDeslike = 0;}
			if ($dadosLike['curtida'] == 1){$likeDeslike = 1;}
		}
		
		/*Resposta Ajax*/
$respostaAjax = array(
	'qtdeDeslikes' => $qtdeDeslikes,
    'qtdeLikes' => $qtdeLikes,
    'porcentLikes' => $porcentLikes,
	'likeDeslike' => $likeDeslike,
);
}
else
{
	/*Resposta Ajax*/
	$respostaAjax = array(
		'qtdeDeslikes' => $qtdeDeslikes,
		'qtdeLikes' => $qtdeLikes,
		'porcentLikes' => $porcentLikes,
	);
}

echo json_encode($respostaAjax);
?>