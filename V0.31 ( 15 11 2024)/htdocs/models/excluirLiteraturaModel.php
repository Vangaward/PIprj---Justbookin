<?

include_once ('conexao.php');
include_once ('Vlogin.php');
include_once ('Vcli.php');
include_once ('rsnl.php');

function buscaLit($idLitSha1)
{
	global $conexao, $dadosLogin;
	$queryLit = mysqli_query($conexao, "SELECT l.idLit, l.idUsuario, l.descricao, l.titulo, l.urlCapa, u.nome
		 FROM Literatura l
		INNER JOIN usuario u ON l.idUsuario = u.idUsuario where sha1(idLit) = '$idLitSha1';");     
	if (!$queryLit)
	{
		echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
		die('<b>Query Inválida: </b>' . @mysqli_error($conexao));  
	}
	$dadosLit = mysqli_fetch_array($queryLit);
	if ($dadosLit['idUsuario'] != $dadosLogin['idUsuario'])
		{
			header ('Location: login');
			die();
		}
	
	return $dadosLit;
}

function getErro()
{
	$erro;
	if (isset($_SESSION['msgBDExLit']))
	{
		if ($_SESSION['msgBDExLit'] == 3)
		{
			$erro = "Senha incorreta! Tente novamente.";
		}
		unset($_SESSION['msgBDExLit']);
		
		return $erro;
	}
}

?>