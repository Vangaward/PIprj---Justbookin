<?php

include_once('conexao.php');
include_once('rsnl.php');
include_once('configs.php');
include_once('Vlogin.php');

$idUsuario = $dadosLogin['idUsuario'];

	if ($_POST['tokenFrmAltBanner'] != $_SESSION['TSFAltBanner'])
	{
		$_SESSION['perfilMsg'] = 4;
		header('Location: perfil.php');
		die();
	}
	else
	{
		unset($_SESSION['TSFAltBanner']);
	}

if (isset($_POST['excluBanner']))
{
	
	if (unlink($dirBanner . $dadosLogin['urlBanner']))
		{
			$sqlupdate =  "update usuario set urlBanner='' where idUsuario = '$idUsuario'";
			$resultado = @mysqli_query($conexao, $sqlupdate);
			if (!$resultado) {
				echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
				die('<b>Query Inválida:</b>' . @mysqli_error($conexao)); }
				header('Location: perfil.php');
				exit();
		}
		else
		{
			$_SESSION['perfilMsg'] = 3;
			header('Location: perfil.php');
            exit();
		}
	die();
}
else if (isset($_FILES['arquivoBanner'])) //Alterar banner enviado
{
	$erroArquivo = $_FILES['arquivoBanner']['error'];
	$erroExclImg;
	if ($erroArquivo === UPLOAD_ERR_OK)
	{
		if (!empty($dadosLogin['urlBanner']))
		{
			if (unlink($dirBanner . $dadosLogin['urlBanner']))
			{
				$erroExclImg = false;
			}
			else
			{
				$erroExclImg = true;
			}
		}
		else
		{
			$erroExclImg = false;
		}
		if ($erroExclImg == false)
		{
			$nomeArquivo = $_FILES['arquivoBanner']['name'];
			$caminhoTemporario = $_FILES['arquivoBanner']['tmp_name'];
			$nomeArquivoUnico = sha1(time()) . '_' . $nomeArquivo;
			$destinoBanner = $dirBanner . $nomeArquivoUnico;
			
			/*Tratar extensão*/
			$extensao = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));
                $extensoesPermitidas = array('jpg', 'jpeg', 'png');

                if (!in_array($extensao, $extensoesPermitidas))
                {
                    $_SESSION['perfilMsg'] = 1; //mensagem de erro
                    header('Location: perfil.php');
                    exit();
                }
				
				/*Trartar tamanho do nome*/
			if(mb_strlen($nomeArquivo) > 41)
			{
				$_SESSION['perfilMsg'] = 2;
				header('Location: perfil.php');
                exit();
			}
			if (file_exists($destinoBanner))
			{
				$_SESSION['perfilMsg'] = 3;
				header('Location: perfil.php');
                exit();
			}
			else
			{
				if(move_uploaded_file($caminhoTemporario, $destinoBanner))
				{
					//echo 'sucesso ao mover';
				}
				else
				{
					$_SESSION['perfilMsg'] = 3;
					header('Location: perfil.php');
					exit();
				}
			}
			
			$sqlupdate =  "update usuario set urlBanner='$nomeArquivoUnico' where idUsuario = '$idUsuario'";
			$resultado = @mysqli_query($conexao, $sqlupdate);
			if (!$resultado) {
				echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
				die('<b>Query Inválida:</b>' . @mysqli_error($conexao)); }
				header('Location: perfil.php');
				die();
		}
		else
		{
			$sqlupdate =  "update usuario set urlBanner='' where idUsuario = '$idUsuario'";
			$resultado = @mysqli_query($conexao, $sqlupdate);
			if (!$resultado) {
				echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
				die('<b>Query Inválida:</b>' . @mysqli_error($conexao)); }
				
			$_SESSION['perfilMsg'] = 3;
				header('Location: perfil.php');
                exit();
		}
	} //UPLOAD_ERR_OK
		else
		{
			$_SESSION['perfilMsg'] = 3;
			header('Location: perfil.php');
            exit();
		}
}//Alterar foto enviado

	if (!isset($_POST['excluBanner']) && !isset($_FILES['arquivoBanner']))
	{
		header('Location: index.php');
	}
?>