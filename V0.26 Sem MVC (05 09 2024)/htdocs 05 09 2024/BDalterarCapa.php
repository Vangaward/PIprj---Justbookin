<?php

include_once('conexao.php');
include_once('rsnl.php');
include_once('configs.php');
include_once('Vlogin.php');

$idUsuario = $dadosLogin['idUsuario'];
$idLitSha1 = $_GET['i'];

if ($_POST['tokenFrmAltCap'] != $_SESSION['TSFAltCapa'])
{
	die($_POST['tokenFrmAltCap'] . " | " . $_SESSION['TSFAltCapa']);
	$_SESSION['editCapa'] = 5;
	header('Location: livro.php?i=' . $idLitSha1);
	die();
}
else
{
	unset($_SESSION['TSFAltCapa']);
}

$stmt = $conexao->prepare("SELECT * FROM Literatura WHERE sha1(idLit) = ?");
$stmt->bind_param('s', $idLitSha1);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    echo '<input type="button" onclick="window.location=\'index.php\';" value="Voltar"><br><br>';
    die('<b>Query Inválida:</b>');
}

$dadosLit = $result->fetch_array();
$stmt->close();

if ($dadosLit['status'] == 2)
	{
		$_SESSION['editCapa'] = 5;
		header('Location: livro.php?i=' . $idLitSha1);
		die();
	}

	if ($dadosLit['idUsuario'] != $dadosLogin['idUsuario'])
	{
		header('Location: index.php');
		die();
	}

if (isset($_POST['excluCapa']))
{
	
	if (unlink($dirCapa . $dadosLit['urlCapa']))
		{
			$dataEditcao = date('Y-m-d H:i:s');
			$stmt = $conexao->prepare("UPDATE Literatura SET urlCapa = '', dataEdit = ? WHERE sha1(idLit) = ?");
			$stmt->bind_param('ss', $dataEditcao, $idLitSha1);
			$stmt->execute();

			if (!$stmt) {
				echo '<input type="button" onclick="window.location=\'index.php\';" value="Voltar"><br><br>';
				die('<b>Query Inválida:</b>' . $conexao->error);
			}
			$stmt->close();

				header('Location: livro.php?i=' . $idLitSha1);
				exit();
		}
		else
		{
			$_SESSION['editCapa'] = 3;
			header('Location: livro.php?i=' . $idLitSha1);
            exit();
		}
	die();
}
else if (isset($_FILES['alterCapa'])) //Alterar foto enviado
{
	$erroArquivo = $_FILES['alterCapa']['error'];
	$erroExclImg;
	if ($erroArquivo === UPLOAD_ERR_OK)
	{
		if (!empty($dadosLit['urlCapa']))
		{
			if (unlink($dirCapa . $dadosLit['urlCapa']))
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
			$nomeArquivo = $_FILES['alterCapa']['name'];
			$caminhoTemporario = $_FILES['alterCapa']['tmp_name'];
			$nomeArquivoUnico = md5(time()) . '_' . $nomeArquivo;
			$destinoCapa = $dirCapa . $nomeArquivoUnico;
			
			/*Tratar extensão*/
			$extensao = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));
                $extensoesPermitidas = array('jpg', 'jpeg', 'png');

                if (!in_array($extensao, $extensoesPermitidas))
                {
                    $_SESSION['editCapa'] = 1; //mensagem de erro
                    header('Location: livro.php?i=' . $idLitSha1);
                    exit();
                }
				
				/*Trartar tamanho do nome*/
			if(mb_strlen($nomeArquivo) > 41)
			{
				$_SESSION['editCapa'] = 2;
				header('Location: livro.php?i=' . $idLitSha1);
                exit();
			}
			if (file_exists($destinoCapa))
			{
				$_SESSION['editCapa'] = 3;
				header('Location: livro.php?i=' . $idLitSha1);
                exit();
			}
			else
			{
				if(move_uploaded_file($caminhoTemporario, $destinoCapa))
				{
					echo 'sucesso ao mover';
				}
				else
				{
					$_SESSION['editCapa'] = 3;
					header('Location: livro.php?i=' . $idLitSha1);
					exit();
				}
			}
			
			$dataEditcao = date('Y-m-d H:i:s');
			$stmt = $conexao->prepare("UPDATE Literatura SET urlCapa = ?, dataEdit = ? WHERE sha1(idLit) = ?");
			$stmt->bind_param('sss', $nomeArquivoUnico, $dataEditcao, $idLitSha1);
			$stmt->execute();

			if (!$stmt) {
				echo '<input type="button" onclick="window.location=\'index.php\';" value="Voltar"><br><br>';
				die('<b>Query Inválida:</b>' . $conexao->error);
			}
			$stmt->close();
				header('Location: livro.php?i=' . $idLitSha1);
				die();
		}
		else //Houve erro ao excluir imagem
		{
			/*$sqlupdate =  "update Literatura set urlCapa='' where sha1(idLit) = '$idLitSha1'";
			$resultado = @mysqli_query($conexao, $sqlupdate);
			if (!$resultado) {
				echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
				die('<b>Query Inválida:</b>' . @mysqli_error($conexao)); }
				*/
				$_SESSION['editCapa'] = 3;
				header('Location: livro.php?sa=p&i=' . $idLitSha1);
                exit();
		}
	} //UPLOAD_ERR_OK
		else
		{
			$_SESSION['editCapa'] = 3;
			header('Location: livro.php?i=' . $idLitSha1);
            exit();
		}
}//Alterar foto enviado

	if (!isset($_POST['excluCapa']) && !isset($_FILES['alterCapa']))
	{
		header('Location: index.php');
	}
?>