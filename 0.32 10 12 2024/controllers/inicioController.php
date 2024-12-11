<?php

require_once ('models/inicioModel.php');
require_once('models/barraPesquisaModel.php');
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
list($dadosVerificRecentes, $txtLitVerificada) = selectVerificRecentes();
$dadosTodas = selectAll();
list($ArteAscci, $nomeArteAscci) = arteAscii();

/*Barra de pesquisa*/
$dadosCategorias = buscaCategorias();
$txtPesquisa = getTxtPesqusa();
/*Fim de*/

if (!selectTopLike() || !selectAll()) {
    echo '<input type="button" onclick="window.location=\'index.php\';" value="Voltar"><br><br>';
    die('<b>Query Inválida:</b>');  
}

$_SESSION['rota'] = true;
include_once('inicio.php');
unset($_SESSION['rota']);