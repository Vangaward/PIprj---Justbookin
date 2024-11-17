<?php

require_once("conexao.php");
require_once("helperBD.php");
require_once("configs.php");
include_once ('Vlogin.php');

function buscaLit($idLitSha1)
{
	global $conexao;
	$queryLit = "SELECT * FROM Literatura WHERE sha1(idLit) = ?";
	$stmt = mysqli_prepare($conexao, $queryLit);

	if ($stmt) {
    // Vincular os parâmetros ao prepared statement
    mysqli_stmt_bind_param($stmt, 's', $idLitSha1);

    // Executar a consulta
    if (mysqli_stmt_execute($stmt)) {
        // Obter o resultado
        $result = mysqli_stmt_get_result($stmt);
        $dadosLit = mysqli_fetch_array($result); // Obter os dados do resultado

        // Verifique se foram retornados dados
        if (!$dadosLit) {
            echo '<input type="button" onclick="window.location=\'index.php\';" value="Voltar"><br><br>';
            die('Literatura não encontrada');
        }
    } else {
        // Erro ao executar a consulta
        echo '<input type="button" onclick="window.location=\'index.php\';" value="Voltar"><br><br>';
        die('<b>Erro ao executar a consulta: </b>' . mysqli_error($conexao));
    }

    // Fechar o statement
    mysqli_stmt_close($stmt);
	} else {
		// Erro ao preparar a consulta
		echo '<input type="button" onclick="window.location=\'index.php\';" value="Voltar"><br><br>';
		die('<b>Erro ao preparar a consulta: </b>' . mysqli_error($conexao));
	}
	
	return $dadosLit;
}

function isMeuUsuario($dadosLit)
{
	global $logado;
	global $dadosLogin;
	$meuUsuario = false;
	if ($logado == 1)
	{
		if ($dadosLit['idUsuario'] == $dadosLogin['idUsuario'])
		{
			$meuUsuario = true;
		}
	}
	return $meuUsuario;
}

function buscaCapitulos($idLitSha1)
{
	global $conexao;
	global $logado;
	$queryCapsLit = mysqli_query($conexao, "SELECT * from capituloLit where sha1(idLit) = '$idLitSha1';");
	if (!$queryCapsLit)
	{
		echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
		die('<b>Query Inválida: </b>'/* . @mysqli_error($conexao)*/);  
	}
	
	$linkBtnCapAnt = "";
	$linkBtnCapProx = "";
	$dadosCapLit = [];
	$urlCapVazia = "";
	$dadosCapLitProxCap = [];
	$haAntCap = null;
	$haProxCap = null;
	
	if(mysqli_num_rows($queryCapsLit) <=0)
	{$temCaps = 0;}

	else
	{
		$temCaps = 1;
			/*cap*/
		if (isset($_GET['cap']))
		{
			$numCap = $_GET['cap'];
			$urlCapVazia = 0;
		}
		else {$numCap = 1; $urlCapVazia = 1; }
		 $queryCapLit = mysqli_query($conexao, "SELECT * from capituloLit where sha1(idLit) = '$idLitSha1' and numCapitulo = '$numCap';");
		if (!$queryCapLit)
		{
			echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
			die('<b>Query Inválida: </b>'/* . @mysqli_error($conexao)*/);  
		}
		$dadosCapLit = mysqli_fetch_array($queryCapLit);
		
		$queryCapLitProxCap = mysqli_query($conexao, "SELECT * from capituloLit where sha1(idLit) = '$idLitSha1' and numCapitulo = " . $numCap + 1 . ";");
		if (!$queryCapLitProxCap)
		{
			echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
			die('<b>Query Inválida: </b>'/* . @mysqli_error($conexao)*/);  
		}
		if(mysqli_num_rows($queryCapLitProxCap) > 0) {$haProxCap = 1;} else {$haProxCap = 0;}
		$dadosCapLitProxCap = mysqli_fetch_array($queryCapLitProxCap);
		
		$queryCapLitAntCap = mysqli_query($conexao, "SELECT * from capituloLit where sha1(idLit) = '$idLitSha1' and numCapitulo = " . $numCap - 1 . ";");
		if (!$queryCapLitAntCap)
		{
			echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
			die('<b>Query Inválida: </b>'/* . @mysqli_error($conexao)*/);  
		}
		if(mysqli_num_rows($queryCapLitAntCap) > 0) {$haAntCap = 1;} else {$haAntCap = 0;}
		$dadosCapLitAntCap = mysqli_fetch_array($queryCapLitAntCap);
		
		
		if (isset($dadosCapLitAntCap['numCapitulo']))
		{
			if ($dadosCapLitAntCap['numCapitulo'] == null)
			{
				$linkBtnCapAnt = "leitor.php?i=" . $idLitSha1;
			}
			else
			{
				$linkBtnCapAnt = "leitor.php?i=" . $idLitSha1 . "&cap=" . $dadosCapLitAntCap['numCapitulo'];
			}
		}
		/**//**/
		if ($dadosCapLitProxCap['numCapitulo'] == null)
		{
			$linkBtnCapProx = "leitor.php?i=" . $idLitSha1 . "&cap=" . $dadosCapLit['numCapitulo'];
		}
		else
		{
			$linkBtnCapProx = "leitor.php?i=" . $idLitSha1 . "&cap=" . $dadosCapLitProxCap['numCapitulo'];
		}
	
	} //tem caps
	
	return  [$temCaps, $linkBtnCapAnt, $linkBtnCapProx, $dadosCapLit, $urlCapVazia, $dadosCapLitProxCap, $haAntCap, $haProxCap];
}

?>