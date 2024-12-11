<?php

require_once('models/publicarObraP1Model.php');

include_once('conexao.php');
include_once('Vlogin.php');
include_once('Vcli.php');
include_once('rsnl.php');

$msgErro = getMensagem();

$_SESSION['rota'] = true;
include_once('publicarObraP1.php');
unset($_SESSION['rota']);

?>