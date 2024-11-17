<?php

function getMensagem()
{
	$msgErro = null;
	if (isset($_SESSION['publicarObraP1.phpErro']))
	{
		switch ($_SESSION['publicarObraP1.phpErro']) {
			case 1:
				$msgErro = "O arquivo selecionado não é um PDF, por favor, selecione apenas arquivos em formato PDF!";
				break;
			case 2:
				$msgErro = "Faltam arquivos, anexe o PDF e a Capa e tente novamente!";
				break;
			case 3:
				$msgErro = "Houve um erro da nossa parte, por favor, tente novamente.";
				break;
			case 4:
				$msgErro = "O arquivo da capa não é válido, selecione apenas arquivos .jpg, .jpeg, ou .png!";
				break;
			case 5:
				$msgErro = "O nome de um dos arquivos é muito grande para o upload.";
				break;
		}
		unset($_SESSION['publicarObraP1.phpErro']);
	}
	return $msgErro;
}

?>