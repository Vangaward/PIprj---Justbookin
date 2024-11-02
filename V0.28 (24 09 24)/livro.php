<?php 

include_once ('conexao.php');
include_once ('Vlogin.php');
include_once ('Vcli.php');
include_once('configs.php');
include_once('helperBD.php');

$idLitSha1 = $_GET['i'];
$txtSemCat = "";
$txtSemCap = "";

$_SESSION['TSFAltCapa'] = bin2hex(random_bytes(32));
$_SESSION['TSFAltStAdm'] = bin2hex(random_bytes(32));
$_SESSION['TSFFavoritar'] = bin2hex(random_bytes(32));
$_SESSION['TSFLd'] = bin2hex(random_bytes(32));

$stmt = $conexao->prepare("SELECT l.idLit, l.idUsuario, l.views, l.descricao, l.titulo, l.urlCapa, l.dataLanc, l.dataEdit, l.status, l.urlPdf, 
                           u.nome, u.nomeUsuario, u.urlFotoPerfil 
                           FROM Literatura l 
                           INNER JOIN usuario u ON l.idUsuario = u.idUsuario 
                           WHERE sha1(l.idLit) = ?");
$stmt->bind_param('s', $idLitSha1);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    echo '<input type="button" onclick="window.location=\'index.php\';" value="Voltar"><br><br>';
    die('<b>Query Inválida:</b> ' . $conexao->error);
}
$numRows = $result->num_rows;
$dadosLit = $result->fetch_array();
$stmt->close();
$idLit = $dadosLit['idLit'];
if ($numRows < 1)
{
	die("Literatura não encontrada");
}

//Foto de perfil
$urlFotoPerfilDescricao;
if ($dadosLit['urlFotoPerfil'] == "")
{ $urlFotoPerfilDescricao = "imagens/userPerfil.svg";}
else{$urlFotoPerfilDescricao = 'fotosPerfil/' . $dadosLit['urlFotoPerfil'];}
//Fim de foto de perfil

