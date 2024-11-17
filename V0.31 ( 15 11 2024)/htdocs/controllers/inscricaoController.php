<?php

require_once('models/inscricaoModel.php');

include_once("conexao.php");
include_once('Vlogin.php');
include_once('rsnl.php');

$dadosLit = buscaLits();

$_SESSION['rota'] = true;
require_once "inscricao.php";
unset($_SESSION['rota']);

?>