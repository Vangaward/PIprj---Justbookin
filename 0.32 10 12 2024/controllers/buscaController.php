<?php

require_once ('models/buscaModel.php');
require_once('models/barraPesquisaModel.php');

include_once('Vlogin.php');
include_once('Vcli.php');

$search = ".";
$icat = "";
if (isset($_GET['search']))
	$search = $_GET['search'];

if (isset($_GET['icat']))
	$icat = $_GET['icat'];
else if (!isset($_GET['icat']) and isset($_GET['icat']))
	$search = "";

$dadosPerfilsArray = selectUsuarios($search);

list($literaturas, $haCatsFiltro, $haSearch, $qtdeLinhasQueryLit, $dadosCatFiltrada) = selectLits($search, $icat);

/*Barra de pesquisa*/
$dadosCategorias = buscaCategorias();
$txtPesquisa = getTxtPesqusa();
/*Fim de*/

$_SESSION['rota'] = true;
require_once "busca.php";
unset($_SESSION['rota']);
?>