<?php

require_once ('models/livroModel.php');

include_once ('Vlogin.php');
include_once("conexao.php");
include_once("configs.php");
include_once ('Vcli.php');
include_once('helperBD.php');

@$idLitSha1 = $_GET['i'];

$_SESSION['TSFAltCapa'] = bin2hex(random_bytes(32));
$_SESSION['TSFAltStAdm'] = bin2hex(random_bytes(32));
$_SESSION['TSFFavoritar'] = bin2hex(random_bytes(32));
$_SESSION['TSFLd'] = bin2hex(random_bytes(32));

list($dadosLit, $idLit, $haCapa, $litExiste) = selectLit($idLitSha1);
list($dadosItemCat, $txtSemCat) = selectCats($idLit);
list($dadosCapLit, $txtSemCap) = selectCapitulos($idLit);
$estiloBtnFavoritar = getFavorito($idLit);
$meuUsuario = meuPerfil($dadosLit);
$estaSeguindo = estaSeguindo($dadosLit);
$erro = @showMsg();

if (isset($_SESSION['litAtual']))
	{ unset($_SESSION['litAtual']); }

@$_SESSION['litAtual'] = $dadosLit['idLit'];

$_SESSION['rota'] = true;
include_once('livro.php');
unset($_SESSION['rota']);
?>