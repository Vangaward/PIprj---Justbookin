<?php include_once('forcaRota.php'); ?>

<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once ("b.php"); ?>
    <title>Favoritos | JustBookIn</title>
	<link rel="stylesheet" href="Balacowork/Balacowork.css">
	<link rel="stylesheet" href="Styles/favoritos.css">
	<link rel="stylesheet" href="Styles/card.css">
</head>
<body>
	<?php include_once('header.php'); ?>
	<main class="conteudo">
		<label class="lblFav">Obras Favoritas (<?php echo $qtdFavs; ?>)</label>
		<br>
		<div class="row">
			<?php foreach ($dadosLit as $literatura){ ?>
				<div class="col-6 col-sm-4 col-md-3 col-lg-2">
					<?php include('cardLivro.php'); ?>
				</div>
			<?php } ?>
		</div><!--row-->
	</main>
	<?php include_once('footer.php'); ?>
</body>
</html>
