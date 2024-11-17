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

/**//**//**//**/

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