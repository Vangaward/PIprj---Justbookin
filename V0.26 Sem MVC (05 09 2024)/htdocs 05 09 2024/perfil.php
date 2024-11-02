<?php
include_once ('Vlogin.php');

include_once("conexao.php");

$lad = "asc"; //Filtros
$meuUsuario;

if (isset($_GET['lad']))
{
	if ($_GET['lad'] == "desc")
		$lad = $_GET['lad'];
	if ($_GET['lad'] == "asc")
		$lad = $_GET['lad'];
}

if (isset($_GET['i'])) //Não estou acessando meu perfil
{
	if ($logado == 1)
	{
		if ($_GET['i'] != sha1($dadosLogin['idUsuario']))
		{
			$idUsuarioSha1 = $_GET['i'];
			$meuUsuario = false;
		}
	}
	if ($logado == 0)
	{
		$idUsuarioSha1 = $_GET['i'];
		$meuUsuario = false;
	}
}
if ($logado == 1)
{
	if (!isset($_GET['i'])) //estou acessando meu perfil com o meu id na url
	{	
		$idUsuarioSha1 = sha1($dadosLogin['idUsuario']);//estou acessando meu perfil sem o meu id na url
		$meuUsuario = true;
	}
	else if ($_GET['i'] == sha1($dadosLogin['idUsuario']))
	{
		$idUsuarioSha1 = sha1($dadosLogin['idUsuario']);
		$meuUsuario = true;
	}
}

// Preparar a consulta SQL usando um prepared statement
$queryUsuario = "SELECT * FROM usuario WHERE sha1(idUsuario) = ?";
$stmt = mysqli_prepare($conexao, $queryUsuario);

if ($stmt) {
    // Vincular o parâmetro ao prepared statement
    mysqli_stmt_bind_param($stmt, 's', $idUsuarioSha1);

    // Executar a consulta
    if (mysqli_stmt_execute($stmt)) {
        // Obter o resultado
        $result = mysqli_stmt_get_result($stmt);

        // Obter o número de linhas retornadas
        $numRowsqueryUsuario = mysqli_num_rows($result);

        // Verificar se há resultados
        if ($numRowsqueryUsuario > 0) {
            // Extrair dados se houver resultados
            $dadosUsuario = mysqli_fetch_array($result);
        } else {
            echo '<input type="button" onclick="window.location=\'index.php\';" value="Voltar"><br><br>';
            die('Usuário não encontrado');
        }
    } else {
        // Erro ao executar a consulta
        echo '<input type="button" onclick="window.location=\'index.php\';" value="Voltar"><br><br>';
        die('<b>Erro ao executar a consulta:</b> ' . mysqli_error($conexao));
    }

    // Fechar o statement
    mysqli_stmt_close($stmt);
} else {
    // Erro ao preparar a consulta
    echo '<input type="button" onclick="window.location=\'index.php\';" value="Voltar"><br><br>';
    die('<b>Erro ao preparar a consulta:</b> ' . mysqli_error($conexao));
} 
/*} else {
    // Erro ao preparar a consulta
    echo '<input type="button" onclick="window.location=\'index.php\';" value="Voltar"><br><br>';
    die('<b>Erro ao preparar a consulta:</b> ' . mysqli_error($conexao));
}*/

