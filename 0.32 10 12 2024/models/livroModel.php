<?php

require_once("conexao.php");
require_once("helperBD.php");
require_once("configs.php");
include_once ('Vlogin.php');

function selectLit($idLitSha1)
{
	global $conexao;
	global $dirCapa;
	global $dirFotoPerfil;
	$stmt = $conexao->prepare("SELECT l.idLit, l.idUsuario, l.views, l.idClassificacao, l.descricao, l.titulo, l.urlCapa, l.dataLanc, l.dataEdit, l.status, l.urlPdf, 
	   u.nome, u.nomeUsuario, u.urlFotoPerfil 
	   FROM Literatura l 
	   INNER JOIN usuario u ON l.idUsuario = u.idUsuario 
	   WHERE sha1(l.idLit) = ?");
	$stmt->bind_param('s', $idLitSha1);
	$stmt->execute();
	$result = $stmt->get_result();

	if (!$result) {
		echo '<input type="button" onclick="window.location=\'index.php\';" value="Voltar"><br><br>';
		die('<b>Query Inválida:</b> ' . $conexao->error);
	}
	$numRows = $result->num_rows;
	$dadosLit = $result->fetch_array();
	$stmt->close();
	@$idLit = $dadosLit['idLit'];
	$haCapa = false;
	$litExiste = true;
	$urlClassif = "";
	if ($numRows < 1)
	{
		$litExiste = false;
	}
	else
	{
		if ($dadosLit['urlFotoPerfil']) //Verifica se há valor na string
		{
			$dadosLit['urlFotoPerfil'] = $dirFotoPerfil . $dadosLit['urlFotoPerfil'];
		} else {
			$dadosLit['urlFotoPerfil'] = "imagens/User.png";
		}
		if ($dadosLit['urlCapa'] == "") {
			$dadosLit['imgCapa'] = "imagens/batata.png";
		} else {
			$dadosLit['imgCapa'] = $dirCapa . $dadosLit['urlCapa'];
			$haCapa = true;
		}
		
		switch ($dadosLit['idClassificacao']) {
		case 1:
			$urlClassif = "icones/AL.svg";
			break;
		case 2:
			$urlClassif = "icones/A10.svg";
			break;
		case 3:
			$urlClassif = "icones/A12.svg";
			break;
		case 4:
			$urlClassif = "icones/A14.svg";
			break;
		case 5:
			$urlClassif = "icones/A16.svg";
			break;
		case 6:
			$urlClassif = "icones/A18.svg";
			break;
}

		$dadosLit['dataLanc'] = (new DateTime($dadosLit['dataLanc']))->format('d/m/Y H:i');
		$dadosLit['dataEdit'] = (new DateTime($dadosLit['dataEdit']))->format('d/m/Y H:i');
		
		/*if ($dadosLit['status'] > 0 && $dadosLogin['tipoConta'] != 1 || $dadosLit['status'] > 0 && !meuPerfil($dadosLit))
		{
			$dadosLit['titulo'] = "Literatura bloqueada ou privada.";
		}*/

		$dadosLit['idUsuarioSha1'] = sha1($dadosLit['idUsuario']);
	}
	return [$dadosLit, $idLit, $haCapa, $litExiste, $urlClassif];
}

function buscaCurtidasLit($idLit)
{
	global $conexao, $dadosLogin, $logado;
	$curtido = "vazio";
	if ($logado == 1)
	{
		$stmt = $conexao->prepare("SELECT * from curtidasLit where idUsuario = ? and idLit = ?");
		$stmt->bind_param('ss', $dadosLogin['idUsuario'], $idLit);
		$stmt->execute();
		$result = $stmt->get_result();
		$dadosCurtida = $result->fetch_array();
		if (!$result) {
			echo '<input type="button" onclick="window.location=\'index.php\';" value="Voltar"><br><br>';
			die('<b>Query Inválida:</b> ' . $conexao->error);
		}
		$numRows = $result->num_rows;
		
		if ($numRows > 0)
		{
			if ($dadosCurtida['curtida'] == 1)
				$curtido = 1;
			else if ($dadosCurtida['curtida'] == 0)
				$curtido = 0;
		}
	}
	return $curtido;
}

function selectCats($idLit)
{
    global $conexao;
    $txtSemCat = "";
    $dadosItemCat = [];

    // Executar a consulta
    $queryItemCat = mysqli_query($conexao, "SELECT c.nomeCategoria, c.idCategoria FROM itemCategoria ic
        INNER JOIN Categoria c ON ic.idCategoria = c.idCategoria
        WHERE idLit = '$idLit';");

    // Verificar se a consulta falhou
    if (!$queryItemCat) {
        echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
        die('<b>Query Inválida: </b>' . @mysqli_error($conexao));  
    }

    // Verificar se há resultados
    if (mysqli_num_rows($queryItemCat) <= 0) {
        $txtSemCat = "Essa literatura não possui categorias";
    } else {
        // Usar um loop para buscar todas as linhas de resultado
        while ($row = mysqli_fetch_array($queryItemCat)) {
            $dadosItemCat[] = $row; // Adicionar cada linha ao array
        }
    }

    return [$dadosItemCat, $txtSemCat];
}

function selectCapitulos($idLit)
{
	global $conexao;
	$dadosCapLit = [];
	$qtdeCapsTxt = "";
	$queryCapLit = mysqli_query($conexao, "SELECT * from capituloLit where idLit = '$idLit' ORDER BY numCapitulo asc;");
	if (!$queryCapLit)
	{
		echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
		die('<b>Query Inválida: </b>' . @mysqli_error($conexao));
	}
	$qtdeLinhs = mysqli_num_rows($queryCapLit);
	if($qtdeLinhs <=0)
		$qtdeCapsTxt = "Essa literatura não possui capítulos";
	else
		$qtdeCapsTxt = $qtdeLinhs;
	
	while ($row = mysqli_fetch_array($queryCapLit)) {
            $dadosCapLit[] = $row; // Adicionar cada linha ao array
        }
	
	return [$dadosCapLit, $qtdeCapsTxt, $qtdeLinhs];
}
function getFavorito($idLit)
{
	global $conexao;
	global $logado;
	global $dadosLogin;
	$estiloBtnFavoritar = null;
	if ($logado == 1)
	{
		//queryFavoritos está aqui para o front-end do botão de favoritos
		$estiloBtnFavoritar;
		$idUsuario = $dadosLogin['idUsuario'];
		$queryFavoritos = mysqli_query($conexao, "SELECT * from favorito where idLit = '$idLit' and idUsuario = '$idUsuario';");
		if (!$queryFavoritos) {
			$_SESSION['msgFav'] = 1;
			header('Location: livro.php?i=' . $idLitSha1);
		die ("Houve um erro ao carregar os recursos necessários. #1");
			}
		if (mysqli_num_rows($queryFavoritos) > 0)
		{
			$estiloBtnFavoritar = 1;
		}else{$estiloBtnFavoritar = 0;}
	}
	
	return $estiloBtnFavoritar;
}

function meuPerfil($dadosLit) /*Verificar se o perfil é do usuário logado*/
{
	global $conexao;
	global $logado;
	global $dadosLogin;
	$meuUsuario = false;
	if ($logado == 1)
	{
		if ($dadosLit['idUsuario'] == $dadosLogin['idUsuario'])
		{
			$meuUsuario = true;
		}
	}
	
	return $meuUsuario;
}

function estaSeguindo($dadosLit)
{
	global $conexao;
	global $logado;
	global $dadosLogin;
	$estaSeguindo = false;
	if ($logado == 1){
		$idUsuarioLogado = $dadosLogin['idUsuario'];
		$idUsuarioSeguido = $dadosLit['idUsuario'];
		$queryInscrito = mysqli_query($conexao, "SELECT * from seguidos where idUsuario = '$idUsuarioLogado' && idUsuarioSeguido = '$idUsuarioSeguido'");
		if (mysqli_num_rows($queryInscrito) > 0)
		{$estaSeguindo = true; }
	}
	return $estaSeguindo;
}

function buscaVerificacaoes($idLit)
{
	global $conexao, $dadosLogin, $logado;
	$qtdeLinhasVerifUsuario = null;
	
	/* Verifica se o usuário logado já verificou a literatura */
	if ($logado == 1){
	$stmt = $conexao->prepare("SELECT * FROM verificacao WHERE idLit = ? and idUsuario = ?");
	$stmt->bind_param("ss", $idLit, $dadosLogin['idUsuario']);
	$stmt->execute();
	$result = $stmt->get_result();
	$qtdeLinhasVerifUsuario = $result->num_rows;
	$dadosVerifUsuario = $result->fetch_all(MYSQLI_ASSOC);
	$stmt->close();
	}

	/* Verifica se alguma editora já verificou a literatura */
	$stmt = $conexao->prepare("SELECT u.nomeUsuario, u.idUsuario, v.data 
		FROM verificacao v
		INNER JOIN usuario u ON u.idUsuario = v.idUsuario
		WHERE idLit = ?;
	");
	$stmt->bind_param("s", $idLit);
	$stmt->execute();
	$result = $stmt->get_result();
	$qtdeLinhasVerif = $result->num_rows;
	$dadosVerif = $result->fetch_all(MYSQLI_ASSOC);
	$stmt->close();
	
	foreach ($dadosVerif as &$verificacao) {
        $verificacao['data'] = date("d/m/Y", strtotime($verificacao['data']));
		$verificacao['idUsuarioCripto'] = sha1($verificacao['idUsuario']);
    }

	return [$dadosVerif, $qtdeLinhasVerif, $qtdeLinhasVerifUsuario];
}

function showMsg()
{
	$erro;
	if (isset($_SESSION['msgFav'])) //msgFav = mensagem de favoritar
	{
		if ($_SESSION['msgFav'] == 1)
		{
			$erro = "Houve um erro inesperado ao tentar favoritar a literatura.";
		}
		else if ($_SESSION['msgFav'] == 4)
		{
			$erro = "Houve um erro inesperado ao tentar desfavoritar a literatura.";
		}
		else if ($_SESSION['msgFav'] == 5)
		{
			$erro = "Houve um erro com o token";
		}
		unset($_SESSION['msgFav']);
	}
	/**/
	if (isset($_SESSION['msgLike']))
	{
		if ($_SESSION['msgLike'] == 1)
		{
			$erro = "Houve um erro inesperado, tente novamente mais tarde.";
		}
		unset($_SESSION['msgLike']);
	}
	if (isset($_SESSION['msgEditar']))
	{
		if ($_SESSION['msgEditar'] == 1)
		{
			$erro = "Sua literatura está bloqueada, não é possível editá-la";
		}
		unset($_SESSION['msgEditar']);
	}
	if (isset($_SESSION['editCapa']))
	{
		if ($_SESSION['editCapa'] == 1)
		$erro = "A extensão do arquivo não é permitida. Selecione apenas arquivos .jpg, .jpeg ou .png";
		else if ($_SESSION['editCapa'] == 2)
		$erro = "O nome do arquivo é muito grande. Por favor, escolha um nome de arquivo mais curto. (Máximo de 41 caracteres)";
		else if ($_SESSION['editCapa'] == 3)
		$erro = "Houve um erro inesperado por parte do servidor. Por favor, tente novamente mais tarde.";
		else if ($_SESSION['editCapa'] == 4)
			$erro = "Sua literatura está bloqueada, não é possível aterar a capa.";
		else if ($_SESSION['editCapa'] == 5)
			$erro = "Houve um problema com o token.";
		unset($_SESSION['editCapa']);
	}
	if (isset($_SESSION['msgVerificaLit']))
	{
		if ($_SESSION['msgVerificaLit'] == 1)
			$erro = "Houve um problema com o token.";
		else if ($_SESSION['msgVerificaLit'] == 2)
			$erro = "Houve um problema inesperado. Por favor tente novamente mais tarde";
		else if ($_SESSION['msgVerificaLit'] == 3)
			$erro = "A literatura foi verificada publicamente com sucesso!";
		else if ($_SESSION['msgVerificaLit'] == 4)
			$erro = "A verificação pública da sua editora para esta literatura foi removida com sucesso!";
		unset($_SESSION['msgVerificaLit']);
	}
	return $erro;
}

function buscarComentarios($idLit)
{
    global $conexao, $logado, $dadosLogin;

    // Inicializa as variáveis
    $dadosCom = [];
    $dadosComLogado = [];
    $qtdComs = 0;

    if ($logado == 0) { // Se for 0 busca todos os comentários normalmente
        $queryCom = mysqli_query($conexao, "SELECT u.urlFotoPerfil, u.nomeUsuario, u.idUsuario, c.dataCom, c.idComentario, c.txtComentario, u.nome, u.tipoConta,
            COALESCE(SUM(CASE WHEN cc.curtida = 1 THEN 1 ELSE 0 END), 0) AS qtdeLikes,
            COALESCE(SUM(CASE WHEN cc.curtida = 0 THEN 1 ELSE 0 END), 0) AS qtdeDeslikes
            FROM comentarios c
            INNER JOIN usuario u ON c.idUsuario = u.idUsuario
            LEFT JOIN ComCurtida cc ON c.idComentario = cc.idComentario
            WHERE c.idLit = '$idLit'
            GROUP BY u.urlFotoPerfil, u.nomeUsuario, u.idUsuario, c.dataCom, c.txtComentario, u.nome
            ORDER BY c.dataCom DESC");

        if (!$queryCom) {
            echo '<input type="button" onclick="window.location=\'index.php\';" value="Voltar"><br><br>';
            die('<b>Query Inválida:</b>' . mysqli_error($conexao));
        }

        $dadosCom = mysqli_fetch_all($queryCom, MYSQLI_ASSOC);
        $qtdComs = mysqli_num_rows($queryCom);
    }

    if ($logado == 1) { // Se for 1, faz buscas separadas
        $idUsuarioLogado = $dadosLogin['idUsuario'];

        // Seleciona todos os comentários, exceto os do usuário logado
        $queryCom = mysqli_query($conexao, "SELECT u.urlFotoPerfil, u.nomeUsuario, u.idUsuario, c.dataCom, c.idComentario, c.txtComentario, u.nome, u.tipoConta,
            COALESCE(SUM(CASE WHEN cc.curtida = 1 THEN 1 ELSE 0 END), 0) AS qtdeLikes,
            COALESCE(SUM(CASE WHEN cc.curtida = 0 THEN 1 ELSE 0 END), 0) AS qtdeDeslikes
            FROM comentarios c
            INNER JOIN usuario u ON c.idUsuario = u.idUsuario
            LEFT JOIN ComCurtida cc ON c.idComentario = cc.idComentario
            WHERE c.idLit = '$idLit' AND c.idUsuario != '$idUsuarioLogado'
            GROUP BY u.urlFotoPerfil, u.nomeUsuario, u.idUsuario, c.dataCom, c.txtComentario, u.nome
            ORDER BY c.dataCom DESC");

        // Seleciona apenas os comentários do usuário logado
        $queryComLogado = mysqli_query($conexao, "SELECT u.urlFotoPerfil, u.nomeUsuario, u.idUsuario, c.dataCom, c.idComentario, c.txtComentario, u.nome, u.tipoConta,
            COALESCE(SUM(CASE WHEN cc.curtida = 1 THEN 1 ELSE 0 END), 0) AS qtdeLikes,
            COALESCE(SUM(CASE WHEN cc.curtida = 0 THEN 1 ELSE 0 END), 0) AS qtdeDeslikes
            FROM comentarios c
            INNER JOIN usuario u ON c.idUsuario = u.idUsuario
            LEFT JOIN ComCurtida cc ON c.idComentario = cc.idComentario
            WHERE c.idLit = '$idLit' AND c.idUsuario = '$idUsuarioLogado'
            GROUP BY u.urlFotoPerfil, u.nomeUsuario, u.idUsuario, c.dataCom, c.txtComentario, u.nome
            ORDER BY c.dataCom DESC");

        if (!$queryCom || !$queryComLogado) {
            echo '<input type="button" onclick="window.location=\'index.php\';" value="Voltar"><br><br>';
            die('<b>Query Inválida:</b>' . mysqli_error($conexao));
        }

        $dadosCom = mysqli_fetch_all($queryCom, MYSQLI_ASSOC);
        $dadosComLogado = mysqli_fetch_all($queryComLogado, MYSQLI_ASSOC);
        $qtdComs = mysqli_num_rows($queryCom) + mysqli_num_rows($queryComLogado);
    }

    $_SESSION['idLitAtualBDexcuirCom'] = $idLit;

	foreach ($dadosCom as &$comentario)
	{
        if ($comentario['urlFotoPerfil'] == "")
			{$img = "imagens/User.png";}else{$img = "fotosPerfil/" . $comentario['urlFotoPerfil'];}
		
			$comentario['caminhoFotoPerfil'] = $img;
			$comentario['idUsuarioCripto'] = sha1($comentario['idUsuario']);
    }
	
	foreach ($dadosComLogado as &$comentario)
	{
        if ($comentario['urlFotoPerfil'] == "")
			{$img = "imagens/User.png";}else{$img = "fotosPerfil/" . $comentario['urlFotoPerfil'];}
		
			$comentario['caminhoFotoPerfil'] = $img;
			$comentario['idUsuarioCripto'] = sha1($comentario['idUsuario']);
    }

    // Retorna as variáveis separadamente
    return [$dadosCom, $dadosComLogado, $qtdComs];
}

function showMsgComentarios()
{
	$msgComentarios = null;
	$corErro = null;
	if (isset($_SESSION['msgComent']))
	{
		if ($_SESSION['msgComent'] == 1)
		{
			$msgComentarios = "Comentário publicado com sucesso";
			$corErro = "success";
		}
		if ($_SESSION['msgComent'] == 2)
		{
			$msgComentarios = "Houve um erro ao inserir o comentário, tente novamente mais tarde.";
			$corErro = "danger";
		}
		if ($_SESSION['msgComent'] == 3)
		{
			$msgComentarios = "Houve um erro ao excluir o comentário, tente novamente mais tarde.";
			$corErro = "danger";
		}
		if ($_SESSION['msgComent'] == 4)
		{
			$msgComentarios = "Comentário excluido com sucesso";
			$corErro = "warning";
		}
		if ($_SESSION['msgComent'] == 5)
		{
			$msgComentarios = "Houve um problema com o token";
			$corErro = "danger";
		}
		if ($_SESSION['msgComent'] == 6)
		{
			$msgComentarios = "Houve um erro ao tentar avaliar o comentário";
			$corErro = "danger";
		}
		if ($_SESSION['msgComent'] == 7)
		{
			$msgComentarios = "Houve um erro com o Token";
			$corErro = "danger";
		}
		
		unset($_SESSION['msgComent']);
	}
	return [$msgComentarios, $corErro];
}

?>