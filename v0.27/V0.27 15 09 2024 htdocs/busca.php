<?php

include_once ('conexao.php');
include_once ('Vlogin.php');
include_once ('Vcli.php');
include_once('helperBD.php');

//Buscar por perfils
$search = $_GET['search'];
if ($search != null)
{
	$stmt = $conexao->prepare("SELECT * FROM usuario 
							   WHERE (nome LIKE ? OR sobrenome LIKE ? OR nomeUsuario LIKE ?) 
							   AND tipoConta != 1");
	$stmt->bind_param('sss', $search, $search, $search);
	$stmt->execute();
	$result = $stmt->get_result();
	if (!$result) {
		die('<b>Query Inválida:</b> ' . $conexao->error);
	}
	
	$dadosPerfilsArray = [];
	while ($dadosPerfils = $result->fetch_array()) {
		$dadosPerfilsArray[] = $dadosPerfils;
	}
	
	$stmt->close();
}

//Busca por literaruras
if (isset($_GET['icat'])){
$IdCatSha1 = $_GET['icat']; }

	$innerJoinItCat = "";
	$innerJoinCat = "";
	$whereC_IdCat = ""; //Com ID da categoria
	$whereC_IdCatPosOr = "";
	$whereStatus = "l." . $litBloqOuPriv ;
	$where = "where " . $whereStatus . " and";
	$whereAnd = "";
	$whereSearch = "";

	$haSearch = true;
	$haCatsFiltro = true;
	$qtdeLinhasQueryLit = 0;
	
if (isset($_GET['icat']))
{
	if ($_GET['icat'] == null)
	{
		$haCatsFiltro = false;
	}
	else{ //Há categorias
	$innerJoinItCat = "INNER JOIN itemCategoria ic ON l.idLit = ic.idLit";
	$innerJoinCat = "INNER JOIN Categoria c ON ic.idCategoria = c.idCategoria";
	$whereC_IdCat = "sha1(ic.idCategoria) = '" . $_GET['icat'] . "'";
	}
}
else
{
	$haCatsFiltro = false;
}

/**//**//**/
if (isset($_GET['search']))
{
	if ($_GET['search'] == null)
	{
		$haSearch = false;
	}
	else{ //se pesquisa não é nula
	$search = $_GET['search'];
	$whereSearch = "l.titulo like '%$search%' or l.descricao like '%$search%' and " . $whereStatus;
	}
}
else
{
	$haSearch = false;
}
/**//**/
if ($haCatsFiltro && $haSearch)
{
	$whereC_IdCatPosOr = " and sha1(c.idCategoria) = '" . $_GET['icat'] . "'";
	$whereAnd = " and ";
}

/**/
/*echo "SELECT l.idLit, l.titulo, l.urlCapa, u.nome
 FROM Literatura l
INNER JOIN usuario u ON l.idUsuario = u.idUsuario
" . $innerJoinItCat . "
" . $innerJoinCat . "
" . $where . "
" . $whereC_IdCat . "
" . $whereAnd . "
" . $whereSearch . "
" . $whereC_IdCatPosOr . "

";
die();*/

$sql = "SELECT l.idLit, l.titulo, l.urlCapa, u.nomeUsuario, u.nome
        FROM Literatura l
        INNER JOIN usuario u ON l.idUsuario = u.idUsuario
        $innerJoinItCat $innerJoinCat $where $whereC_IdCat $whereAnd $whereSearch $whereC_IdCatPosOr";

// Preparar e executar a consulta
$sql = "SELECT l.idLit, l.titulo, l.urlCapa, u.nomeUsuario, u.nome
        FROM Literatura l
        INNER JOIN usuario u ON l.idUsuario = u.idUsuario
        $innerJoinItCat $innerJoinCat $where $whereC_IdCat $whereAnd $whereSearch $whereC_IdCatPosOr";

// Preparar e executar a consulta
$stmt = mysqli_prepare($conexao, $sql);
if ($stmt) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Armazenar todos os resultados em um array
    $allResults = [];
    while ($dadosLit = mysqli_fetch_array($result)) {
        $allResults[] = $dadosLit;
    }

    // Fechar o statement e liberar o resultado
    mysqli_free_result($result);
    mysqli_stmt_close($stmt);


			$queryCatFiltradaNumRows = 0;
	if ($haCatsFiltro){
	$queryCatFiltrada = mysqli_query($conexao, "SELECT * from Categoria where sha1(	idCategoria) = '$IdCatSha1';");
	if (!$queryCatFiltrada)
			{
				echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
				die('<b>Query Inválida: </b>' . @mysqli_error($conexao));  
			}
	$dadosCatFiltrada=mysqli_fetch_array($queryCatFiltrada);
	//$queryCatFiltradaNumRows = mysqli_num_rows($queryCatFiltrada);

}
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>JustBookIn</title>
	<?php include_once("detalhesHead.php");?>
	<link rel="stylesheet" href="Balacowork/Balacowork.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

</head>
<?php include_once("Styles/busca.css");?>
<?php include_once("Styles/fonte.css");?>
<body>

<?php include_once('header.php');?>

<main class="conteudo">
<?php include_once('barraPesquisa.php'); ?>
<br>
<?php if ($haCatsFiltro){?>

<div class="texto">Exibindo somente: <label class="lblNomeCategoriaFiltro"><?php echo $dadosCatFiltrada['nomeCategoria']; ?></label></div>

<?php } else if($haSearch){?>
<label class="texto">Exibindo: Todas as categorias <button class="btnRev" onclick="filtrarCat('')"><?php include('icones/Cancelar.svg'); ?></button></label>
<?php } ?>

<?php if ($search != null){ ?>
<div class="litsHoriz">
	<?php foreach ($dadosPerfilsArray as $dadosPerfils) {
		if ($dadosPerfils['urlFotoPerfil'] == "")
			{$img = "imagens/User.png";}else{$img = "fotosPerfil/" . $dadosPerfils['urlFotoPerfil'];}
			?>
			<a class="aInscricoes" href="perfil.php?i=<?php echo sha1($dadosPerfils['idUsuario']); ?>">
				<img class="imgUserBuscado" src="<?php echo $img; ?>"><?php echo $dadosPerfils['nomeUsuario']; ?>
			</a>
	<?php } ?>
</div><!--litsHoriz-->

<?php } ?>

<div class="row">

<?php include_once('Styles/card.css');?>

<?php if ($haSearch || $haCatsFiltro){
	foreach ($allResults as $dadosLit) {
			if ($dadosLit['urlCapa'] == "")
			{$img = "imagens/batata.png";}else{$img = $dirCapa . $dadosLit['urlCapa'];}
				?>
				<div class="col-6 col-sm-4 col-md-3 col-lg-2">
				<?php
				$idLitCard = sha1($dadosLit['idLit']);
				$titulo = $dadosLit['titulo'];
				$nomeUser = $dadosLit['nomeUsuario'];
				include("cardLivro.php"); ?>
				</div>
<?php } }?>

</div><!--row-->

<?php if ($haSearch == false && !$haCatsFiltro){ ?>
<center><label class="lblNaoHaSearch">Digite algo na barra de pesquisa para buscar por literaturas!</label></center>
<?php }
if ($qtdeLinhasQueryLit <=0 && $haSearch == true || $qtdeLinhasQueryLit <=0 && $haCatsFiltro == true)
{ ?>
	<center>
	<label class="lblNaoHaSearch">Nenhum resultado encontrado para a pesquisa.<br>Tente digitar algo diferente ou alterar os filtros.</label>
	<br><img class="imgSemComents" src="imagens/semResultados.jpg">
	</center>
<?php } ?>


</main>
</body>