$queryItemCat = mysqli_query($conexao, "SELECT c.nomeCategoria, c.idCategoria FROM itemCategoria ic
                                        INNER JOIN Categoria c ON ic.idCategoria = c.idCategoria
										where idLit = '$idLit';");
		if (!$queryItemCat)
		{
            echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
            die('<b>Query Inválida: </b>' . @mysqli_error($conexao));  
	    }
		if(mysqli_num_rows($queryItemCat) <=0)
		{
			$txtSemCat = "Não possui categorias";
		}
		
 $queryCapLit = mysqli_query($conexao, "SELECT * from capituloLit where idLit = '$idLit' ORDER BY numCapitulo asc;");
		if (!$queryCapLit)
		{
            echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
            die('<b>Query Inválida: </b>' . @mysqli_error($conexao));
	    }
		if(mysqli_num_rows($queryCapLit) <=0)
		{
			$txtSemCap = "Não possui capítulos";
		}
if ($logado == 1)
{
//queryFavoritos está aqui para o front-end do botão de favoritos
$estiloBtnFavoritar;
$idUsuario = $dadosLogin['idUsuario'];
$queryFavoritos = mysqli_query($conexao, "SELECT * from favorito where idLit = '$idLit' and idUsuario = '$idUsuario';");
			if (!$queryFavoritos) {
				$_SESSION['msgFav'] = 1;
				header('Location: livro.php?i=' . $idLitSha1);
			die ("Houve um erro ao carregar os recursos necessários. #1");
				}
			if (mysqli_num_rows($queryFavoritos) > 0)
			{
				$estiloBtnFavoritar = 1;
			}else{$estiloBtnFavoritar = 0;}
}

	if (isset($_SESSION['litAtual']))
	{ unset($_SESSION['litAtual']); }
	$_SESSION['litAtual'] = $dadosLit['idLit'];

/*Verificar se o perfil é do usuário logado*/
$meuUsuario = false;
	if ($logado == 1)
	{
		if ($dadosLit['idUsuario'] == $dadosLogin['idUsuario'])
		{
			$meuUsuario = true;
		}
	}

/*Verificar se está seguindo*/
	$estaSeguindo = false;
	if ($logado == 1){
		$idUsuarioLogado = $dadosLogin['idUsuario'];
		$idUsuarioSeguido = $dadosLit['idUsuario'];
		$queryInscrito = mysqli_query($conexao, "SELECT * from seguidos where idUsuario = '$idUsuarioLogado' && idUsuarioSeguido = '$idUsuarioSeguido'");
		if (mysqli_num_rows($queryInscrito) > 0)
		{$estaSeguindo = true; }
	}

?>

<!DOCTYPE html>

<script>
// Função para ajax do botão de like/deslike
function atualizarDadosAjax() {
    var xhr = new XMLHttpRequest();

    // Configura a requisição
    xhr.open("GET", "ajax/ajaxLike.php?i=<?php echo $idLitSha1; ?>", true);
	
	// Configura o cabeçalho para indicar uma requisição AJAX
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	
    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            // Parse JSON para obter os valores atualizados
            var dados = JSON.parse(xhr.responseText);

            // Acessa os valores do objeto JSON
            const qtdeLikes = dados.qtdeLikes;
            const qtdeDeslikes = dados.qtdeDeslikes;
            const porcentLikes = dados.porcentLikes;
            const likeDeslike = dados.likeDeslike;

            document.getElementById("lblLikeId").textContent = qtdeLikes;
            document.getElementById("lblDeslikeId").textContent = qtdeDeslikes;
			/*Botão*/
			if (likeDeslike == 1)
			{document.getElementById('idImgCurtir').src = "icones/GosteiFill.svg";
			 document.getElementById('idImgNaoCurtir').src = "icones/NaoGostei.svg";}
			if (likeDeslike == 0)
			{document.getElementById('idImgNaoCurtir').src = "icones/NaoGosteiFill.svg";
			 document.getElementById('idImgCurtir').src = "icones/Gostei.svg";}
			/*Barra like/deslike*/
			if (qtdeDeslikes == 0 && qtdeLikes == 0)
			{
				document.getElementById("metricaAvaliacaoExternaId").style.background = "var(--cinzaMaisClaro)"; //Cinza
			}else{
				document.getElementById("metricaAvaliacaoExternaId").style.backgroundImage = "var(--vermelhoGradiente)"; //Vermelho
				document.getElementById("metricaAvaliacaoExternaId").style.backgroundSize = "200% 100%";
			}
				document.getElementById("metricaAvaliacaoInternaId").style.width = porcentLikes + "%";
				// Faça algo com esses valores (por exemplo, atualizar labels)
			} else {
				console.error("Erro ao chamar o script PHP.");
			}
		};

		xhr.send(); // Envia a solicitação
	}
	atualizarDadosAjax();
	// Chama a função a cada 5000 milissegundos (5 segundos)
	setInterval(atualizarDadosAjax, 5000);
</script>

