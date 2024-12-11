<?php include_once('forcaRota.php'); ?>

<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once ("b.php"); ?>
    <title>Favoritos | JustBookIn</title>
	<link rel="stylesheet" href="Balacowork/Balacowork.css">
	<link rel="stylesheet" href="Styles/favoritos.css">
</head>
<body>
	<?php include_once('header.php'); ?>
	<main class="conteudo">
		<label class="lblFav">Obras Favoritas (<?php echo $qtdFavs; ?>)</label>
		<br>
		<div id="containerObrasId" class="containerObras">
			<div class="listaDeCards">
			<?php foreach ($dadosLit as $literatura){ ?>
					<?php include('cardLivro.php'); ?>
			<?php } ?>
			</div>
		</div>
	</main>
	<?php include_once('footer.php'); ?>
</body>
</html>
