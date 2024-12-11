<?php

function buscaHist()
{
	global $conexao, $dadosLogin, $dirCapa;
	$idUsuario = $dadosLogin['idUsuario'];
	$queryLit = mysqli_query($conexao, "
	SELECT l.idLit, l.titulo, l.urlCapa, u.nomeUsuario, COUNT(v.idLit) AS qdeVerificacoes
	FROM Literatura l
	INNER JOIN usuario u ON l.idUsuario = u.idUsuario
	INNER JOIN historico h ON l.idLit = h.idLit
	LEFT JOIN verificacao v ON l.idLit = v.idLit
	WHERE h.idUsuario = '$idUsuario'
	GROUP BY l.idLit, l.titulo, l.urlCapa, u.nomeUsuario;
	");

	if (!$queryLit) {
		echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
		die('<b>Query Inválida: </b>' . @mysqli_error($conexao));
	}
	
	$qtdLits = mysqli_num_rows($queryLit);
	$txtQtdLits= "";
	if ($qtdLits <= 0) {
		$txtQtdLits = "Ainda não há literaturas visualizadas.";
	}
	
	$dadosLit = mysqli_fetch_all($queryLit, MYSQLI_ASSOC);
	
	foreach ($dadosLit as &$literatura) {
        $literatura['img'] = $literatura['urlCapa'] ? $dirCapa . $literatura['urlCapa'] : "imagens/batata.png";
        $literatura['idLit'] = sha1($literatura['idLit']);
    }
	
	return [$dadosLit, $qtdLits, $txtQtdLits];

}

?>