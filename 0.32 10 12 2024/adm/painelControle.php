<?php include_once('forcaRota.php'); ?>
<link rel="stylesheet" href="../Styles/fonte.css">
<link rel="stylesheet" href="../Balacowork/Balacowork.css">
<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=0.5">
<title>Painel de controle|JustBookIn</title>

</head>

<body>
<div class="janelaAdm">
	<h1>Bem-vindo, ADM</h1>

	<div class="btns">
		<button class="botao azul" onclick="location.href='../index.php'">Acessar o site</button>
		<button class="botao roxo" onclick="location.href='litsBloqueadas.php'">Literaturas bloqueadas</button>
		<button class="botao verde" onclick="location.href='editorasVerificadas.php'">Editoras verificadas</button>
		<button class="botao vermelho" onclick="location.href='../login/logoff.php'">Fazer Logoff</button>
	</div>
</div>
</body>

</html>

<style>
body {
	display: flex;
	align-items: center;
	justify-content: center;
	background: var(--cor4Escuro)
}

.janelaAdm {
	width: min-content;
	height: min-content;
	background: var(--branco);
	padding: 20px;
	border-radius: 10px;
}

.btns {
	display: flex;
	gap: 20px;
}

.botao {
	font-family: Arimo;
}
</style>