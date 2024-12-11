<?php include_once('forcaRota.php'); ?>

<html>

	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Editoras verificadas | Painel de Controle</title>
		<link rel="stylesheet" href="../Styles/fonte.css">
		<link rel="stylesheet" href="../Balacowork/Balacowork.css">
	
	</head>
<?php include_once("adm/Styles/editorasVerificadas.css");?>
	<body>
	
		<button class="botao vermelho" onclick="location.href='index.php'">Voltar</button>
		
		<h1>Editoras verificadas</h1>
		
		<div class="listaDeCards">
		<?php foreach ($dadosEditoras as $editora) { ?>
		
		<a href="../perfil?i=<? echo $editora['idUsuario']; ?>"><?php echo $editora['nomeUsuario']; ?><img src="../<? echo $editora['img']; ?>"></img></a>
		
		<?php } ?>
		</div>
	</body>

</html>