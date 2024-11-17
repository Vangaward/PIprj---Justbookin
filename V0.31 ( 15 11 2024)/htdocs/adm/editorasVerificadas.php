<?php include_once('forcaRota.php'); ?>

<html>

	<head>
	
		<title>Editoras verificadas | Painel de Controle</title>
	
	</head>

	<body>
	
		<button onclick="location.href='index.php'">Voltar</button>
		
		<h1>Editoras verificadas</h1>
	
		<?php foreach ($dadosEditoras as $editora) { ?>
		
		<a href="../perfil?i=<? echo $editora['idUsuario']; ?>"><?php echo $editora['nomeUsuario']; ?><img src="../<? echo $editora['img']; ?>"></img></a>
		
		<?php } ?>
	
	</body>

</html>