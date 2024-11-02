<?php

require_once("conexao.php");
require_once("helperBD.php");
require_once("configs.php");

function selectUsuarios($search)
{
	global $conexao;
	global $litBloqOuPriv;
	global $dirCapa;
	
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
		
		foreach ($dadosPerfilsArray as &$perfil) { // Use a referência (&) para modificar o array original
		if ($perfil['urlFotoPerfil'] == "")
			{$img = "imagens/User.png";}else{$img = "fotosPerfil/" . $perfil['urlFotoPerfil'];}
		
			$perfil['fotoECaminhoPerfil'] = $img;
			$perfil['idUsuarioCripto'] = sha1($perfil['idUsuario']);
		}
		
		$stmt->close();
		
		return $dadosPerfilsArray;
	}
}

function selectLits($search, $icat) //e as gambiarra todas, tem q passar mais uns parâmetros aqui também
{
	global $conexao;
	global $litBloqOuPriv;
	global $dirCapa;
	
	$IdCatSha1 = $icat;

	//apenas declaração de variáveis
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
		
	if ($icat != "") //Há categorias
	{
		$innerJoinItCat = "INNER JOIN itemCategoria ic ON l.idLit = ic.idLit";
		$innerJoinCat = "INNER JOIN Categoria c ON ic.idCategoria = c.idCategoria";
		$whereC_IdCat = "sha1(ic.idCategoria) = '" . $icat . "'";
	}
	else
	{
		$haCatsFiltro = false;
	}

	/**//**//**/
	if ($search != "" || $search != null)
	{
		if ($search == "")
		{
			$haSearch = false;
		}
		else{ //se pesquisa não é nula
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
		$whereC_IdCatPosOr = " and sha1(c.idCategoria) = '" . $icat . "'";
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
	die();
	*/
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
		
		$qtdeLinhasQueryLit = count($allResults);
		
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
		
		foreach ($allResults as &$literatura) { // Use a referência (&) para modificar o array original
			$literatura['img'] = $literatura['urlCapa'] ? $dirCapa . $literatura['urlCapa'] : "imagens/batata.png";
			$literatura['idLit'] = sha1($literatura['idLit']);
		}
		
	}
	 if (!isset($dadosCatFiltrada))
		 $dadosCatFiltrada = [];
	return [$allResults, $haCatsFiltro, $haSearch, $qtdeLinhasQueryLit, $dadosCatFiltrada];
}

?>