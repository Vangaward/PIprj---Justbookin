<?php

require_once("conexao.php");
require_once("helperBD.php");
require_once("configs.php");

function selectTopLike()
{
	global $conexao;
	global $litBloqOuPriv;
	global $dirCapa;
	$queryLitTop = mysqli_query($conexao, "
    SELECT l.idLit, l.titulo, l.urlCapa, u.nomeUsuario, u.nome, COUNT(cl.curtida = 1) as qtdCurtidas, SUM(cl.curtida = 0) as qtdeNaoCurtidas 
    FROM Literatura l 
    INNER JOIN usuario u ON l.idUsuario = u.idUsuario 
    LEFT JOIN curtidasLit cl ON l.idLit = cl.idLit
    WHERE cl.curtida = 1 and " . $litBloqOuPriv . "
    GROUP BY l.idLit 
    ORDER BY qtdCurtidas DESC, qtdeNaoCurtidas 
    LIMIT 10;
	");
	$dados = mysqli_fetch_all($queryLitTop, MYSQLI_ASSOC);

    foreach ($dados as &$literatura) { // Use a referência (&) para modificar o array original
        $literatura['img'] = $literatura['urlCapa'] ? $dirCapa . $literatura['urlCapa'] : "imagens/batata.png";
		$literatura['idLit'] = sha1($literatura['idLit']);
    }
    return $dados;
}

function selectMaisViews()
{
	global $conexao;
	global $litBloqOuPriv;
	global $dirCapa;
	$queryLitMaisViews = mysqli_query($conexao, "
    SELECT l.idLit, l.titulo, l.urlCapa, u.nomeUsuario, u.nome
    FROM Literatura l
    INNER JOIN usuario u ON l.idUsuario = u.idUsuario
	WHERE " . $litBloqOuPriv . "
	ORDER BY views DESC LIMIT 10;
	");
	$dados = mysqli_fetch_all($queryLitMaisViews, MYSQLI_ASSOC);

    foreach ($dados as &$literatura) {
        $literatura['img'] = $literatura['urlCapa'] ? $dirCapa . $literatura['urlCapa'] : "imagens/batata.png";
		$literatura['idLit'] = sha1($literatura['idLit']);
    }
    return $dados;
}

function selectMaisFavs() //Mais favoritadas
{
	global $conexao;
	global $litBloqOuPriv;
	global $dirCapa;
	$queryLitMaisFavs = mysqli_query($conexao, "
	SELECT f.idLit, l.titulo, l.urlCapa, u.nomeUsuario, u.nome, COUNT(*) AS qtdeFavoritos
	FROM favorito f
	INNER JOIN Literatura l ON l.idLit = f.idLit
	INNER JOIN usuario u ON l.idUsuario = u.idUsuario
	WHERE " . $litBloqOuPriv . "
	GROUP BY f.idLit, l.titulo, l.urlCapa, u.nomeUsuario, u.nome
	ORDER BY qtdeFavoritos DESC;
	");
	$dados = mysqli_fetch_all($queryLitMaisFavs, MYSQLI_ASSOC);

    foreach ($dados as &$literatura) {
        $literatura['img'] = $literatura['urlCapa'] ? $dirCapa . $literatura['urlCapa'] : "imagens/batata.png";
		$literatura['idLit'] = sha1($literatura['idLit']);
    }
    return $dados;
}

function selectMaisRecentes()
{
	global $conexao;
	global $litBloqOuPriv;
	global $dirCapa;
	$queryLitMaisRecentes = mysqli_query($conexao, "
    SELECT l.idLit, l.titulo, l.urlCapa, u.nomeUsuario, u.nome
    FROM Literatura l
    INNER JOIN usuario u ON l.idUsuario = u.idUsuario
	WHERE " . $litBloqOuPriv . "
	ORDER BY dataLanc DESC LIMIT 10;
	");
	$dados = mysqli_fetch_all($queryLitMaisRecentes, MYSQLI_ASSOC);

    foreach ($dados as &$literatura) {
        $literatura['img'] = $literatura['urlCapa'] ? $dirCapa . $literatura['urlCapa'] : "imagens/batata.png";
		$literatura['idLit'] = sha1($literatura['idLit']);
    }
    return $dados;
}

function selectAll()
{
	global $conexao;
	global $litBloqOuPriv;
	global $dirCapa;
	$queryLitTodas = mysqli_query($conexao, "
    SELECT l.idLit, l.titulo, l.urlCapa, u.nomeUsuario, u.nome
    FROM Literatura l
    INNER JOIN usuario u ON l.idUsuario = u.idUsuario
	WHERE " . $litBloqOuPriv . ";
	");
	$dados = mysqli_fetch_all($queryLitTodas, MYSQLI_ASSOC);

    foreach ($dados as &$literatura) {
        $literatura['img'] = $literatura['urlCapa'] ? $dirCapa . $literatura['urlCapa'] : "imagens/batata.png";
		$literatura['idLit'] = sha1($literatura['idLit']);
    }
    return $dados;
}
?>