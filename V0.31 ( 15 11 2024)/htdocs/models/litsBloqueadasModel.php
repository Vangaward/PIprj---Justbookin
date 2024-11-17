<?php

function getLits()
{
	global $conexao, $dirCapa;
	$queryLit = mysqli_query($conexao, "SELECT l.idLit, l.titulo, l.urlCapa, l.status, u.nomeUsuario, u.nome
	 FROM Literatura l
	INNER JOIN usuario u ON l.idUsuario = u.idUsuario where l.status = 2;
	");
	if (!$queryLit)
	{
		echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
		die('<b>Query Inválida:</b>');
	}
	$dados = mysqli_fetch_all($queryLit, MYSQLI_ASSOC);
	
	foreach ($dados as &$literatura) {
        $literatura['img'] = $literatura['urlCapa'] ? "../" . $dirCapazz . $literatura['urlCapa'] : "imagens/batata.png";
        $literatura['idLit'] = sha1($literatura['idLit']);
    }
	
	return $dados;
}

?>