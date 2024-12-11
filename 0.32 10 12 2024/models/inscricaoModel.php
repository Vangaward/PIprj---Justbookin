<?php

include_once("conexao.php");
include_once('Vlogin.php');
include_once('rsnl.php');
include_once('configs.php');

function buscaLits()
{
	global $conexao, $dadosLogin, $dirCapa;
	
	$txtNaoHaInscricoes = "";
	
	// Verifica se o usuário está logado e se as variáveis globais estão definidas
	if (!isset($dadosLogin['idUsuario'])) {
		return []; // Retorna um array vazio se o usuário não estiver logado
	}

	$idUsuariosessao = $dadosLogin['idUsuario'];

	// Usa prepared statements para proteger contra injeção SQL
	$stmt = mysqli_prepare($conexao, "
	SELECT s.idUsuarioSeguido, u.nome, u.sobrenome, u.nomeUsuario, u.urlFotoPerfil,
	l.urlCapa, l.titulo, l.idLit,
	COUNT(v.idLit) as qdeVerificacoes
    FROM seguidos s
    INNER JOIN usuario u ON u.idUsuario = s.idUsuarioSeguido
    INNER JOIN Literatura l ON l.idUsuario = u.idUsuario
    LEFT JOIN verificacao v ON l.idLit = v.idLit
    WHERE s.idUsuario = ?
    GROUP BY s.idUsuarioSeguido, u.nome, u.sobrenome, u.nomeUsuario, u.urlFotoPerfil,l.urlCapa, l.titulo, l.idLit;
			 ");
	mysqli_stmt_bind_param($stmt, 'i', $idUsuariosessao);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);

	$dadosLit = mysqli_fetch_all($result, MYSQLI_ASSOC);
	$qtdeInscricoes = mysqli_num_rows($result);
	
	if ($qtdeInscricoes <= 0)
	{
		$txtNaoHaInscricoes = "Você não possui inscrições ou então suas inscrição ainda não publicaram nada.";
	}
	
	// Processa cada literatura para adicionar a imagem correta e gerar o hash do ID
	foreach ($dadosLit as &$literatura) {
		$literatura['img'] = $literatura['urlCapa'] ? $dirCapa . $literatura['urlCapa'] : "imagens/batata.png";
		$literatura['idLit'] = sha1($literatura['idLit']);
	}

	mysqli_stmt_close($stmt); // Fecha o statement

	return [$dadosLit, $txtNaoHaInscricoes, $qtdeInscricoes];
}

?>