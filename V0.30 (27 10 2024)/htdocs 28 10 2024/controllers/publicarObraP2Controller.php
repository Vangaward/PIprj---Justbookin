<?php

include_once ('conexao.php');
include_once ('Vlogin.php');
include_once ('Vcli.php');
include_once('rsnl.php');

$_SESSION['TSFPublicaLitP2'] = bin2hex(random_bytes(32));
require_once('models/publicarObraP2Model.php');

if (!isset($_POST['publicarObraP1Form']))
{
	header('Location: publicarObraP1.php');
	exit;
}
	
$dadosCats = getCategorias();
list($qtdPaginas, $nomeArquivoPDF, $dadosArquivoPDF, $nomeArquivoCapa, $dadosArquivoCapa) = validaArquivos();
list($txtseletorCapitulos, $txtCapitulosPlural) = formataTxtCapitulos($qtdPaginas);

$_SESSION['rota'] = true;
include_once('publicarObraP2.php');
unset($_SESSION['rota']);

?>