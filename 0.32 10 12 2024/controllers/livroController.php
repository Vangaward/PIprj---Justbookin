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
$_SESSION['TSFVerificaLit'] = bin2hex(random_bytes(32));

list($dadosLit, $idLit, $haCapa, $litExiste, $urlClassif) = selectLit($idLitSha1);
list($dadosItemCat, $txtSemCat) = selectCats($idLit);
list($dadosCapLit, $qtdeCapsTxt, $qtdeLinhs) = selectCapitulos($idLit);
$estiloBtnFavoritar = getFavorito($idLit);
$meuUsuario = meuPerfil($dadosLit);
$estaSeguindo = estaSeguindo($dadosLit);
list ($dadosVerif, $qtdeLinhasVerif, $qtdeLinhasVerifUsuario) = buscaVerificacaoes($idLit);
$curtido = buscaCurtidasLit($idLit);
$erro = @showMsg();

if (isset($_SESSION['litAtual']))
	{ unset($_SESSION['litAtual']); }

@$_SESSION['litAtual'] = $dadosLit['idLit'];


/*Scripts para comentários*/

$_SESSION['TSFNovoComent'] = bin2hex(random_bytes(32));
$_SESSION['TSFExcluiCo'] = bin2hex(random_bytes(32));
$_SESSION['TSFLikeDeslCom'] = bin2hex(random_bytes(32));

list($dadosCom, $dadosComLogado, $qtdComs) = buscarComentarios($idLit);
list($msgComentarios, $corErro) = showMsgComentarios();

/*Fim de*/

$_SESSION['rota'] = true;
include_once('livro.php');
unset($_SESSION['rota']);
?>