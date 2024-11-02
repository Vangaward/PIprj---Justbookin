<?php
header('Content-Type: text/html; charset=UTF-8');

include_once ('conexao.php');
include_once ('Vlogin.php');
include_once ('Vcli.php');
include_once ('rsnl.php');
include_once ('configs.php');

$senhaAtual = $_POST['SenhaAtual'];
$novaSenha = $_POST['NovaSenha'];
$confirmarSenha = $_POST['ConfirmarSenha'];

if ($_POST['tokenFrmAltSenha'] != $_SESSION['TSFAltSenha'])
{
	$_SESSION['altSenhaMsg'] = 5;
	header('Location: alterarSenha.php');
	die();
}
else
{
	unset($_SESSION['TSFAltSenha']);
}

/*Verificar se há problemas com a senha*/

if ($dadosLogin['senha'] != sha1($senhaAtual))
{
	$_SESSION['altSenhaMsg'] = 1;
	header('Location: alterarSenha.php');
	die();
}
else if ($novaSenha != $confirmarSenha)
{
	$_SESSION['altSenhaMsg'] = 2;
	header('Location: alterarSenha.php');
	die();
}
else if (sha1($novaSenha) == $dadosLogin['senha'])
{
	$_SESSION['altSenhaMsg'] = 3;
	header('Location: alterarSenha.php');
	die();
}

function validarSenha($senha)
{
    // Verifica se a string tem entre 8 e 20 caracteres
    if (strlen($senha) < 8 || strlen($senha) > 20) {
        return false;
    }
    
    // Verifica se a string possui uma letra maiúscula, uma letra minúscula, um número e pelo menos um caractere especial
    if (preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%¨&*()]).{8,20}$/', $senha)) {
        return true;
    } else {
        return false;
    }
}
if (!validarSenha($novaSenha))
{
	$_SESSION['altSenhaMsg'] = 4;
	header('Location: alterarSenha.php');
	die();
}

/*Fim de*/


//Update da senha
	$stmt = mysqli_prepare($conexao, "UPDATE usuario SET senha=? where idUsuario = ?");
	if (!$stmt) {
		// Se ocorreu um erro na preparação da consulta, exibir uma mensagem de erro e interromper o script
		echo '<br><input type="button" onclick="window.location='."'../index.php'".';" value="Voltar ao início"><br><br>';
		die('<style> .erro { background-color: red; color: #ffffff;}</style><div class="erro"><b>Query Inválida:</b><br>Ocorreu um erro inesperado.</div><br>' . mysqli_error($conexao));
	}
	mysqli_stmt_bind_param($stmt, "si", sha1($novaSenha), $dadosLogin['idUsuario']);

	mysqli_stmt_execute($stmt);
	$ultimoIdInserido = mysqli_insert_id($conexao);
	mysqli_stmt_close($stmt);
	
    header('Location: perfil.php');
    exit;

	$conexao->close();

?>