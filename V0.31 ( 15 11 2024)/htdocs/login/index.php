<?php include_once('forcaRota.php'); ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
     <?php include_once("detalhesHead.php");?>
    <title>Login|JustBookIn</title>
	<script src="https://kit.fontawesome.com/b0f29e9bfe.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="../Styles/fonte.css">
	<link rel="stylesheet" href="../Balacowork/Balacowork.css">
	<link rel="stylesheet" href="style_new.css">
</head>
<body id="bodyId">

<?php if ($msgErroLogin != null) { ?>
	<div style="position: absolute; top: 50px; animation-name: Rotacao3d; animation-duration: 1s; z-index: 1000;" class="alert alert-danger shadow"><div class="divErro"><?php echo $msgErroLogin; ?></div></div>
<?php } ?>

<?php if($msgErroConta != null){ ?>
	<div style="position: absolute; top: 50px; animation-name: Rotacao3d; animation-duration: 1s; " class="alert alert-danger shadow"><div class="divErro"><?php echo $msgErroConta; ?></div></div>	
<? } ?>
	
    <main>
        <div class="content">
			<button class="btnVoltar" onclick="location.href='../inicio.php'">Voltar</button>
<!-- Livro -->
            <div id="livro" class="livro">
<!-- Frente do Livro -->
                <div id="c1" class="capas">
                    <div class="capasFront">
                        <div class="capaFront">
                            <div class="conteudoFront">
                                <div class="conteudo">
                                    <span style="--corSVG: var(--cor3); width: 100%"><?php include('imagens/logotipo-justbookin.svg'); ?></span>
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
                                                <span style="--corSVG: var(--cor4Escuro); width: 100%; cursor: pointer" onclick="location.href='../inicio.php'"><?php include('imagens/logo-justbookin.svg'); ?></span>
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
                                        <span style="--corSVG: var(--cor4Escuro); width: 100%; cursor: pointer" onclick="location.href='../inicio.php'"><?php include('imagens/logo-justbookin.svg'); ?></span>
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
                                    <form class="conteudo" name="frmLogin" id="frmLogin" action="BDlogin.php" method="post">
										<input type="hidden" name="tokenFrmLogin" value="<?php echo $_SESSION['TSFLogin']; ?>">
                                        <h1 class="titulo">Entrar</h1>
                                        <div class="divLogin">
                                            <label class="lblCampo"  value="">E-mail:</label>
                                            <input class="campo txtCampo" type="text" placeholder="exemplo@email.com" name="email" id="emailEntrar" value="" required>
                                            <div class="gapErro"></div>
                                            <label class="lblCampo">Senha:</label>
											<div class="txtCampo">
												<input class="campo txtInvisivel" type="password" placeholder="••••••••" name="senha" id="senhaEntrar" value="" required>
												<button class="btnMostrar" type="button" text="Exibir senha" onclick="verSenha()"><?php include('icones/Mostrar.svg'); ?></button>
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
                            <form class="conteudo" name="frmRe" action="BDesqueciSenha.php" method="post">
								<input type="hidden" name="tokenFrmReSe" value="<?php echo $_SESSION['TSFReSe']; ?>">
                                        <h1 class="titulo">Redefinir senha</h1>
										<label id="txtRedefinir" class="txtLivro">Digite seu endereço de email de recuperação para que possamos enviar um email para a redefinição da senha.</label>
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
	<?php include('footer.php');?>
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