/*Verificar quantidade de literaturas publicadas*/
	 $queryLit = mysqli_query($conexao, "SELECT l.idLit, l.titulo, l.urlCapa, l.status, u.nomeUsuario, u.nome
	 FROM Literatura l
	INNER JOIN usuario u ON l.idUsuario = u.idUsuario where sha1(l.idUsuario) = '$idUsuarioSha1' order by l.idLit $lad;
	");
	 $queryLitPerfil = mysqli_query($conexao, "select * from usuario where sha1(idUsuario) = '$idUsuarioSha1';");
	if (!$queryLit || !$queryLitPerfil)
	{
		echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
		die('<b>Query Inválida:</b>');  
	}
			
	$qtdlits = mysqli_num_rows($queryLit);

	$dadosLitPerfil=mysqli_fetch_array($queryLitPerfil);
	
/*Verificar quantidade de seguidores*/
$idUsuarioSeguido = $dadosLitPerfil['idUsuario'];
$queryQtdSeguidores = mysqli_query($conexao, "SELECT * from seguidos where idUsuarioSeguido = '$idUsuarioSeguido'");
$qtdeSeguidores = mysqli_num_rows($queryQtdSeguidores);

/*Verificar se está seguindo*/
$estaSeguindo = false;
if ($logado == 1){
	$idUsuarioLogado = $dadosLogin['idUsuario'];
	$queryInscrito = mysqli_query($conexao, "SELECT * from seguidos where idUsuario = '$idUsuarioLogado' && idUsuarioSeguido = '$idUsuarioSeguido'");
	if (mysqli_num_rows($queryInscrito) > 0)
	{$estaSeguindo = true; }
}

?>

<!doctype HTML>
<html lang="pt-br">

<head>
<title>Perfil</title>
<?php include_once("detalhesHead.php"); ?>
<link rel="stylesheet" href="Balacowork/Balacowork.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Arimo">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Armata">
</head>

<?php include_once("Styles/perfil.css");?>
<?php include_once('Styles/card.css');?>
<?php include_once('Responsividade/responsividade.css');?>

<body>
<?php
if ($numRowsqueryUsuario < 1)
{
	include_once('header.php');
	?>
	
	<label style="font-size: 35px;">O perfil do usuário não foi encontrado</label><br>
	<?php if ($logado == 0) { ?><label style="font-size: 20px;">Se você está tentando acessar o seu perfil, <a href="login">faça login</a>.</label><?php } ?>
	
	<?php include_once('footer.php'); die();
}
?>

<div class="image-container">
<img class="Banner" src="imagens/Banner.svg">
</div>

<?php

$urlFotoPerfil;
if ($dadosLitPerfil['urlFotoPerfil'] == "")
{ $urlFotoPerfil = "imagens/userPerfil.svg";}else{$urlFotoPerfil = 'fotosPerfil/' . $dadosLitPerfil['urlFotoPerfil'];}

?>

<img class="imgPerfil" src="<?php echo $urlFotoPerfil; ?>" <?php if ($meuUsuario) { ?> onclick="openPopupImgPerfilEdit()" style="cursor: pointer;"<?php } ?>>

<label class="nomeUsuario"><?php echo $dadosLitPerfil['nomeUsuario']; if ($meuUsuario == true) { ?>(Seu perfil)<?php } ?></label>
<label><?php echo $dadosLitPerfil['nome'] . " " . $dadosLitPerfil['sobrenome']; ?></label>
<div class="statsUser">
<label class="NumInscritos"><?php echo $qtdeSeguidores; if ($qtdeSeguidores == 1){ ?> Seguidor<?php }else{ ?> Seguidores<?php ;} ?>
<label class="NumObras"><?php echo $qtdlits; if ($qtdlits == 1){ ?> Obra<?php }else{ ?> Obras<?php ;} ?></label>
</div>

<?php if ($meuUsuario){ ?>
<button onclick="location.href='alterarSenha.php'">Alterar Senha</button>
<?php } ?>

<?php include_once('header.php');?>
<?php
if (isset($_SESSION['perfilMsg']))
{
        $msgErro="";
        if ($_SESSION['perfilMsg'] == 1)
        {
            $msgErro = "A extensão do arquivo não é permitida, selecione apenas arquivos .jpg, .jpeg ou .png";
        }
		if ($_SESSION['perfilMsg'] == 2)
        {
            $msgErro = "O nome do arquivo não deve conter mais de 41 caractes!";
        }
		if ($_SESSION['perfilMsg'] == 3)
        {
            $msgErro = "Pedimos desculpas, houve um erro da nossa parte, por favor, teve novamente!";
        }

        echo "<div style='animation-name: Rotacao3d; animation-duration: 1s; ' class='alert alert-danger' role='alert'><center>$msgErro</center></div>";

    unset($_SESSION['perfilMsg']);
}
?>

<!--Poupop lit publicada com sucesso-->
<?php if (isset($_SESSION['msgLitPubli'])) { if($_SESSION['msgLitPubli'] == true) { ?>
<div id="popup-container">
        <div id="popup">
            <h2>Publicado com sucesso!</h2>
            <p>Sua literatura foi publicada com sucesso</p>
            <button onclick="fecharPopup()" class="btnExcluirPopUp">OK</button>
        </div>
    </div>
	
<?php unset($_SESSION['msgLitPubli']); } } ?>

	<!--popup da imagem-->
	<div class="popup-containerChamadoPorBotao" id="popup-containerImgPerfil">
        <div class="popupChamadoPorBotao">
            <div class="cabecalhoPopup"><h2 class="h2CarregandoImgPerfil">Aguarde...</h2><img class="gifCarregandoImgPerfil" src="imagens/loading4.gif"></div>
            <p>Não feche essa janela enquanto atualizamos a sua foto de perfil.</p>
        </div>
    </div>

<!--Poupop lit excluída com sucesso-->
<?php if (isset($_SESSION['msgBDExLit'])) { if($_SESSION['msgBDExLit'] == 2) { ?>
<div id="popup-container">
        <div id="popup">
            <h2>Excluído com sucesso!</h2>
            <p>Sua literatura foi excluída com sucesso</p>
            <button onclick="fecharPopup()" class="btnOkPopUp">OK</button>
        </div>
    </div>
	
<?php unset($_SESSION['msgBDExLit']); } } ?>

<?php if ($meuUsuario) { ?>
<form name="frmFotoPerfil" id="frmFotoPerfilId" method="post" action="BDFotoPerfil.php" enctype="multipart/form-data">

<!--popup excluir imagem-->
	<div class="popup-containerChamadoPorBotao" id="popup-containerExcluirImgPerfil">
        <div class="popupChamadoPorBotao">
            <h2>Tem certeza de que deseja excluir a sua foto de perfil?</h2>
			<div class="botoes">
				<input class="btnCancelarPopUp" type="button" onclick="fecharPopupExcluirImgPerfil()" value="Cancelar">
				<button type="submit" name="excluFoto" class="btnExcluirPopUp">Excluir</button>
			</div>
		</div>
    </div>
	<div class="popup-containerChamadoPorBotao" id="popup-containerImgPerfilEdit">
        <div class="popupChamadoPorBotao fotoPerfilEdit">
			<h2>Foto de Perfil</h2>
			<div class="botoes" style="flex-direction: column">
				<label for="arquivoFotoPerfilId" class="btnAlterarPopUp">
				<span><?php if ($dadosLitPerfil['urlFotoPerfil'] == ""){?>Adicionar<?php }else{ ?>Alterar<?php } ?></span>
				<input class="btnAlterarPopUp" type="file" id="arquivoFotoPerfilId" name="arquivoFotoPerfil" onchange="enviarFormulario()" accept="image/*"></label><?php if ($dadosLogin['urlFotoPerfil'] != ""){ ?>
				<button class="btnExcluirPopUp" type="button" onclick="openPopupExcluirImgPerfil()">Excluir</button><?php } ?>
				<button class="btnCancelarPopUp" type="button" onclick="fecharPopupImgPerfilEdit()">Cancelar</button>
			</div>
		</div>
	</div>
</form>
<?php } ?>

<?php if ($meuUsuario == false) { ?><button id="btnSeguir" onclick="inscreverSeAjax()"<?php if ($estaSeguindo){?> class="btnDeixarDeSeguir">Deixar de seguir<?php }else{?> class="btnSeguir">Seguir<?php } ?></button><?php } ?>

<div class="containerFlex">
<br>
<label class="lblObras"><?php if ($meuUsuario == true) { ?>SUAS OBRAS:<?php } else { ?> OBRAS DE <?php echo $dadosLitPerfil['nome'] . ":"; } ?></label>
<br>
    <script>
        function toggleDropdown() {
            var dropdownContent = document.getElementById("dropdown-content");
            if (dropdownContent.style.display === "none" || dropdownContent.style.display === "") {
                dropdownContent.style.display = "block";
            } else {
                dropdownContent.style.display = "none";
            }
        }
    </script>

<div class="dropdown">
    <button class="filtro" onclick="toggleDropdown()"><?php include_once('icones/Funnel.svg'); ?></button>
    <div class="dropdown-content" id="dropdown-content">
        <a href="#" onclick="ordemAsc()">Crescente</a>
        <a href="#" onclick="ordemDesc()">Decrescente</a>
    </div>
</div>
</div>
<div id="containerObrasId" class="containerObras">

<?php

if ($qtdlits <= 0 && $meuUsuario == true)
{ ?>
	<label><h2>Você ainda não publicou nenhuma literatura.</h2></label>
<?php }
if ($qtdlits <= 0 && $meuUsuario == false){ ?>
	<label><h2>Esse perfil ainda não publicou nenhuma literatura.</h2></label>
<?php } ?>

<div class="row">

	<?php while($dadosLit=mysqli_fetch_array($queryLit)){ 
	if ($dadosLit['urlCapa'] == "")
	{$img = "imagens/batata.png";}else{$img = "imagensCapa/" . $dadosLit['urlCapa'];}
		
		$idLitCard = sha1($dadosLit['idLit']);
		$titulo = $dadosLit['titulo'];
		$nomeUser = $dadosLit['nomeUsuario']; 
		if ($dadosLit['status'] == 1 && !$meuUsuario){
			$titulo = "Literatura privada";
			$img = "imagens/batata.png";
		}
		else if ($dadosLit['status'] == 2 && !$meuUsuario){
			$titulo = "Literatura bloqueada";
			$img = "imagens/batata.png";
		}
		
		?>
		<div class="col-6 col-sm-4 col-md-3 col-lg-2">
		<?php include("cardLivro.php"); ?>
		</div>
	<?php } ?>

</div><!--row-->

</div> <!--containerObras-->

<?php include_once('footer.php'); ?>

</body>

</html>

<script>
        function fecharPopup() {
            var popupContainer = document.getElementById("popup-container");
            popupContainer.style.display = "none";
        }
		function fecharPopupExcluirImgPerfil ()
		{
			var popupContainer = document.getElementById("popup-containerExcluirImgPerfil");
            popupContainer.style.display = "none";
		}
		function fecharPopupImgPerfilEdit ()
		{
			var popupContainer = document.getElementById("popup-containerImgPerfilEdit");
            popupContainer.style.display = "none";
		}
    </script>
	
	
<script language="Javascript">

function ordemDesc ()
{
	 window.location.href = 'perfil.php?i=<?php echo $idUsuarioSha1; ?>&lad=desc#containerObrasId'; //lad = Literaturas - Asc ou Desc
}
function ordemAsc ()
{
	 window.location.href = 'perfil.php?i=<?php echo $idUsuarioSha1; ?>&lad=asc#containerObrasId';
}

</script>
<script>
$(window).on('scroll', function() {
    let scrollTop = $(this).scrollTop();

    // Mova o banner a uma velocidade um pouco mais rápida que a rolagem normal
    $('.Banner').css('transform', 'translate3d(0,' + (scrollTop * 0.5) + 'px, 0)');
});
</script>

<script>
    function enviarFormulario() {
        // Obtém o formulário pelo ID
        var formulario = document.getElementById('frmFotoPerfilId');
		var inputArquivoPerfil = document.getElementById('arquivoFotoPerfilId');
		var tamanhoMaximoNome = 41;
		// Verificar o campo de capa
            if (inputArquivoPerfil.files[0]) {
                var nomeArquivoPerfil = inputArquivoPerfil.files[0].name;
                // Verificar o tamanho do nome
                if (nomeArquivoPerfil.length > tamanhoMaximoNome) {
                    alert('O nome do arquivo da foto de perfil é muito grande. Por favor, escolha um nome de arquivo mais curto. (Máximo de 41 caracteres)');
					window.location.reload();
				}
				else
				{
					// Envia o formulário
					openPopupImgPerfil();
					formulario.submit();
				}
					
            }
		
    }
</script>

<script>
function openPopupImgPerfil() {
    var containerImgPerfil = document.getElementById('popup-containerImgPerfil');
    containerImgPerfil.style.display = 'flex';
}
</script>

<script>
function openPopupExcluirImgPerfil() {
    var containerImgPerfil = document.getElementById('popup-containerExcluirImgPerfil');
    containerImgPerfil.style.display = 'flex';
}
</script>
<script>
function openPopupImgPerfilEdit() {
    var containerImgPerfil = document.getElementById('popup-containerImgPerfilEdit');
    containerImgPerfil.style.display = 'flex';
}
</script>
<?php if ($meuUsuario == false) { ?>
<script>
//Função para ajax do botão de Insecrever-se
function inscreverSeAjax() {
	document.getElementById('btnSeguir').textContent = '...';
	if (<?php echo $logado; ?> == 0){window.location.href = 'login';}
	else
	{
		var xhr = new XMLHttpRequest();

		// Configura a requisição
		xhr.open("GET", "ajax/ajaxBDInscreverSe.php?i=<?php echo $_GET['i']; ?>", true);
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.onload = function () {
			if (xhr.status >= 200 && xhr.status < 300) {
				// Parse JSON para obter os valores atualizados
				var dados = JSON.parse(xhr.responseText);

				// Acessa os valores do objeto JSON
				const usuarioDiferente = dados.usuarioDiferente;
				const sucesso = dados.sucesso;
				const acao = dados.acao;
				
				if (!usuarioDiferente)
				{alert("você não pode seguir o seu próprio perfil!");}
				else if (!sucesso)
				{alert("Houve um erro inesperado");}
				else{
					
					if (acao == "NaoSeguir")
					{
						document.getElementById('btnSeguir').textContent = 'Seguir';
						document.getElementById('btnSeguir').classList.replace('btnDeixarDeSeguir', 'btnSeguir');
					}
					else
					{
						document.getElementById('btnSeguir').textContent = 'Deixar de seguir';
						document.getElementById('btnSeguir').classList.replace('btnSeguir', 'btnDeixarDeSeguir');
					}
					
				}
				
			} else {
			console.error("Erro ao chamar o script PHP.");
			}
		};
		xhr.send(); // Envia a solicitação
	}
}

</script>
<?php } ?>