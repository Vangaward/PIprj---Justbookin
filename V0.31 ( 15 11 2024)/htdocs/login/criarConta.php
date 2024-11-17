
<?php
die("Função não disponível nesta página");
//Sessão
session_start();

include_once('../conexao.php');

date_default_timezone_set('America/Sao_Paulo');

if (isset($_SESSION['logado'])) // Se o usuário tentar acessar a página de criar conta mas estiver logado
{
	header('Location: ../inicio.php');
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include_once("../detalhesHead.php");?>
    <title>Cadastro|JustBookIn</title>
	<link rel="stylesheet" href="../Styles/login.css">
    <script src="https://kit.fontawesome.com/b0f29e9bfe.js" crossorigin="anonymous"></script>
</head>

<?php include_once('style.css');?>

<?php include_once('../Styles/login.css');?>
<?php include_once('../Styles/fonte.css');?>

<body id="bodyId">

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
	
	echo '<div style="position: absolute; top: 50px; animation-name: Rotacao3d; animation-duration: 1s; " class="alert alert-danger shadow"><div class="divErro">' . $erro . '</div></div>';
	unset($_SESSION['msgErroCriarConta']);
}


?>

 <div class="capa" id="capa">

 </div><!--div capa-->
 <center>
<!-- Previous Button -->

    <button style="display: none;" id="prev-btn" class="btnEsquerdo">
        <i class="fas fa-arrow-circle-left"></i>
    </button>

    <!-- Book -->
    <div id="book" class="book">
        <!-- Paper 1 -->
        <div id="p1" class="paper">

            <div class="front">
                <div id="f1" class="front-content">
                    <img  src="../imagens/Justbookin2.PNG" style="width: 320px; height: 60px; flex-shrink: 0;  cursor: pointer;">
                </div>
            </div>

            <div class="back">
                <div id="b1" class="back-content">
               <label class="txtLogo"> Bem-Vindo à</label>
                <img  src="../imagens/Justbookin.png" style="width: 320px; height: 60px; flex-shrink: 0;  cursor: pointer;" onclick="location.href='../inicio.php'">
                <button class="btnVoltar" onclick="location.href='../inicio.php'">Voltar</button>
                </div>
            </div>
        </div>
        
        <!-- Paper 2 -->
        <div id="p2" class="paper">
            <div class="front">
                <div id="f2" class="front-content">
                    
                    <!--Cadastrar-->

		<div class="divForm">
			<form class="form" method="POST" action="BDcriarconta.php">
				<h1 class="titulo">Cadastrar</h1>
				<div class="divLogin">
					<div class="container">
						<div class="containerSenha">
							<label class="lblCampo">Nome:</label>
							<input class="txtCampo" type="text" name="nome" id="Nome" required>
							<div class="gapErro"></div>
						</div>
						<div class="containerSenha">
							<label class="lblCampo">Sobrenome:</label>
							<input class="txtCampo" type="text" name="sobrenome" id="Sobrenome">
							<div class="gapErro"></div>
						</div>
					</div>
					<label class="lblCampo">Nome de usuário:</label>
					<input class="txtCampo" type="text" oninput="atualizarDadosAjax(), removerEspacos()" name="nomeUsuario" id="nomeUsuarioId">
					<div class="gapErro">
						<label class="lblErro" id="idLblUsuarioErro">Esse nome de usuário já existe!</label>
					</div>
					<label class="lblCampo">E-mail:</label>
					<input class="txtCampo" oninput="atualizarDadosAjax(), removerEspacos()" placeholder="Exemplo@gmail.com" type="email" name="email" id="EmailId">
					<div class="gapErro">
						<label class="lblErro" id="idLblEmailErro">Esse E-mail já está cadastrado!</label>
					</div>
					<div class="container">
						<div class="containerSenha">
							<label class="lblCampo">Senha:</label>
							<input class="txtCampo" placeholder="••••••••" type="text" oninput="validarSenha()" name="senha" id="senhaid" required>
							<div class="gapErro">
								<label class="lblErro" id="idLblSenhaErro">As senhas devem conter ao menos 8 caracteres e no máximo 20, com ao menos: 1 número, 1 letra maiúscula e minúscula e 1 caractere especial</label>
							</div>
						</div>
						<div class="containerSenha">
							<label class="lblCampo">Confirme:</label>
							<input class="txtCampo" placeholder="••••••••" type="password" name="repetirSenha" id="repitaSenha" required>
							<div class="gapErro"></div>
						</div>
					</div>
					<label class="lblCampo">Data de nascimento:</label>
					<input class="txtCampo" type="date" name="data" id="Data" required>
					<div class="gapErro"></div>
					<div class="container">
						<input class="btnCadastrar" type="button" onclick="window.location.href='index.php'" value="Já tem uma conta?">
						<input class="btnEntrar" type="submit" value="Cadastrar" id="cadastrar" name="btnCadastrar"
					</div>
					<div id="erro-senha" style="color: red;"></div>
				</div>
			</form>
		</div>
	</div>
            
