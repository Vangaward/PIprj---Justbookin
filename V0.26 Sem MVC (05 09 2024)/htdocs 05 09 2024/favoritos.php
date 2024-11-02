<?php
include_once("conexao.php");
include_once('Vlogin.php');
include_once('rsnl.php');

$idUsuario = $dadosLogin['idUsuario'];

$queryLit = mysqli_query($conexao, "SELECT l.idLit, l.titulo, l.urlCapa, u.nome
 FROM Literatura l
INNER JOIN usuario u ON l.idUsuario = u.idUsuario
INNER JOIN favorito f ON f.idLit = l.idLit where f.idUsuario = '$idUsuario'");

if (!$queryLit) {
    echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
    die('<b>Query Inválida: </b>' . @mysqli_error($conexao));  
}

$qtdFavs = mysqli_num_rows($queryLit);
$txtQtdFavs = "";
if ($qtdFavs <= 0) {
    $txtQtdFavs = "Você ainda não favoritou nenhuma Literatura.";
}
?>

<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once ("b.php"); ?>
    <title>Favoritos | JustBookIn</title>
</head>

<?php include_once('Styles/card.css'); ?>
<?php include_once('Styles/favoritos.css'); ?>
<body>
    <?php include_once('header.php'); ?>
    <label class="lblFav">Obras Favoritas (<?php echo $qtdFavs; ?>)</label>
    <br>
<div class="row">

<?php while($dadosLit=mysqli_fetch_array($queryLit)){ 
			if ($dadosLit['urlCapa'] == "")
			{$img = "imagens/batata.png";}else{$img = "imagensCapa/" . $dadosLit['urlCapa'];}
				?>
				<div class="col-6 col-sm-4 col-md-3 col-lg-2">
				<?php
				$idLitCard = sha1($dadosLit['idLit']);
				$titulo = $dadosLit['titulo'];
				$nomeUser = $dadosLit['nome'];
				include("cardLivro.php"); ?>
				</div>
		<?php } ?>

</div><!--row-->
	 
</body>
</html>
