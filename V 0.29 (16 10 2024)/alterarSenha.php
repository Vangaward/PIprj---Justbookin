<?php

include_once ('conexao.php');
include_once ('Vlogin.php');
include_once ('Vcli.php');
include_once ('rsnl.php');

$_SESSION['TSFAltSenha'] = bin2hex(random_bytes(32));

?>

<html>

<head>

<title>Alterar Senha|JustBookIn</title>
<?php include_once('b.php'); ?>
<link rel="stylesheet" href="Balacowork/Balacowork.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<?php include_once('Styles/alterarSenha.css'); ?>

<body>

<?
	if (isset($_SESSION['altSenhaMsg']))
	{
		$msgErro="";
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
		
		echo "<div style='animation-name: Rotacao3d; animation-duration: 1s; ' class='alert alert-danger' role='alert'><center>$msgErro</center></div>";
		unset($_SESSION['altSenhaMsg']);
	}
		
?>
		<div class="container">
			<div class="btnAlterarPopUp">
				<h1>Alterar Senha</h1>

				<form method="POST" action="BDalterarSenha.php">
					<input type="hidden" name="tokenFrmAltSenha" value="<?php echo $_SESSION['TSFAltSenha']; ?>">

					<label>Digite sua senha atual:</label>
					<input type="password" name="SenhaAtual" id="idExibirSenhaAtual" required>

					<label>Digite a sua nova senha:</label>
					<input type="password" name="NovaSenha" oninput="validarSenha()" id="idExibirNovaSenha" required>

					<label>Confirme a sua nova senha</label>
					<input type="password" name="ConfirmarSenha" id="idExibirConfirmarSenha" required>

					<label class="lblErro" id="idLblSenhaErro">
						As senhas devem conter ao menos 8 caracteres e no máximo 20, com ao menos: 1 número, 1 letra maiúscula e minúscula e 1 caractere especial.
					</label>

					<button type="submit">Alterar Senha</button>
				</form>
			</div>
		</div>


</body>

</html>

<script>

function exibirSenhaAtualFuncao()
{
	var CampoSenha = document.getElementById('idExibirSenhaAtual');
	if (CampoSenha.type == "password")
		CampoSenha.type = "text";
	else
		CampoSenha.type = "password";
}

function exibirNovaSenhaFuncao()
{
	var CampoSenha = document.getElementById('idExibirNovaSenha');
	if (CampoSenha.type == "password")
		CampoSenha.type = "text";
	else
		CampoSenha.type = "password";
}

function exibirConfirmarSenhaFuncao()
{
	var CampoSenha = document.getElementById('idExibirConfirmarSenha');
	if (CampoSenha.type == "password")
		CampoSenha.type = "text";
	else
		CampoSenha.type = "password";
}
</script>

<script>
var lblErroSenha = document.getElementById('idLblSenhaErro');
lblErroSenha.style.display = 'none';
function validarSenha()
{
	var senha = document.getElementById("idExibirNovaSenha").value; //Aa1%3698521470123654
	function validarSenha(senha)
	{
		if (senha != "")
		{
			if (senha.length < 8 || senha.length > 20)
				return false;
			else
			{
				var regex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%¨&*()]).{8,20}$/;
				return regex.test(senha); //verifica se a senha corresponde aos padrões
			}
		}
		else
			return true;
			
	}

	if (validarSenha(senha))
		lblErroSenha.style.display = 'none';
	else
		lblErroSenha.style.display = 'block';
}

</script>