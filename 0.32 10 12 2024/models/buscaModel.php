<?php

require_once("conexao.php");
require_once("helperBD.php");
require_once("configs.php");

function selectUsuarios($search)
{
	global $conexao;
	global $litBloqOuPriv;
	global $dirCapa;
	
	if ($search != null)
	{
		$stmt = $conexao->prepare("SELECT * FROM usuario 
								   WHERE (nome LIKE ? OR sobrenome LIKE ? OR nomeUsuario LIKE ?) 
								   AND tipoConta != 1");
		$stmt->bind_param('sss', $search, $search, $search);
		$stmt->execute();
		$result = $stmt->get_result();
		if (!$result) {
			die('<b>Query Inválida:</b> ' . $conexao->error);
		}
		
		$dadosPerfilsArray = [];
		while ($dadosPerfils = $result->fetch_array()) {
			$dadosPerfilsArray[] = $dadosPerfils;
		}
		
		foreach ($dadosPerfilsArray as &$perfil) { // Use a referência (&) para modificar o array original
		if ($perfil['urlFotoPerfil'] == "")
			{$img = "imagens/User.png";}else{$img = "fotosPerfil/" . $perfil['urlFotoPerfil'];}
		
			$perfil['fotoECaminhoPerfil'] = $img;
			$perfil['idUsuarioCripto'] = sha1($perfil['idUsuario']);
		}
		
		$stmt->close();
		
		return $dadosPerfilsArray;
	}
}

function selectLits($search, $icat) 
{
    global $conexao;
    global $litBloqOuPriv;
    global $dirCapa;

    $IdCatSha1 = $icat;

    // Inicialização de variáveis
    $innerJoinItCat = "";
    $innerJoinCat = "";
    $where = "";
    $types = ""; // Tipos para bind_param
    $params = []; // Valores para bind_param

    // Filtragem por categoria
    if ($icat != "") {
        $innerJoinItCat = "INNER JOIN itemCategoria ic ON l.idLit = ic.idLit";
        $innerJoinCat = "INNER JOIN Categoria c ON ic.idCategoria = c.idCategoria";
        $where .= "sha1(ic.idCategoria) = ? ";
        $types .= "s"; // Categoria é uma string hash (sha1)
        $params[] = $icat;
    }

    // Filtragem por título ou descrição
    if (!empty($search)) {
        if (!empty($where)) {
            $where .= "AND ";
        }
        $where .= "(l.titulo LIKE ? OR l.descricao LIKE ?)";
        $types .= "ss"; // Ambos são strings
        $params[] = "%$search%";
        $params[] = "%$search%";
    }

    // Status padrão
    if (!empty($where)) {
        $where = "WHERE $where AND l.$litBloqOuPriv";
    } else {
        $where = "WHERE l.$litBloqOuPriv";
    }

    // SQL final
    $sql = "
        SELECT l.idLit, l.titulo, l.urlCapa, u.nomeUsuario, u.nome,
               COUNT(v.idLit) AS qdeVerificacoes
        FROM Literatura l
        INNER JOIN usuario u ON l.idUsuario = u.idUsuario
        LEFT JOIN verificacao v ON l.idLit = v.idLit
        $innerJoinItCat
        $innerJoinCat
        $where
        GROUP BY l.idLit, l.titulo, l.urlCapa, u.nomeUsuario, u.nome
    ";

    // Preparar e executar a consulta
    $stmt = mysqli_prepare($conexao, $sql);
    if ($stmt) {
        if (!empty($params)) {
            // Bind dinâmico dos parâmetros
            $bindParams = array_merge([$types], $params);
            $refs = [];
            foreach ($bindParams as $key => $value) {
                $refs[$key] = &$bindParams[$key]; // Criar referência
            }
            call_user_func_array([$stmt, 'bind_param'], $refs);
        }

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Armazenar resultados
        $allResults = [];
        while ($dadosLit = mysqli_fetch_assoc($result)) {
            $dadosLit['img'] = $dadosLit['urlCapa'] 
                ? $dirCapa . $dadosLit['urlCapa'] 
                : "imagens/batata.png";
            $dadosLit['idLit'] = sha1($dadosLit['idLit']); // SHA1 no ID
            $allResults[] = $dadosLit;
        }

        // Fechar recursos
        mysqli_free_result($result);
        mysqli_stmt_close($stmt);

        // Filtragem adicional por categoria
        $dadosCatFiltrada = [];
        if ($icat != "") {
            $queryCatFiltrada = mysqli_query($conexao, "SELECT * FROM Categoria WHERE sha1(idCategoria) = '$IdCatSha1';");
            if ($queryCatFiltrada) {
                $dadosCatFiltrada = mysqli_fetch_assoc($queryCatFiltrada);
            }
        }

        return [$allResults, !empty($icat), !empty($search), count($allResults), $dadosCatFiltrada];
    } else {
        die('Erro na preparação da consulta: ' . mysqli_error($conexao));
    }
}


?>