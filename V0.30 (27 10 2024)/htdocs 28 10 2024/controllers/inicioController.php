<?php

require_once ('models/inicioModel.php');

include_once('Vlogin.php');
include_once('Vcli.php');

$splashScreen = false;

if (!isset($_GET['splash'])) {
    $splashScreen = false; //não mexer aqui
}

$dadosLitTop = selectTopLike();
$dadosTopViews = selectMaisViews();
$dadosMaisFavs = selectMaisFavs();
$dadosMaisRecentes = selectMaisRecentes();
$dadosTodas = selectAll();
list($ArteAscci, $nomeArteAscci) = arteAscii();

if (!selectTopLike() || !selectAll()) {
    echo '<input type="button" onclick="window.location=\'index.php\';" value="Voltar"><br><br>';
    die('<b>Query Inválida:</b>');  
}

$_SESSION['rota'] = true;
include_once('inicio.php');
unset($_SESSION['rota']);