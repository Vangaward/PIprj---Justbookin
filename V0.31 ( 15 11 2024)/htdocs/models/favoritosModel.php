<?

include_once("conexao.php");
include_once('Vlogin.php');
include_once('rsnl.php');
include_once('configs.php');

function buscaFav($idUsuario)
{
	global $conexao;
	global $dirCapa;
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
	
	$dadosLit = mysqli_fetch_all($queryLit, MYSQLI_ASSOC);
	
	foreach ($dadosLit as &$literatura) {
        $literatura['img'] = $literatura['urlCapa'] ? $dirCapa . $literatura['urlCapa'] : "imagens/batata.png";
        $literatura['idLit'] = sha1($literatura['idLit']);
    }
	
	return [$dadosLit, $qtdFavs, $txtQtdFavs];
}

?>