<?php
include_once('Vlogin.php');
include_once('rsnl.php');
include_once('configs.php');

include_once('models/historicoModel.php');

list($dadosLit, $qtdLits, $txtQtdLits) = buscaHist();

$_SESSION['rota'] = true;
require_once "historico.php";
unset($_SESSION['rota']);
?>