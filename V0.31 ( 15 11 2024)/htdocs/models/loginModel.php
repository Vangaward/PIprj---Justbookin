<?

function getMensagem()
{
	$msgErroConta = null;
	$msgErroLogin = null;
	if (isset($_SESSION['telaLoginErro']) and $_SESSION['mostrarErro'] == 1)
	{
		$msgErroLogin = $_SESSION['telaLoginErro'];
		unset($_SESSION['telaLoginErro']);
		$_SESSION['mostrarErro'] = 0;
	}
	
	if (isset($_SESSION['msgErroCriarConta']))
	{
		if ($_SESSION['msgErroCriarConta'] == 1)
		{
			$msgErroConta = "As senhas não correspondem";
		}
		if ($_SESSION['msgErroCriarConta'] == 2)
		{
			$msgErroConta = "Esse email já está em uso";
		}
		if ($_SESSION['msgErroCriarConta'] == 3)
		{
			$msgErroConta = "Esse nome de usuário já está em uso";
		}
		if ($_SESSION['msgErroCriarConta'] == 4)
		{
			$msgErroConta = "As senhas devem conter ao menos 8 caracteres e no máximo 20, com ao menos:<br>1 número, 1 letra maiúscula e minúscula e 1 caractere especial";
		}
		if ($_SESSION['msgErroCriarConta'] == 5)
		{
			$msgErroConta = "Houve um problema com o token, tente novamente!";
		}
		unset($_SESSION['msgErroCriarConta']);
	}
	
	return [$msgErroLogin, $msgErroConta];
}

?>