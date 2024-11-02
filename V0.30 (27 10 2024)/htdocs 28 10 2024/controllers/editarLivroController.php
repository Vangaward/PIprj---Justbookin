<?php

require_once('models/editarLivroModel.php');

include_once('conexao.php');
include_once('rsnl.php');
include_once('Vcli.php');
include_once('configs.php');

$idLiSha1 = $_GET['i'];
$_SESSION['TSFEditLit'] = bin2hex(random_bytes(32));

$dadosLit = buscaLit($idLiSha1);
list($dadosCaps, $qtdeCaps) = buscaCaps($idLiSha1);
$dadosCategoria = buscaCat($idLiSha1);

$_SESSION['rota'] = true;
require_once "editarLivro.php";
unset($_SESSION['rota']);
?>