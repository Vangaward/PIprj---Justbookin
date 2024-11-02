<?php

require_once("conexao.php");
require_once("helperBD.php");
require_once("configs.php");

function selectTopLike() {
    global $conexao, $litBloqOuPriv, $dirCapa;

    $queryLitTop = mysqli_query($conexao, "
    SELECT l.idLit, l.titulo, l.urlCapa, u.nomeUsuario, u.nome, 
    COUNT(cl.curtida = 1) as qtdCurtidas, 
    SUM(cl.curtida = 0) as qtdeNaoCurtidas 
    FROM Literatura l 
    INNER JOIN usuario u ON l.idUsuario = u.idUsuario 
    LEFT JOIN curtidasLit cl ON l.idLit = cl.idLit
    WHERE cl.curtida = 1 AND " . $litBloqOuPriv . "
    GROUP BY l.idLit 
    ORDER BY qtdCurtidas DESC, qtdeNaoCurtidas 
    LIMIT 10;
    ");
    
    return processarDados($queryLitTop);
}

function selectMaisViews() {
    global $conexao, $litBloqOuPriv, $dirCapa;

    $queryLitMaisViews = mysqli_query($conexao, "
    SELECT l.idLit, l.titulo, l.urlCapa, u.nomeUsuario, u.nome
    FROM Literatura l
    INNER JOIN usuario u ON l.idUsuario = u.idUsuario
    WHERE " . $litBloqOuPriv . "
    ORDER BY views DESC LIMIT 10;
    ");

    return processarDados($queryLitMaisViews);
}

function selectMaisFavs() {
    global $conexao, $litBloqOuPriv, $dirCapa;

    $queryLitMaisFavs = mysqli_query($conexao, "
    SELECT f.idLit, l.titulo, l.urlCapa, u.nomeUsuario, u.nome, COUNT(*) AS qtdeFavoritos
    FROM favorito f
    INNER JOIN Literatura l ON l.idLit = f.idLit
    INNER JOIN usuario u ON l.idUsuario = u.idUsuario
    WHERE " . $litBloqOuPriv . "
    GROUP BY f.idLit, l.titulo, l.urlCapa, u.nomeUsuario, u.nome
    ORDER BY qtdeFavoritos DESC;
    ");

    return processarDados($queryLitMaisFavs);
}

function selectMaisRecentes() {
    global $conexao, $litBloqOuPriv, $dirCapa;

    $queryLitMaisRecentes = mysqli_query($conexao, "
    SELECT l.idLit, l.titulo, l.urlCapa, u.nomeUsuario, u.nome
    FROM Literatura l
    INNER JOIN usuario u ON l.idUsuario = u.idUsuario
    WHERE " . $litBloqOuPriv . "
    ORDER BY dataLanc DESC LIMIT 10;
    ");

    return processarDados($queryLitMaisRecentes);
}

function selectAll() {
    global $conexao, $litBloqOuPriv, $dirCapa;

    $queryLitTodas = mysqli_query($conexao, "
    SELECT l.idLit, l.titulo, l.urlCapa, u.nomeUsuario, u.nome
    FROM Literatura l
    INNER JOIN usuario u ON l.idUsuario = u.idUsuario
    WHERE " . $litBloqOuPriv . ";
    ");

    return processarDados($queryLitTodas);
}

function arteAscii() {
    global $conexao;

    $queryUsuario = "SELECT * FROM arteAscci ORDER BY RAND() LIMIT 1";
    $stmt = mysqli_prepare($conexao, $queryUsuario);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $numRowsqueryUsuario = mysqli_num_rows($result);

        if ($numRowsqueryUsuario > 0) {
            $dadosArte = mysqli_fetch_array($result);
            mysqli_stmt_close($stmt);
            return [$dadosArte['arte'], $dadosArte['nome']];
        } else {
            mysqli_stmt_close($stmt);
            echo '<input type="button" onclick="window.location=\'index.php\';" value="Voltar"><br><br>';
            die('Usuário não encontrado');
        }
    } else {
        mysqli_stmt_close($stmt);
        echo '<input type="button" onclick="window.location=\'index.php\';" value="Voltar"><br><br>';
        die('<b>Erro ao executar a consulta:</b> ' . mysqli_error($conexao));
    }
}

function processarDados($query) {
    global $dirCapa; // Variável global para o diretório da capa

    $dados = mysqli_fetch_all($query, MYSQLI_ASSOC);
    
    foreach ($dados as &$literatura) {
        $literatura['img'] = $literatura['urlCapa'] ? $dirCapa . $literatura['urlCapa'] : "imagens/batata.png";
        $literatura['idLit'] = sha1($literatura['idLit']);
    }

    return $dados;
}
?>