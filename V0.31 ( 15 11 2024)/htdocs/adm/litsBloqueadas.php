<?php include_once('forcaRota.php'); ?>

<html>

<head>

<title>Painel de controle|JustBookIn</title>
<?php include_once('b.php'); ?>

</head>

<?php include_once('Styles/card.css'); ?>

<body>

<button onclick="location.href='index.php'">Painel de controle</button>
<h1>Literaturas bloqueadas</h1>

	<?php foreach ($dadosLit as $literatura) { ?>
		<div class="col-6 col-sm-4 col-md-3 col-lg-2">
			<?php include('cardLivro.php'); ?>
		</div>
	<?php } ?>

</body>

</html>