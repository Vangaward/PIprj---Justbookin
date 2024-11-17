<?php

require_once('models/alterarSenhaModel.php');

include_once ('conexao.php');
include_once ('Vlogin.php');
include_once ('Vcli.php');
include_once ('rsnl.php');

$_SESSION['TSFAltSenha'] = bin2hex(random_bytes(32));

$txtMsg = msg();

$_SESSION['rota'] = true;
require_once "alterarSenha.php";
unset($_SESSION['rota']);

?>