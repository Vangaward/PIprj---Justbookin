<?php
include_once("conexao.php");
include_once('Vlogin.php');
include_once('configs.php');

function getTxtPesqusa()
{
	$txtPesquisa = "";
	if (isset($_GET['search']))
	{
		$txtPesquisa = $_GET['search'];
	}
	return $txtPesquisa;
}

function buscaCategorias()
{
	global $conexao;
	
	if (isset($_GET['icat'])){
	$IdCatSha1 = $_GET['icat'];
	}
	
	/*Categorias e categorias filtradas*/
	$queryCats = mysqli_query($conexao, "SELECT * FROM Categoria");
	if (!$queryCats)
	{
		echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
		die('<b>Query Inválida: </b>' . @mysqli_error($conexao));  
	}
	
	$dadosCategorias = mysqli_fetch_all($queryCats, MYSQLI_ASSOC);
	
	return $dadosCategorias;
}

?>