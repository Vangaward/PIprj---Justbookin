<?php

require_once 'classes/Cripto.php';
session_start();
include_once('conexao.php');
date_default_timezone_set('America/Sao_Paulo');

require_once ('models/loginModel.php');

/**/

/*Tokens de forms*/

$_SESSION['TSFCriarConta'] = bin2hex(random_bytes(32));

if (!isset($_SESSION['TSFLogin']))
{
	$_SESSION['TSFLogin'] = bin2hex(random_bytes(32));
}
if (!isset($_SESSION['TSFReSe']))
{
	$_SESSION['TSFReSe'] = bin2hex(random_bytes(32));
}

/*Fim de tokens de forms*/

if (!isset($_SESSION['marcaPagina']))
{
	$_SESSION['marcaPagina'] = 1; //Define em qual página o livro deverá abrir. | 0 = criarConta | 1 = Login
}

if (isset($_SESSION['logado'])) // Se o usuário tentar acessar a página de criar conta mas estiver logado
{
	header('Location: ../inicio.php');
}

if (isset($_SESSION['logado'])) // Se o usuário tentar acessar a página de login e estiver logado
{
    //O mesmo bloco de código que está no arquivo Vlogin.php foi reescrito aqui ao invés de incluir o Vlogin.php para evitra bugs.
    $idUsuarioSessao = $_SESSION['idUsuario'];
	$sql = "SELECT * FROM usuario WHERE idUsuario = '$idUsuarioSessao'";
	$resultado = mysqli_query($conexao, $sql);
	$dadosLogin = mysqli_fetch_array($resultado);
	//----------------------------------------------------

	/*
	1 - Adms
	2 - Editoras
	3 - Usuário padrão
	*/
	header('Location: ../inicio.php');
}

  // Verificar qual formulário foi enviado
  $redirFunc;
  if (isset($_POST['btnGoLogin']))
  {
      $_SESSION['$currentLocationPHP'] = 2;
  }
  if (isset($_POST['btnGoCriarConta']))
  {
      $_SESSION['$currentLocationPHP'] = 3;
  }
  if (isset($_POST['goEsqueciSenha']))
  {
      $_SESSION['$currentLocationPHP'] = 4;
  }

/**/

list($msgErroLogin, $msgErroConta) = getMensagem();

$_SESSION['rota'] = true;
include_once('login/index.php');
unset($_SESSION['rota']);

?>