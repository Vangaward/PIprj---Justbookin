<?php include_once('forcaRota.php'); ?>

<html>

<head>

<?php include_once('b.php'); ?>
    <title>Histórico | JustBookIn</title>
	<link rel="stylesheet" href="Balacowork/Balacowork.css">
	<link rel="stylesheet" href="Styles/historico.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<?php include_once('header.php'); ?>
	<main class="conteudo">
		<div style="display: flex; justify-content: space-between; align-items: center">
			<label class="lblHist">Histórico</label>
			<button style="width: 300px" name="btnLimparHist" class="botao vermelho" onclick="window.location.href='BDlimpaHistorico.php'">Limpar Histórico</button>
		</div>
		<br>
		<div id="containerObrasId" class="containerObras">
			<div class="listaDeCards">
				<? echo $txtQtdLits; ?>
					<?php foreach ($dadosLit as $literatura){ ?>
							<?php include('cardLivro.php'); ?>
					<?php } ?>
			</div>
		</div>
	</main>
	<? include_once('footer.php'); ?>
</body>
</html>