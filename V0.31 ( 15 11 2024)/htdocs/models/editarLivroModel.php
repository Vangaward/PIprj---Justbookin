<?php

require_once("conexao.php");
require_once("helperBD.php");
require_once("configs.php");

function buscaLit($idLiSha1)
{
	global $conexao;
	global $dadosLogin;
	$stmt = $conexao->prepare("SELECT * FROM Literatura WHERE sha1(idLit) = ?");
	if (!$stmt) {
		die("Houve um erro inesperado. #1");
	}
	$stmt->bind_param("s", $idLiSha1);
	$stmt->execute();
	$result = $stmt->get_result();

	if (!$result) {
		die("Houve um erro inesperado. #1");
	}
	
	$dadosLit = $result->fetch_array(MYSQLI_ASSOC);
	$stmt->close();

	if ($dadosLit['idUsuario'] != $dadosLogin['idUsuario'])
	{
		header("Location: index.php");
	}
	/*fim de*/

	if ($dadosLit['status'] == 2)
	{
		$_SESSION['msgEditar'] = 1;
		header('Location: livro.php?i=' . $idLiSha1);
		die();
	}
	
	return $dadosLit;
}

function buscaCaps($idLiSha1)
{
	global $conexao;
	$stmt = $conexao->prepare("SELECT * FROM capituloLit WHERE sha1(idLit) = ? order by numCapitulo asc");
	if (!$stmt) {
		die("Houve um erro inesperado. #3");
	}
	$stmt->bind_param("s", $idLiSha1);
	$stmt->execute();
	$result = $stmt->get_result();
	if (!$result) {
		die("Houve um erro inesperado. #3");
	}
	$dadosCaps = $result->fetch_all(MYSQLI_ASSOC);
	$qtdeCaps = $result->num_rows;
	$stmt->close();
	
	return [$dadosCaps, $qtdeCaps];
}

function buscaCat($idLiSha1)
{
    global $conexao;
    $queryCategoria = mysqli_query($conexao, "SELECT * FROM Categoria");
    if (!$queryCategoria) {
        echo ("Houve um erro inesperado. #2");
    }
    $dadosCategoria = mysqli_fetch_all($queryCategoria, MYSQLI_ASSOC);
    $dadosItemCat = buscaItemCat($idLiSha1, $dadosCategoria);

    foreach ($dadosCategoria as &$categoria) {
        $categoria['idCatCripto'] = sha1($categoria['idCategoria']);
        $categoria['isChecked'] = false;

        foreach ($dadosItemCat as $itemCat)
		{
            if ($itemCat['idCategoria'] == $categoria['idCategoria'])
			{
				$categoria['isChecked'] = true;
				break;
			}
        }
    }

    return $dadosCategoria;
}

function buscaItemCat($idLiSha1, $dadosCategoria)
{
    global $conexao;
    $stmt = $conexao->prepare("SELECT * FROM itemCategoria WHERE sha1(idLit) = ?");
    if (!$stmt) {
        die("Houve um erro inesperado. #5");
    }
    $stmt->bind_param("s", $idLiSha1);
    $stmt->execute();
    $queryItemCat = $stmt->get_result();

    if (!$queryItemCat) {
        die("Houve um erro inesperado. #5");
    }

    $dadosItemCat = mysqli_fetch_all($queryItemCat, MYSQLI_ASSOC);
    $stmt->close();

    return $dadosItemCat;
}
function buscaClassificacao()
{
	global $conexao;
	$stmt = $conexao->prepare("SELECT * FROM classificacao");
	$stmt->execute();
	$result = $stmt->get_result();
	$dadosClassif = $result->fetch_all(MYSQLI_ASSOC);
	$stmt->close();
	
	return $dadosClassif;
}

?>