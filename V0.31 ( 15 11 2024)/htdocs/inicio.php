<?php
require_once 'classes/Cripto.php';
include_once('forcaRota.php');
//require_once "controllers/inicioController.php";

/*function mf($valor)
{
	return $valor;
}
$teste = "0a57cb53ba59c46fc4b692527a38a87c78d84028";

//$queryTeste = mysqli_query($conexao, "SELECT * FROM Literatura where password_hash('idLit', PASSWORD_BCRYPT) = '$teste'");//hash('sha1', $valor);

$queryTeste = mysqli_query($conexao, "SELECT * FROM Literatura where " . (new Cripto(""))->getTc() . "(idLit) = '$teste'");


$dadosTeste = mysqli_fetch_array($queryTeste);

die($dadosTeste['titulo']);
*/
//
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include_once("detalhesHead.php"); ?>
    <title>JustBookIn</title>
	<link rel="stylesheet" href="Balacowork/Balacowork.css">
    <link rel="stylesheet" href="Styles/inicio.css">
    <link rel="stylesheet" href="Styles/fonte.css">
    <link rel="stylesheet" href="Styles/card.css">
</head>

<body id="bodyInicio">
    <?php //include_once("splashScreen.php"); ?>
    <?php include_once("header.php"); ?>
    
	<?
		//echo (new Cripto(1))->getCripto();
	?>
	
    <main class="conteudo">
        <div class="inicio" id="inicioId">
            <div>
                <?php include_once('barraPesquisa.php'); ?>
            </div>
			<div>
				<label class="tituloPagina">Top 10 mais curtidas:</label>
				<div id="idTopLits" class="litsHoriz">
				   <?php foreach ($dadosLitTop as $literatura){
						include("cardLivro.php"); 
					} ?>
				</div><!-- litsHoriz -->
			</div>
			<div>
				<label class="tituloPagina">Top 10 mais visualizadas:</label>
				<div id="idMaisViewsLits" class="litsHoriz">
					<?php foreach ($dadosTopViews as $literatura) {
						include("cardLivro.php"); 
					} ?>
				</div><!-- litsHoriz -->
			</div>
			<div>
				<label class="tituloPagina">Top 10 mais favoritadas:</label>
				<div id="idMaisViewsLits" class="litsHoriz">
					<?php  foreach ($dadosMaisFavs as $literatura){
						include("cardLivro.php"); 
					} ?>
				</div><!-- litsHoriz -->
			</div>
			<div>
				<label class="tituloPagina">Acabaram de sair do forno:</label>
				<div id="idMaisViewsLits" class="litsHoriz">
					<?php  foreach ($dadosMaisRecentes as $literatura){
						include("cardLivro.php"); 
					} ?>
				</div><!-- litsHoriz -->
			</div>
			<div>
				<label class="tituloPagina">Todas as literaturas:</label>
				<div id="idTodasLits" class="litsHoriz">
					<?php  foreach ($dadosTodas as $literatura){
						include("cardLivro.php"); 
					} ?>
				</div><!-- litsHoriz -->
			</div>
        </div><!-- inicio -->
    </main>

    <div class="clearfix"></div>
    <?php include_once("footer.php"); ?>
	
	<?php echo "<!--\n" .  $nomeArteAscci . "\n\n" . $ArteAscci . "\n\n-->"; ?>
	
</body>
</html>

<script src="bibliotecas/jquery.js"></script>
<script language="Javascript" src="js/inicio.js"></script>