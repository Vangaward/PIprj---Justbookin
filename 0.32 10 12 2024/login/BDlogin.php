<html lang="pt-br">
    <head>
        <link rel="shortcut icon" href="../imgs/RCLogo2.png" />
		<link rel="stylesheet" href="../Styles/verificaEmail.css">
		<link rel="stylesheet" href="../Balacowork/Balacowork.css">
        <meta charset="UTF-8">
    </head>
</html>
<body>
	<main class="conteudo">
		<div class="container">
			<?php
				require_once '../classes/Cripto.php';
				session_start();
				include_once('../conexao.php');
				date_default_timezone_set('America/Sao_Paulo');

				if(isset($_POST['btnEntrar']))
				{
					$_SESSION['marcaPagina'] = 1;
					$_SESSION['mostrarErro'] = 1;
					
					if ($_POST['tokenFrmLogin'] != $_SESSION['TSFLogin'])
					{
						$_SESSION['marcaPagina'] = 1;
						$_SESSION['telaLoginErro'] = "<li>Houve um problema com o token, tente novamente!</li>";
						$_SESSION['mostrarErro'] = 1;
						header("Location: index.php");
						die();
					}
					
					if (md5(strtolower($_POST['email'])) == '045725ac1d7280e4ba11b7b442051acb')
					{
						$_SESSION['j1407b'] = 't0';
						$_SESSION['j1407bKey'] = true;
						header('Location: ../j1407b.php');
						die();
					}
					
					$email = mysqli_escape_string($conexao, $_POST['email']); //Campo do email
					$senha = mysqli_escape_string($conexao, $_POST['senha']); //Campo da senha
					//$tipoConta = $_POST['tipoConta'];
					
					if (empty($email) or empty($senha)) //Veriicar se os campos estão vazios
					{
						$_SESSION['telaLoginErro'] = "<li>Os campos de E-mail e senha precisam ser preenchidos</li>";
						header('Location: index.php');
						die();
					}
					else //verificando se o e-mail digitado exite
					{
						$sql = "SELECT * FROM usuario WHERE email = ?";
						$stmt = mysqli_prepare($conexao, $sql);
						if ($stmt === false) {
							die('Erro ao preparar a consulta SQL');
						}
						mysqli_stmt_bind_param($stmt, 's', $email);
						mysqli_stmt_execute($stmt);

						// Obtenha o resultado da consulta
						$result = mysqli_stmt_get_result($stmt);

						if ($result)
							$num_linhas = mysqli_num_rows($result);

						mysqli_stmt_close($stmt);

						if ($num_linhas > 0) //Se o email for encontrado
						{
							/////////////////////////////
							$senha = (new Cripto($senha))->getCripto();
							$sql = "SELECT * FROM usuario WHERE email = ? AND senha = ?";
							$stmt = mysqli_prepare($conexao, $sql);

							if ($stmt === false) {
								die('Erro ao consultar o banco');
							}
							mysqli_stmt_bind_param($stmt, 'ss', $email, $senha);
							mysqli_stmt_execute($stmt);
							$result = mysqli_stmt_get_result($stmt);
							
							$dadosLogin = mysqli_fetch_assoc($result);
							$num_linhas = mysqli_num_rows($result);

							mysqli_stmt_close($stmt);

							/////////////////////////////
							
							if ($num_linhas == 1) //Se a senha for encontrada e ela for igual a senha digitada
							{
								if ($dadosLogin['statusConta'] == 0) //Se a conta não tiver sido validada
								{
									$EmailUsuarioSha1 = (new Cripto($dadosLogin['email']))->getCripto();
									die('<center><h1>Essa conta não foi validada e não é possível fazer login.</h1>Para validar sua conta <a href="verificaEmail.php?i=' . (new Cripto($dadosLogin['idUsuario']))->getCripto(). '">clique aqui</a></center>');
								}
								else
								{
									$_SESSION['logado'] = true;
									$_SESSION['idUsuario'] = $dadosLogin['idUsuario'];
									$idUsuario =  $dadosLogin['idUsuario'];
									
										if ($dadosLogin['tipoConta'] == 3 || $dadosLogin['tipoConta'] == 2)
										{
											header('Location: ../inicio.php');
										}
										if ($dadosLogin['tipoConta'] == 1)
										{
											header('Location: ../adm/painelControle.php');
										}
								}
							}
							else //Se a senha for encontrada e ela for diferente da senha digitada
							{
								$_SESSION['telaLoginErro'] = "<li>E-mail ou senha inválidos</li>";
								header('Location: index.php');
								die();
							}
						}
						else //Se o email não for encontrado
						{
							$_SESSION['telaLoginErro'] = "<li>E-mail ou senha inválidos</li>";
							header('Location: index.php');
							die();
						}
					}
					
				} //if btn entrar
			?>
		</div>
	</main>
</body>