<?php
die("Temporariamente não disponível, possívelmente nunca");
include_once('Vlogin.php');
include_once('rsnl.php');
include_once('header.php');

//Inscrições
$idUsuariosessao = $dadosLogin['idUsuario'];
$queryHistorico = mysqli_query($conexao, "
SELECT s.idUsuarioSeguido, u.nome, u.sobrenome, u.urlFotoPerfil, l.urlCapa, l.titulo, l.idLit FROM seguidos s
INNER JOIN usuario u ON u.idUsuario = s.idUsuarioSeguido
INNER JOIN Literatura l ON l.idUsuario = u.idUsuario
WHERE s.idUsuario = '$idUsuariosessao'");

?>

<html>

<head>

<?php include_once('b.php'); ?>

</head>

<?php include_once('Styles/inscricao.css'); ?>
<?php include_once('Styles/card.css'); ?>

<body>

<label class="lblTitulo">Histórico</label>

<div class="row">

	<?php 
		while($dadosHistorico=mysqli_fetch_array($queryHistorico)){ 
			if ($dadosHistorico['urlCapa'] == "")
				{$img = "imagens/batata.png";}else{$img = "imagensCapa/" . $dadosLitsSeguido['urlCapa'];}
				
			$idLitCard = sha1($dadosLitsSeguido['idLit']);
			$titulo = $dadosLitsSeguido['titulo'];
			$nomeUser = $dadosLitsSeguido['nome']; ?>
			<div class="col-6 col-sm-4 col-md-3 col-lg-2">
			<?php include("cardLivro.php"); ?>
			</div>
	<?php } ?>

</div><!--row-->

</body>

</html>