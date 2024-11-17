<?php

include_once("conexao.php");
include_once('Vlogin.php');
include_once('rsnl.php');
include_once('configs.php');

function buscaLits()
{
	global $conexao, $dadosLogin, $dirCapa;

	// Verifica se o usuário está logado e se as variáveis globais estão definidas
	if (!isset($dadosLogin['idUsuario'])) {
		return []; // Retorna um array vazio se o usuário não estiver logado
	}

	$idUsuariosessao = $dadosLogin['idUsuario'];

	// Usa prepared statements para proteger contra injeção SQL
	$stmt = mysqli_prepare($conexao, "
	SELECT s.idUsuarioSeguido, u.nome, u.sobrenome, u.nomeUsuario, u.urlFotoPerfil, l.urlCapa, l.titulo, l.idLit 
	FROM seguidos s
	INNER JOIN usuario u ON u.idUsuario = s.idUsuarioSeguido
	INNER JOIN Literatura l ON l.idUsuario = u.idUsuario
	WHERE s.idUsuario = ?");
	mysqli_stmt_bind_param($stmt, 'i', $idUsuariosessao);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);

	$dadosLit = mysqli_fetch_all($result, MYSQLI_ASSOC);

	// Processa cada literatura para adicionar a imagem correta e gerar o hash do ID
	foreach ($dadosLit as &$literatura) {
		$literatura['img'] = $literatura['urlCapa'] ? $dirCapa . $literatura['urlCapa'] : "imagens/batata.png";
		$literatura['idLit'] = sha1($literatura['idLit']);
	}

	mysqli_stmt_close($stmt); // Fecha o statement

	return $dadosLit;
}

?>