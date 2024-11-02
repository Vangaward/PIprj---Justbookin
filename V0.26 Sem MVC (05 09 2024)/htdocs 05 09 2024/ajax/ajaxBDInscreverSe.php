<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest')
{
    exit('403 Acesso proibido');
}

include_once('../conexao.php');
include_once('../rsnl.php');
include_once('../Vlogin.php');
if ($logado == 0){ header("Location: login"); }

$idUsuarioCurtSha1 = $_GET['i'];
$usuarioDiferente = true; //Verifica se o usuário logado é diferente do usuário que será seguido
$sucesso = true;
$acao;

/*Consulta*/
try{
	$queryUsuarioSeguido = mysqli_query($conexao, "SELECT * FROM usuario WHERE sha1(idUsuario) = '$idUsuarioCurtSha1'");
	$dadosUsuarioSeguido = mysqli_fetch_array($queryUsuarioSeguido);
	$idUsuarioSeguido = $dadosUsuarioSeguido['idUsuario'];
	
/*Verificar Inscrição*/
	$estaSeguindo = false;
	$idUsuarioLogado = $dadosLogin['idUsuario'];
	$queryInscrito = mysqli_query($conexao, "SELECT * from seguidos where idUsuario = '$idUsuarioLogado' && idUsuarioSeguido = '$idUsuarioSeguido'");
	if (mysqli_num_rows($queryInscrito)> 0)
	{$estaSeguindo = true;}

if ($idUsuarioCurtSha1 == sha1($dadosLogin['idUsuario']))
{ $usuarioDiferente = false;}
else
	{
	/*Insert*/
	if ($estaSeguindo == false)
	{
		$idUsuarioLogado = $dadosLogin['idUsuario'];
		$habNotif = 0;
		$stmt = $conexao->prepare("INSERT INTO seguidos (idUsuario, idUsuarioSeguido, habNotif) VALUES (?, ?, ?)");
		$stmt->bind_param("iii", $idUsuarioLogado, $idUsuarioSeguido, $habNotif);
		$stmt->execute();
		$stmt->close();
		$acao = "seguir";
	}
	else
	{
		$stmt = $conexao->prepare("DELETE FROM seguidos WHERE idUsuario = ? AND idUsuarioSeguido = ?");
		$stmt->bind_param("ii", $idUsuarioLogado, $idUsuarioSeguido);
		$stmt->execute();
		$stmt->close();
		$acao = "NaoSeguir";
	}
}
}catch(Exception $e){
	$sucesso = false;
}

	/*Resposta Ajax*/
	$respostaAjax = array(
		'usuarioDiferente' => $usuarioDiferente,
		'sucesso' => $sucesso,
		'acao' => $acao,
	);
	
echo json_encode($respostaAjax);
?>