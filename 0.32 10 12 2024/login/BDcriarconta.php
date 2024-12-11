<?php
//die("Temporariamente não disponível.");
require_once '../classes/Cripto.php';

include_once('../conexao.php');

session_start();

if ($_POST['tokenFrmCriarConta'] != $_SESSION['TSFCriarConta'])
{
	$_SESSION['marcaPagina'] = 0;
	$_SESSION['msgErroCriarConta'] = 5;
	header("Location: index.php");
	die();
}
else
{
	unset($_SESSION['TSFCriarConta']);
}

$_SESSION['marcaPagina'] = 0;

$nome = $_POST['nome'];
$sobrenome = $_POST['sobrenome'];
$nomeUsuario = $_POST['nomeUsuario'];
$emailUsuario = $_POST['email'];
$senhaUsuario = $_POST['senha'];
$repetirSenha = $_POST['repetirSenha'];
$dataUsuario = $_POST['data'];

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

if (!validarSenha($senhaUsuario)) {
    $_SESSION['msgErroCriarConta'] = 4;
    header('Location: index.php');
    die();
}

$dataHoje = date('Y-m-d');

if ($dataUsuario > $dataHoje) //Aa@555555
{
    $_SESSION['msgErroCriarConta'] = 6;
    header('Location: index.php');
    die();
}

//die("Morri daqui da pra baixo");

if ($emailUsuario == null || $nomeUsuario == null)
{
	die("Houve um erro inesperado!");
}

$senhaUsuarioSha1 = (new Cripto($senhaUsuario))->getCripto();

$existeNomeUsuario = false;
$existeEmail = false;

//Buscar se o e-mail é existe
$stmt = $conexao->prepare("SELECT * FROM usuario WHERE email LIKE ?");
$stmt->bind_param("s", $emailUsuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $_SESSION['msgErroCriarConta'] = 2;
    header('Location: index.php');
    die();
}
$stmt->close();
//Buscar se o nome de usuário já existe
$stmt = $conexao->prepare("SELECT * FROM usuario WHERE nomeUsuario LIKE ?");
$stmt->bind_param("s", strtolower($nomeUsuario));
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0 || strtolower($nomeUsuario) == "j1407b") {
    $_SESSION['msgErroCriarConta'] = 3;
    header('Location: index.php');
    die();
}
$stmt->close();

if ($senhaUsuario != $repetirSenha)
{
	$_SESSION['msgErroCriarConta'] = 1;
	header('Location: index.php');
	die();
}
else
{
	//Inserir na tabela usuario
	$fotoPerfil = ""; $statusConta = 0; $tipoConta = 3;
	$stmt = mysqli_prepare($conexao, "INSERT INTO usuario (nome, sobrenome, nomeUsuario, email, senha, dataNascimento, urlFotoPerfil, statusConta, tipoConta) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
	if (!$stmt) {
		// Se ocorreu um erro na preparação da consulta, exibir uma mensagem de erro e interromper o script
		echo '<br><input type="button" onclick="window.location='."'../index.php'".';" value="Voltar ao início"><br><br>';
		die('<style> .erro { background-color: red; color: #ffffff;}</style><div class="erro"><b>Query Inválida:</b><br>Ocorreu um erro inesperado.</div><br>' . mysqli_error($conexao));
	}
	mysqli_stmt_bind_param($stmt, "sssssssss", $nome, $sobrenome, $nomeUsuario, $emailUsuario, $senhaUsuarioSha1, $dataUsuario, $fotoPerfil, $statusConta, $tipoConta);

	mysqli_stmt_execute($stmt);
	$ultimoIdInserido = mysqli_insert_id($conexao);
	mysqli_stmt_close($stmt);
	
	//Inserir na tabela token
	$stmt = mysqli_prepare($conexao, "INSERT INTO token (idUsuarioToken) VALUES (?)");
	if (!$stmt) {
		echo '<br><input type="button" onclick="window.location='."'../index.php'".';" value="Voltar ao início"><br><br>';
		die('<style> .erro { background-color: red; color: #ffffff;}</style><div class="erro"><b>Query Inválida:</b><br>Ocorreu um erro inesperado.</div><br>' . mysqli_error($conexao));
	}
	mysqli_stmt_bind_param($stmt, "s", $ultimoIdInserido);

	mysqli_stmt_execute($stmt);
	
	mysqli_stmt_close($stmt);
	
    header('Location: verificaEmail.php?i=' . (new Cripto($ultimoIdInserido))->getCripto());
    exit;

	$conexao->close();
}
?>
