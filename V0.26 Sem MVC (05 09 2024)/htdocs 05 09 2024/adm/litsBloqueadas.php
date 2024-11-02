<?php
	include_once('Vadm.php');
	
	$queryLit = mysqli_query($conexao, "SELECT l.idLit, l.titulo, l.urlCapa, l.status, u.nomeUsuario, u.nome
	 FROM Literatura l
	INNER JOIN usuario u ON l.idUsuario = u.idUsuario where l.status = 2;
	");
	if (!$queryLit)
	{
		echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
		die('<b>Query Inválida:</b>');
	}
?>

<html>

<head>

<title>Painel de controle|JustBookIn</title>
<?php include_once('b.php'); ?>

</head>

<?php include_once('../Styles/card.css'); ?>

<body>

<button onclick="location.href='index.php'">Painel de controle</button>
<h1>Literaturas bloqueadas</h1>

<?php while($dadosLit=mysqli_fetch_array($queryLit)){
	
	if ($dadosLit['urlCapa'] == "")
	{$img = "../imagens/batata.png";}else{$img = "../imagensCapa/" . $dadosLit['urlCapa'];}
		
		$idLitCard = sha1($dadosLit['idLit']);
		$titulo = $dadosLit['titulo'];
		$nomeUser = $dadosLit['nomeUsuario'];
		
		?>
		<div class="col-6 col-sm-4 col-md-3 col-lg-2">
		<?php include("cardLivro.php"); ?>
		</div>

<?php } ?>

</body>

</html>