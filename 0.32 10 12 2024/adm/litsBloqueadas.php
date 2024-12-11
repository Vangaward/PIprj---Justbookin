<?php include_once('forcaRota.php'); ?>

<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de controle | JustBookIn</title>
    <?php include_once('b.php'); ?>
	<link rel="stylesheet" href="../Styles/fonte.css">
    <link rel="stylesheet" href="../Balacowork/Balacowork.css">
	<link rel="stylesheet" href="adm/Style/litsBloqueadas.css">
	<link rel="stylesheet" href="../Styles/card.css">
</head>
<?php include_once("adm/Styles/litsBloqueadas.css");?>


<body>

<button class="botao vermelho" onclick="location.href='index.php'">Painel de controle</button>
<h1>Literaturas bloqueadas</h1>
	
	<div class="litsHoriz">
		<?php foreach ($dadosLit as $literatura) { ?>
			<?php include('cardLivro.php'); ?>
		<?php } ?>
	</div>


</body>

</html>