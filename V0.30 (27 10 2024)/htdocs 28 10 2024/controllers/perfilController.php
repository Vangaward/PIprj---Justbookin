<?php

require_once ('models/perfilModel.php');

include_once ('Vlogin.php');
include_once("conexao.php");
include_once("configs.php");

$_SESSION['TSFAltFotoPerfil'] = bin2hex(random_bytes(32));
$_SESSION['TSFAltBanner'] = bin2hex(random_bytes(32));

$lad = "asc"; //Filtros | Listar em asc ou desc

if (isset($_GET['lad']))
{
	if ($_GET['lad'] == "desc")
		$lad = $_GET['lad'];
	if ($_GET['lad'] == "asc")
		$lad = $_GET['lad'];
}

$idUserCripto = null;

if (isset($_GET['i']))
	$idUserCripto = $_GET['i'];

list($meuUsuario, $idUsuarioSha1) = isMeuUsuario($idUserCripto);
list($dadosUsuario, $numRowsqueryUsuario) = selectUsuario($idUsuarioSha1);
list($dadosLitPerfil, $qtdlits) = selectLits($idUsuarioSha1, $lad, $meuUsuario);
list($estaSeguindo, $qtdeSeguidores) = selectSeguidores($dadosUsuario);

$txtMsg = showMsg(@$_SESSION['perfilMsg']);

$_SESSION['rota'] = true;
include_once('perfil.php');
unset($_SESSION['rota']);

?>