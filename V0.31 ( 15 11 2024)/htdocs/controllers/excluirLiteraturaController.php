<?php

require_once ('models/excluirLiteraturaModel.php');

include_once ('conexao.php');
include_once ('Vlogin.php');
include_once ('Vcli.php');
include_once ('rsnl.php');

$idLitSha1 = $_GET['i'];

$_SESSION['TSFDeletarLit'] = bin2hex(random_bytes(32));

$dadosLit = buscaLit($idLitSha1);
$erro = getErro();

$_SESSION['rota'] = true;
include_once('excluirLiteratura.php');
unset($_SESSION['rota']);

?>