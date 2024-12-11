<?php

require_once ('models/leitorModel.php');

include_once ('Vlogin.php');
include_once("conexao.php");
include_once("configs.php");
include_once ('Vcli.php');
include_once('helperBD.php');


$idLitSha1 = $_GET['i'];

$dadosLit = buscaLit($idLitSha1);
$meuUsuario = isMeuUsuario($dadosLit);
list($temCaps, $linkBtnCapAnt, $linkBtnCapProx, $dadosCapLit, $urlCapVazia, $dadosCapLitProxCap, $haAntCap, $haProxCap) = buscaCapitulos($idLitSha1);

histLogin($dadosLit);
	
$_SESSION['ajaxLeitorViews'] = $dadosLit['idLit']; //Variável usada pelo arquivo ajaxBDViewsLeitor.php
		
$_SESSION['rota'] = true;
require_once "leitor.php";
unset($_SESSION['rota']);

?>