<!--Fim Login-->

                </div>
            </div>
            <div class="back">
                <div id="b2" class="back-content">
                      
                </div>
            </div>
        </div>
        <!-- Paper 3 -->
        <div id="p3" class="paper">
            <div class="front">
                <div id="f3" class="front-content">
                <label class="txtLogo"> Bem-Vindo à</label>
                <img  src="../imagens/Justbookin.png" style="width: 320px; height: 60px; flex-shrink: 0;  cursor: pointer;" onclick="location.href='../inicio.php'">
             
                </div>
            </div>
            <div class="back">
                <div id="b3" class="back-content">
                    <h1>Back 3</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Next Button -->
     <button style="display: none;" id="next-btn" class="btnDireito">
        <i class="fas fa-arrow-circle-right"></i>
    </button>

	</center>
	<!-- <div class="novo-codigo">
		<img class="espiral" src="../imagens/Espiral.png" alt="Imagem de Cabeçalho">
		<div class="input-container">
			<div>
				<form method="POST" action="BDcriarConta.php">
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<h1 class="titulo">Cadastrar</h1>
					<div class="divLogin">
						<label class="lblEmail">Nome:</label>
						<input class="txtSenha" type="text" name="nome" id="Nome" required>
						<label class="lblEmail">Sobrenome:</label>
						<input class="txtSenha" type="text" name="sobrenome" id="Sobrenome">
						<label class="lblEmail">Nome de usuário:</label><br>
						<input class="txtSenha" oninput="atualizarDadosAjax('caderno'), removerEspacos(), limpaCampos('caderno')" type="text" name="nomeUsuario" id="nomeUsuarioId2"><br>
						<label class="lblErro" id="idLblUsuarioErro" style="opacity: 0;">Esse nome de usuário já existe!</label>
						<label class="lblEmail">E-mail:</label>
						<input class="txtEmail" oninput="atualizarDadosAjax('caderno'), removerEspacos(), limpaCampos('caderno')" placeholder="Exemplo@gmail.com" type="text" name="emailUsuario" id="EmailId2" required>
						<label class="lblErro" id="idLblEmailErro" style="opacity: 0;">Esse E-mail já está cadastrado!</label>
						<div class="container">
							<label class="lblSenha1">Senha:</label>
							<input class="txtSenha1" placeholder="********" type="password" name="senhaUsuario" id="senha" required>
							<label class="lblSenha2" align="center" style="margin-right="-100px">Confirme:</label>
							<input class="txtSenha1" placeholder="********" type="password" name="senhaUsuario" id="senhaRepetida" onchange="verificaSenha()" required>
						</div>
						<label class="lblEmail">Data de nascimento:</label>
						<input class="txtSenha" type="date" name="dataUsuario" id="Data" required><br>
						<div class="container">
							<input class="btnCadastrar" type="button" onclick="window.location.href='index.php'" value="Já tem uma conta?">
							<br>
							<input class="btnEntrar" type="submit" value="Cadastrar" id="cadastrar" name="btnCadastrar">
						</div>
						<div id="erro-senha" style="color: red;"></div>
					</div>
				</form>
			</div>
		</div>
	</div> -->
</body>
</html>

<script>
function removerEspacos() {
    var inputNomeUsuario = document.getElementById("nomeUsuarioId");
    var inputEmail = document.getElementById("EmailId");
    inputNomeUsuario.value = inputNomeUsuario.value.replace(/\s/g, '');
    inputEmail.value = inputEmail.value.replace(/\s/g, '');
}
</script>

