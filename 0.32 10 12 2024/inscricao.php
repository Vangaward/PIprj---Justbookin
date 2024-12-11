<?php include_once('forcaRota.php'); ?>

<html>

<head>
<?php include_once('b.php'); ?>
<link rel="stylesheet" href="Balacowork/Balacowork.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inscrições|Justbookin</title>
<?php include_once("Styles/fonte.css");?>
</head>

<link rel="stylesheet" href="Styles/inscricao.css">

<body>
    <main class="conteudo">
		<?php include_once('header.php'); ?>
		<label class="lblInsc">Inscrições</label>
		<br>
		<div id="containerObrasId" class="containerObras">
			<div class="listaDeCards">
			<? echo $txtNaoHaInscricoes; ?>
			<?php foreach ($dadosLit as $literatura) { ?>
				<?php include('cardLivro.php'); ?>
			<?php } ?>
			</div>
		</div>
	</main>
</body>
</html>