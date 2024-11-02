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
	$stmt = $conexao->prepare("SELECT l.idLit, l.idUsuario, l.views, l.descricao, l.titulo, l.urlCapa, l.dataLanc, l.dataEdit, l.status, l.urlPdf, 
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
	if ($numRows < 1)
	{
		die("Literatura não encontrada");
	}
	
    if ($dadosLit['urlFotoPerfil']) //Verifica se há valor na string
	{
        $dadosLit['urlFotoPerfil'] = $dirFotoPerfil . $dadosLit['urlFotoPerfil'];
    } else {
        $dadosLit['urlFotoPerfil'] = "imagens/User.png";
    }
	
    $haCapa = false;
    if ($dadosLit['urlCapa'] == "") {
        $dadosLit['imgCapa'] = "imagens/batata.png";
    } else {
        $dadosLit['imgCapa'] = $dirCapa . $dadosLit['urlCapa'];
        $haCapa = true;
    }

	$dadosLit['dataLanc'] = (new DateTime($dadosLit['dataLanc']))->format('d/m/Y H:i');
	$dadosLit['dataEdit'] = (new DateTime($dadosLit['dataEdit']))->format('d/m/Y H:i');

	$dadosLit['idUsuarioSha1'] = sha1($dadosLit['idUsuario']);
	
	return [$dadosLit, $idLit, $haCapa];
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
	$txtSemCap = "";
	$queryCapLit = mysqli_query($conexao, "SELECT * from capituloLit where idLit = '$idLit' ORDER BY numCapitulo asc;");
	if (!$queryCapLit)
	{
		echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
		die('<b>Query Inválida: </b>' . @mysqli_error($conexao));
	}
	if(mysqli_num_rows($queryCapLit) <=0)
	{
		$txtSemCap = "Essa literatura não possui capítulos";
	}
	
	while ($row = mysqli_fetch_array($queryCapLit)) {
            $dadosCapLit[] = $row; // Adicionar cada linha ao array
        }
	
	return [$dadosCapLit, $txtSemCap];
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

function showMsg()
{
	$erro;
	if (isset($_SESSION['msgFav'])) //magFav = mensagem de favoritar
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
	return $erro;
}

?>