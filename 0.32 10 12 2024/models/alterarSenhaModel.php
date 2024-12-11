<?php

function msg()
{
	$msgErro = null;
	if (isset($_SESSION['altSenhaMsg']))
	{
		if ($_SESSION['altSenhaMsg'] == 1)
		$msgErro = "Sua senha atual está incorreta.";
		if ($_SESSION['altSenhaMsg'] == 2)
			$msgErro = "A nova senha e a confirmação não coincidem";
		if ($_SESSION['altSenhaMsg'] == 3)
			$msgErro = "A nova senha não pode ser igual a senha atual";
		if ($_SESSION['altSenhaMsg'] == 4)
			$msgErro = "As senhas devem conter ao menos 8 caracteres e no máximo 20, com ao menos:<br>1 número, 1 letra maiúscula e minúscula e 1 caractere especial";
		if ($_SESSION['altSenhaMsg'] == 5)
			$msgErro = "Houve um erro inesperado.";
		unset($_SESSION['altSenhaMsg']);
	}
	return $msgErro;
}

?>