<html lang="pt-br">
	<head>
		<?php include_once("detalhesHead.php");?>
		<title><?php echo $dadosLit['titulo']; ?>|Justbookin</title>
		<link rel="stylesheet" href="Balacowork/Balacowork.css">
		<?php include_once("Styles/livro.css");?>
		<?php include_once("Styles/fonte.css");?>
	</head>
	<body>
		<?php include_once('header.php');?>	
		
		<?php
				$haCapa = false;
				if ($dadosLit['urlCapa'] == "")
				{
					$img = "imagens/batata.png";
				}
				else
				{
					$img = $dirCapa . $dadosLit['urlCapa'];
					$haCapa = true;
				}

			?>
		
		<?php if ($dadosLit['status'] > 0 && $meuUsuario || $dadosLit['status'] == 0 || $dadosLogin['tipoConta'] == 1 && $dadosLit['status'] != 1){ ?>
		<main class="conteudo">
		
				<?php /*Poup Editada com sucesso*/
				if (isset($_SESSION['msgLitEdit'])) { ?>
					<div id="popup-container">
							<div id="popup">
							<?php if($_SESSION['msgLitEdit'] == true){?>
								<h2>Editado com sucesso!</h2>
								<p>As informações foram salvas com sucesso</p>
							<?php }else{?>
								<h2 style="color: #9c0000;">ERRO!</h2>
								<p>Houve um erro inesperado ao tentar salvar as informações</p>
							<?php } ?>
								<button onclick="fecharPopup()" class="btnOkPopUp">OK</button>
							</div>
						</div>
				<?php unset($_SESSION['msgLitEdit']); } ?>
				
				<script>
					function fecharPopup() {
						var popupContainer = document.getElementById("popup-container");
						popupContainer.style.display = "none";
					}
					function fecharPopupExcluirImgPerfil ()
					{
						var popupContainer = document.getElementById("popup-containerExcluirImgCapaCofirmacao");
						popupContainer.style.display = "none";
					}
					function fecharPopupExcluirImgPerfil ()
					{
						var popupContainer = document.getElementById("popup-containerExcluirLiteratura");
						popupContainer.style.display = "none";
					}
				</script>
				
				<!--popup atualiza capa-->
	<div class="popup-containerChamadoPorBotao" id="popup-containerImgCapa">
        <div class="popupChamadoPorBotao">
            <div class="cabecalhoPopup"><h2 class="h2CarregandoImgPerfil">Aguarde...</h2><img class="gifCarregandoImgPerfil" src="imagens/loading4.gif"></div>
            <p>Não feche essa janela enquanto atualizamos a imagem de capa.</p>
        </div>
    </div>
					<!--popup excluindo capa-->
	<div class="popup-containerChamadoPorBotao" id="popup-containerExcluindoImgCapa">
        <div class="popupChamadoPorBotao">
            <div class="cabecalhoPopup"><h2 class="h2CarregandoImgPerfil">Aguarde...</h2><img class="gifCarregandoImgPerfil" src="imagens/loading4.gif"></div>
            <p>Não feche essa janela enquanto excluímos a imagem de capa.</p>
        </div>
    </div>
						<!--popup excluir capa confirmação-->
	<div class="popup-containerChamadoPorBotao" id="popup-containerExcluirImgCapaCofirmacao">
        <div class="popupChamadoPorBotao">
            <div class="cabecalhoPopup"><h2 class="h2CarregandoImgPerfil">Excluir capa?</h2></div>
            <p>Tem certeza de que deseja excluir a imagem de capa permanentemente?</p>
			<div class="opcoesPopUp">
				<button type="submit" onclick="fecharPopupExcluirImgPerfil()" class="botao vermelho">Não</button>
				<input class="botao vermelho" type="button" onclick="fecharPopupExcluirImgPerfil()" value="Não">
				<form name="frmAlterarCapa" action="BDalterarCapa.php?i=<?php echo $idLitSha1; ?>" method="POST">
				<input type="hidden" name="tokenFrmAltCap" value="<?php echo $_SESSION['TSFAltCapa']; ?>" >
				<button type="submit" onclick="fecharPopupExcluirImgPerfil(), openPopupExcluindoImgCapa()" name="excluCapa" class="botao verde">Sim</button>
			</form>
			</div>
        </div>
    </div>
			
	<!--popup excluir literatura-->
	<div class="popup-containerChamadoPorBotao" id="popup-containerExcluirLiteratura">
        <div class="popupChamadoPorBotao">
            <div class="cabecalhoPopup">
				<h2 class="tituloPopup">Excluir literatura?</h2>
				<p class="descricaoPopup">Tem certeza de que deseja excluir a sua Literatura? Está ação será irreversível.</p>
			</div>
			<div class="opcoesPopUp">
				<button type="submit" onclick="fecharPopupExcluirImgPerfil()" class="botao vermelho">Cancelar</button>
				<form name="frmAlterarCapa" action="BDalterarCapa.php?i=<?php echo $idLitSha1; ?>" method="POST">
				<input type="hidden" name="tokenFrmAltCap" value="<?php echo $_SESSION['TSFAltCapa']; ?>" >
				<button type="submit" onclick="fecharPopupExcluirImgPerfil(), openPopupExcluindoImgCapa()" name="excluCapa" class="botao verde">Confirmar</button>
			</form>
			</div>
        </div>
    </div>
			
			<?php 
				$erro;
				if (isset($_SESSION['msgFav'])) //magFav = mensagem de favoritar
				{
					if ($_SESSION['msgFav'] == 1)
					{
						$erro = "Houve um erro inesperado ao tentar favoritar a literatura.";
					}
					else if ($_SESSION['msgFav'] == 4)
					{
						$erro = "Houve um erro inesperado ao tentar desfavoritar a literatura.";
					}
					else if ($_SESSION['msgFav'] == 5)
					{
						$erro = "Houve um erro com o token";
					}
					
					echo '<div style="animation-name: Rotacao3d; animation-duration: 1s;" class="alert alert-danger shadow"><div class="divErro">' . $erro . '</div></div>';
					unset($_SESSION['msgFav']);
				}
				if (isset($_SESSION['msgLike']))
				{
					if ($_SESSION['msgLike'] == 1)
					{
						$erro = "Houve um erro inesperado, tente novamente mais tarde.";
					}
					
					echo '<div style="animation-name: Rotacao3d; animation-duration: 1s;" class="alert alert-danger shadow"><div class="divErro">' . $erro . '</div></div>';
					unset($_SESSION['msgLike']);
				}
				if (isset($_SESSION['msgEditar']))
				{
					if ($_SESSION['msgEditar'] == 1)
					{
						$erro = "Sua literatura está bloqueada, não é possível editá-la";
					}
					echo '<div style="animation-name: Rotacao3d; animation-duration: 1s;" class="alert alert-danger shadow"><div class="divErro">' . $erro . '</div></div>';
					unset($_SESSION['msgEditar']);
				}
				
				if (isset($_SESSION['editCapa']))
				{
					if ($_SESSION['editCapa'] == 1)
					$erro = "A extensão do arquivo não é permitida. Selecione apenas arquivos .jpg, .jpeg ou .png";
					else if ($_SESSION['editCapa'] == 2)
					$erro = "O nome do arquivo é muito grande. Por favor, escolha um nome de arquivo mais curto. (Máximo de 41 caracteres)";
					else if ($_SESSION['editCapa'] == 3)
					$erro = "Houve um erro inesperado por parte do servidor. Por favor, tente novamente mais tarde.";
				else if ($_SESSION['editCapa'] == 4)
					$erro = "Sua literatura está bloqueada, não é possível aterar a capa.";
				else if ($_SESSION['editCapa'] == 5)
					$erro = "Houve um problema com o token.";
					
					echo '<div style="animation-name: Rotacao3d; animation-duration: 1s;" class="alert alert-danger shadow"><div class="divErro">' . $erro . '</div></div>';
					unset($_SESSION['editCapa']);
				}

			?>
			
			<?php if ($dadosLit['status'] == 1){ ?>
			<label>Essa literatura é privada, somente você pode acessá-la.<br>Para alterar a visibilidade acesse a <a href="editarLivro.php?i=<?php echo $idLitSha1; ?>">página de edição</a>.</label>
			<?php } else if ($dadosLit['status'] == 2){ ?>
			<label>Sua literatura foi bloqueada pois provavelmente contém conteúdo não apropiado.<br>Enquanto estiver bloqueada ela não ficará mais visível para outros usuários no site. Para mais informações entre em contato.</label>
			<?php } ?>
			
			<div class="containerLivro">
				<div class="divCapa"><img class="imgCapa" src="<?php echo $img; ?>"></div>
				<div class="opcoesLivro">
					<div id="infoLivroId" class="infoLivro">
					
					<?php
					if ($logado == 1)
					{
					if ($dadosLogin['tipoConta'] == 1) {
						?>
					<form action="adm/BDalterarStatusLit.php?i=<?php echo $idLitSha1; ?>" method="POST">
					<input type="hidden" name="tokenFrmAltStAdm" value="<?php echo $_SESSION['TSFAltStAdm']; ?>" >
					<label>Alterar visibilidade: </label>
					<select name="sctAlterarVisibilidade" id="sctAlterarVisibilidadeId">
						<option value="0">Desbloqueada</option>
						<option value="2">Bloqueada</option>
					</select>
					<button>Alterar</button>
					</form>
					
					<script>
						function selecionarOpcao(index) {
							var select = document.getElementById('sctAlterarVisibilidadeId');
							if (index == 1)
								select.selectedIndex = 0;
							else if(index == 2)
								select.selectedIndex = 1;
						}
						selecionarOpcao(<?php echo $dadosLit['status']; ?>)
					</script>
					
					<?php } } ?>
					
						<div class="tituloEditar">
							<label class="lblTituloLivro tituloPagina"><?php echo $dadosLit['titulo']; ?></label>
							<?php if ($meuUsuario == true) { ?>
								<div class="dropdown">
									<button class="btnOpcoes" id="idBtnOpcoes" onclick="openDropdownOpcoes()"><?php include('icones/Opcoes.svg'); ?></button>
									<div class="dropdownOpcoes" id="idDropdownOpcoes">
										<button type="button" class="btnOpcao" onclick="window.location='editarLivro.php?i=<?php echo $idLitSha1; ?>'"><?php include('icones/Editar.svg'); ?>Editar</button>
										<form name="frmAlterarCapa" id="frmAlterarCapaId" action="BDalterarCapa.php?i=<?php echo $idLitSha1; ?>" method="post" enctype="multipart/form-data">
											<input type="hidden" name="tokenFrmAltCap" value="<?php echo $_SESSION['TSFAltCapa']; ?>" >
											<div class="btnAlterarCapa">
												<label type="file" class="btnOpcao" for="arquivoFotoCapaId"><?php include('icones/Replace.svg'); ?>Alterar Capa</button>
												<input type="file" id="arquivoFotoCapaId" name="alterCapa" onchange="enviarFormularioCapa()" accept="image/jpeg, image/jpg, image/png">
											</div>
											<?php if ($haCapa == true){ ?><button type="button" class="btnOpcao" onclick="openPopupExcluirImgCapaConfirmacao()"><?php include('icones/Remover.svg'); ?>Remover Capa</button><?php } ?>
										</form>
										<button type="button" class="btnOpcao" onclick="window.location='excluirLiteratura.php?i=<?php echo $idLitSha1; ?>'"><?php include('icones/Remover.svg'); ?>Excluir Literatura</button>
									</div>
								</div>
							<?php } ?>
						</div>
						<label title="Ver perfil" class="lblAutorLivro texto" onclick="window.location.href='perfil.php?i=<?php echo sha1($dadosLit['idUsuario']); ?>';">Postado por: <span class="foto-nome"><img class="fotoPerfilDescricao" src="<?php echo $urlFotoPerfilDescricao; ?>"> <?php echo $dadosLit['nomeUsuario']; ?></span></label>
						<?php if (!$meuUsuario){ ?><button id="btnSeguir" onclick="inscreverSeAjax()"<?php if ($estaSeguindo){?> class="btnDeixarDeSeguir">Deixar de seguir<?php }else{?> class="btnSeguir">Seguir<?php } ?></button><?php } ?>
						<div class="divCategorias">
							<?php while($dadosItemCat=mysqli_fetch_array($queryItemCat)){ ?>
							<a href="busca.php?icat=<?php echo sha1($dadosItemCat['idCategoria']); ?>"><div class="lblNomeCategoria"><?php echo $dadosItemCat['nomeCategoria']; ?></div></a>
							<?php } echo $txtSemCat;?>
						</div>
						<label class="dataLancamento texto">Data de lançamento: <?php echo (new DateTime($dadosLit['dataLanc']))->format('d/m/Y H:i'); ?></label>
						<label class="dataEdicao texto">Última edição: <?php echo (new DateTime($dadosLit['dataEdit']))->format('d/m/Y H:i'); ?></label>
						<label class="lblDescricaoLivro texto"><?php echo $dadosLit['descricao']; ?></label>
						<label id="lblQtdePagsId">Quantidade de páginas: Carregando...</label><label class="lblViews">Visualizações: <?php echo $dadosLit['views']; ?></label>
					</div>
					<div class="botoesLivro">
						<button class="botao azul" onclick="window.location.href='leitor.php?i=<?php echo $idLitSha1; ?>'" name="ContinuarLeitura" id="ContinuarLeituraId"><?php include_once('icones/Livro.svg'); ?>Ler</button>
						
						<form action="BDfavoritos.php?i=<?php echo $idLitSha1; ?>" method="post">
							<button name="sbmtCurtitLit" type="submit" class="btnFavorito" name="Favorito" id="FavoritoId">
							<input type="hidden" name="tokenFrmFavoritar" value="<?php echo $_SESSION['TSFFavoritar']; ?>" >
							<?php include('icones/Favorito.svg'); ?><span>Favoritar</span></button>
						</form>
					</div>
					<div class="avaliacao">
						<form method="post" action="BDlike.php">
							<input type="hidden" name="tokenFrmLd" value="<?php echo $_SESSION['TSFLd']; ?>" >
							<div class="metricaAvaliacaoExterna" id="metricaAvaliacaoExternaId">
							<div class="metricaAvaliacaoInterna" id="metricaAvaliacaoInternaId"></div>
							</div>
							<div class="botoesAvaliacao">
								<button name="sbmtLike" type="submit" class="btnCurtir" id="likeId" title="Curtir"><img id="idImgCurtir" src="icones/Gostei.svg"><label id="lblLikeId">?</label></button>
								<button name="sbmtDeslike" type="submit" class="btnNaoCurtir" title="Não curtir"><img id="idImgNaoCurtir" src="icones/NaoGostei.svg"><label id="lblDeslikeId">?</label></button>
							</div>
						</form>
					</div>
				</div>	
			</div>
				<div class="divCapitulos">
					<div class="headerCaps">
						<label class="lblCapsTituloHeader">Capítulos</label>
					</div> <!--headerCaps-->
					<div class="divCapCorpo">
						<?php while($dadosCapLit=mysqli_fetch_array($queryCapLit)){ ?>
						<a class="nomeCapLink" href="leitor.php?i=<?php echo sha1($dadosCapLit['idLit']) . "&cap=" . $dadosCapLit['numCapitulo']; ?>">
							<div class="capitulo">
								<label class="nomeCap texto"><?php echo $dadosCapLit['nomeCapitulo']; ?></label>
							</div>
						</a>
						<?php } ?>
					</div><!--divCapCorpo-->
				</div> <!--divCapitulos-->
				<?php include_once('comentarios.php'); ?>
		</main>
		
		<?php include('footer.php');?>
	</body>
</html>

<?php if ($logado == 1) { ?>
<script>

    const FavoritoId = document.getElementById('FavoritoId');
	var estiloBtnFavoritar = <?php echo $estiloBtnFavoritar; ?>;
	

        const spanElement = FavoritoId.querySelector('span');

        if (estiloBtnFavoritar == 1) {
            spanElement.innerHTML = 'Favoritado';
            FavoritoId.classList.remove("btnFavorito");
            FavoritoId.classList.add("btnFavoritado");
        } else {
            spanElement.innerHTML = 'Favoritar';
            FavoritoId.classList.remove("btnFavoritado");
            FavoritoId.classList.add("btnFavorito");
        }

</script>
<?php } ?>

<?php if ($meuUsuario == false) { ?>
<script>
//Função para ajax do botão de Insecrever-se

function inscreverSeAjax() {
	<?php if ($logado == 1) { ?>
	document.getElementById('btnSeguir').textContent = '...';
		var xhr = new XMLHttpRequest();

		// Configura a requisição
		xhr.open("GET", "ajax/ajaxBDInscreverSe.php?i=<?php echo sha1($dadosLit['idUsuario']); ?>", true);
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
				{alert("você não pode seguir o seu própio perfil!");}
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
		<?php } else{ ?>
		
		window.location.href = "login";
		
		<?php } ?>
}

</script>

<?php } /*Meu usuário == false*/ else { ?>

<script>
    function enviarFormularioCapa() {
        // Obtém o formulário pelo ID
        var formulario = document.getElementById('frmAlterarCapaId');
		var inputArquivoPerfil = document.getElementById('arquivoFotoCapaId');
		var tamanhoMaximoNome = 41;
		// Verificar o campo de capa
            if (inputArquivoPerfil.files[0]) {
                var nomeArquivoPerfil = inputArquivoPerfil.files[0].name;
                // Verificar o tamanho do nome
                if (nomeArquivoPerfil.length > tamanhoMaximoNome) {
                    alert('O nome do arquivo da foto da capa é muito grande. Por favor, escolha um nome de arquivo mais curto. (Máximo de 41 caracteres)');
					window.location.reload();
				}
				else
				{
					// Envia o formulário
					openPopupAtualizaImgCapa();
					formulario.submit();
				}
					
            }
		
    }
</script>

<script>
	function openPopupAtualizaImgCapa() {
		var containerImgCapa= document.getElementById('popup-containerImgCapa');
		containerImgCapa.style.display = 'flex';
	}
	function openPopupExcluirImgCapaConfirmacao() {
		var containerExcluirImgCapa = document.getElementById('popup-containerExcluirImgCapaCofirmacao');
		containerExcluirImgCapa.style.display = 'flex';
	}
	function openPopupExcluindoImgCapa() {
		var containerExcluirImgCapa = document.getElementById('popup-containerExcluindoImgCapa');
		containerExcluirImgCapa.style.display = 'flex';
	}
</script>

<script>
	var idDropdownOpcoes = document.getElementById("idDropdownOpcoes");

	function openDropdownOpcoes() {
		idDropdownOpcoes.style.display = 'flex';
	}
	
	function closeDropdownOpcoes() {
		idDropdownOpcoes.style.display = 'none';
	}
	
	document.addEventListener('mousedown', (event) => {
		if (!idDropdownOpcoes.contains(event.target)) {
			closeDropdownOpcoes();
		}
	})
	
</script>

<?php } ?>

<script src="/bibliotecas/build/pdf.js"></script>

<script>
	const pdfFileURL = "<?php echo $dirPdf . $dadosLit['urlPdf']; ?>";
	pdfjsLib.getDocument(pdfFileURL).promise.then(function (pdfDoc) {
		const numPages = pdfDoc.numPages;
		document.getElementById('lblQtdePagsId').innerHTML = document.getElementById('lblQtdePagsId').innerHTML.slice(0, -13);
		document.getElementById('lblQtdePagsId').innerHTML += numPages;
	}).catch(function (error) {
		console.error('Erro: ', error);
		//alert('Erro ao carregar documento PDF.');
	});
</script>

<?php
	} //verifica se está privada
	else
	{ ?>
		<h2>Essa literaura é privada ou está bloqueada.</h2>
		<button onclick="location.href='index.php'">Voltar à página inicial</button>
		<?php include('footer.php');?>
		<?
	}
?>