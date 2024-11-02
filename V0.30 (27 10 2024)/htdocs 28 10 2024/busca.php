<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>JustBookIn</title>
	<?php include_once("detalhesHead.php");?>
	<link rel="stylesheet" href="Balacowork/Balacowork.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

</head>
<?php include_once("Styles/busca.css");?>
<?php include_once("Styles/fonte.css");?>
<body>
<?php include_once('forcaRota.php'); ?>
<?php include_once('header.php');?>

<main class="conteudo">
<?php include_once('barraPesquisa.php'); ?>
<br>
<?php if ($haCatsFiltro){?>

<div class="texto">Exibindo somente: <label class="lblNomeCategoriaFiltro"><?php echo $dadosCatFiltrada['nomeCategoria']; ?></label></div>

<?php } else if($haSearch){?>
<label class="texto">Exibindo: Todas as categorias <button class="btnRev" onclick="filtrarCat('')"><?php include('icones/Cancelar.svg'); ?></button></label>
<?php } ?>

<?php if ($search != null){ ?>
<div class="litsHoriz">
	<?php foreach ($dadosPerfilsArray as $dadosPerfils) {?>
			<a class="aInscricoes" href="perfil.php?i=<?php echo $dadosPerfils['idUsuarioCripto']; ?>">
				<img class="imgUserBuscado" src="<?php echo $dadosPerfils['fotoECaminhoPerfil']; ?>"><?php echo $dadosPerfils['nomeUsuario']; ?>
			</a>
	<?php } ?>
</div><!--litsHoriz-->

<?php } ?>

<div class="row">

<?php include_once('Styles/card.css');?>

<?php if ($haSearch || $haCatsFiltro){
	foreach ($literaturas as $literatura)
	{ ?>
		<div class="col-6 col-sm-4 col-md-3 col-lg-2">
		<?php include("cardLivro.php"); ?>
		</div>
<?php } }?>

</div><!--row-->

<?php if ($haSearch == false && !$haCatsFiltro){ ?>
<center><label class="lblNaoHaSearch">Digite algo na barra de pesquisa para buscar por literaturas!</label></center>
<?php }
if ($qtdeLinhasQueryLit <=0 && $haSearch == true || $qtdeLinhasQueryLit <=0 && $haCatsFiltro == true)
{ ?>
	<center>
	<label class="lblNaoHaSearch">Nenhum resultado encontrado para a pesquisa.<br>Tente digitar algo diferente ou alterar os filtros.</label>
	<br><img class="imgSemComents" src="imagens/semResultados.jpg">
	</center>
<?php } ?>


</main>
</body>