<script>
var lblErroSenha = document.getElementById('idLblSenhaErro');
lblErroSenha.style.display = 'none';
function validarSenha()
{
	var senha = document.getElementById("senhaid").value; //Aa1%3698521470123654
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

var lblUsuarioErro = document.getElementById("idLblUsuarioErro");
var lblEmailErro = document.getElementById("idLblEmailErro");

lblUsuarioErro.style.display = 'none';
lblEmailErro.style.display = 'none';

function atualizarDadosAjax() {
    var nomeUsuario, EmailUsuario;
	
        nomeUsuario = document.getElementById("nomeUsuarioId").value;
        EmailUsuario = document.getElementById("EmailId").value;
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
				document.getElementById('nomeUsuarioId').classList.replace('txtCampo', 'txtErro');
				lblUsuarioErro.style.display = 'block';
            } else {
				document.getElementById('nomeUsuarioId').classList.replace('txtErro', 'txtCampo');
				lblUsuarioErro.style.display = 'none';
            }

            if (emailExistente) {
				document.getElementById('EmailId').classList.replace('txtCampo', 'txtErro');
				lblEmailErro.style.display = 'block';
            } else {
				document.getElementById('EmailId').classList.replace('txtErro', 'txtCampo');
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

<script src="../bibliotecas/jquery.js"></script>


<script defer>// References to DOM Elements


var capa = document.getElementById("capa");

const prevBtn = document.querySelector("#prev-btn");
const nextBtn = document.querySelector("#next-btn");
const book = document.querySelector("#book");

const paper1 = document.querySelector("#p1");
const paper2 = document.querySelector("#p2");
const paper3 = document.querySelector("#p3");

// Event Listener
prevBtn.addEventListener("click", goPrevPage);
nextBtn.addEventListener("click", goNextPage);

// Business Logic
let currentLocation = 1;
let numOfPapers = 3;
let maxLocation = numOfPapers + 1;

function openBook() {
    book.style.transform = "translateX(50%)";
    prevBtn.style.transform = "translateX(-180px)";
    nextBtn.style.transform = "translateX(180px)";
}

function closeBook(isAtBeginning) {
    if(isAtBeginning) {
        book.style.transform = "translateX(0%)";
    } else {
        book.style.transform = "translateX(100%)";
    }
    
    prevBtn.style.transform = "translateX(0px)";
    nextBtn.style.transform = "translateX(0px)";
}

function goNextPage() {
    if(currentLocation < maxLocation) {
        switch(currentLocation) {
            case 1:
                openBook();
                paper1.classList.add("flipped");
                paper1.style.zIndex = 1;
                break;
            case 2:
                paper2.classList.add("flipped");
                paper2.style.zIndex = 2;
                break;
            case 3:
            capa.classList.add("fechar-animacao");
                paper3.classList.add("flipped");
                paper3.style.zIndex = 3;
                closeBook(false);
                break;
            default:
                throw new Error("unkown state");
        }
        currentLocation++;
    }
}

function goPrevPage() {
    if(currentLocation > 1) {
        switch(currentLocation) {
            case 2:
            capa.classList.add("fechar-animacao");
                closeBook(true);
                paper1.classList.remove("flipped");
                paper1.style.zIndex = 3;
                break;
            case 3:
                paper2.classList.remove("flipped");
                paper2.style.zIndex = 2;
                break;
            case 4:
                openBook();
                capa.classList.add("abrir-animacao");
                paper3.classList.remove("flipped");
                paper3.style.zIndex = 1;
                break;
            default:
                throw new Error("unkown state");
        }

        currentLocation--;
    }
}
var myTimeout = setTimeout(goLogin, 0780);

function goLogin()
{

    if(currentLocation < maxLocation)
    {
     switch(currentLocation)
     {
            case 1:
                openBook();
                paper1.classList.add("flipped");
                paper1.style.zIndex = 1;
                break;
     }
     currentLocation++;
    }
}

function goEsqueciSenha ()
{
    if(currentLocation < maxLocation)
    {
        switch(currentLocation)
        {
                case 1:
                    openBook();
                    paper1.classList.add("flipped");
                    paper1.style.zIndex = 1;
                    var myTimeout = setTimeout(goCC, 0600);
                    function goCC ()
                    {
                        paper2.classList.add("flipped");
                        paper2.style.zIndex = 2;
                        //var myTimeout = setTimeout(goES, 0600);
                    }
                    break;
                case 2:
                paper2.classList.add("flipped");
                paper2.style.zIndex = 2;
                break;


        }
        currentLocation = currentLocation + 1;
    }
}
function goBack3()
{
    switch(currentLocation)
        {
            case 2:
            paper2.classList.add("flipped");
            paper2.style.zIndex = 2;
            var myTimeout = setTimeout(goBK2, 0600);
            function goBK2 ()
            {
            paper3.classList.add("flipped");
            paper3.style.zIndex = 2;
            var myTimeout = setTimeout(goBK3, 0600);
            }
            function goBK3 ()
            {
            capa.classList.add("fechar-animacao");
                paper3.classList.add("flipped");
                paper3.style.zIndex = 3;
                closeBook(false);
            }
            break;

        }
        currentLocation = currentLocation + 2;
}

</script>

<!--Abaixo, script para botão de ver senha-->
<script language="Javascript">

    function verSenha ()
    {
        var senha1 = document.getElementById("senhaid");
        
        if (senha1.type == "password")
        {
            senhaid.type = ("text");
        }
        else
        {
            senhaid.type = ("password");
        }
    }
    
</script>