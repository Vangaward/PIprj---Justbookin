<?php include_once('forcaRota.php'); ?>

<!DOCTYPE html>

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
		<main class="conteudo">
		<?php
		if (!$litExiste)
		{?>
			<p>A literatura não foi encontrada, verifique a URL.</p>
		<?
		}
		else if (isset($dadosLit['status']) && $dadosLit['status'] > 0 && $meuUsuario || isset($dadosLit['status']) && $dadosLit['status'] == 0 || isset($dadosLogin['tipoConta']) && $dadosLogin['tipoConta'] == 1 && isset($dadosLit['status']) && $dadosLit['status'] != 1)
		{ ?>
		<script><?php //include_once('js/ajaxLivro.js'); ?></script>
		
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
								<button onclick="fecharPopup()" class="botao verde">OK</button>
							</div>
						</div>
				<?php unset($_SESSION['msgLitEdit']); } ?>
				
				<script>
					
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
		<?php if ($erro != null){ ?>
			<div style="animation-name: Rotacao3d; animation-duration: 1s;" class="alert alert-danger shadow"><div class="divErro"><?php echo $erro; ?></div></div>
		<?php } ?>
			<?php if ($dadosLit['status'] == 1){ ?>
			<label>Essa literatura é privada, somente você pode acessá-la.<br>Para alterar a visibilidade acesse a <a href="editarLivro.php?i=<?php echo $idLitSha1; ?>">página de edição</a>.</label>
			<?php } else if ($dadosLit['status'] == 2){ ?>
			<label>Sua literatura foi bloqueada pois provavelmente contém conteúdo não apropiado.<br>Enquanto estiver bloqueada ela não ficará mais visível para outros usuários no site. Para mais informações entre em contato.</label>
			<?php } ?>
			
			<div class="containerLivro">
				<div class="divCapa"><img class="imgCapa" src="<?php echo $dadosLit['imgCapa']; ?>"></div>
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
					
					<?php } else if ($dadosLogin['tipoConta'] == 2){ ?>
					<button class="botao azul" onclick="verificaLit()"><? if ($qtdeLinhasVerifUsuario > 0){ ?>Remover verificação da literatura<? }else{?>Verificar literatura<? } ?></button>
					<? } } ?>
					
						<div class="tituloEditar">
							<label class="lblTituloLivro tituloPagina"><?php echo $dadosLit['titulo']; ?></label>
							<?php if ($qtdeLinhasVerif > 0) { ?>
								<div>
								<span class="iconeVerificado" style="--corSVG: var(--azul); display: flex; width: 40px; height: 40px"><?php include('icones/LiteraturaVerificada.svg'); ?><span class="setaAbrir" style="display: flex; width: 20%; height: 20%"><?php include('icones/abrir.svg'); ?></span></span>
								<div class="divVerificacoes">
									<span class="tituloDivVerificacoes">Literatura verificada por:</span>
									<? foreach ($dadosVerif as $verificacao) { ?>
										<a style="text-decoration: none; color: var(--cor4Escuro);" href="perfil?i=<? echo $verificacao['idUsuarioCripto']; ?>"><label class="lblVerificacoes"><? echo $verificacao['nomeUsuario'];?></label><label class="lblDataVerificaco"><? echo $verificacao['data']; ?></label></a>
									<? } ?>
								</div>
								</div>
							<? } ?>
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
						<label title="Ver perfil" class="lblAutorLivro texto" onclick="window.location.href='perfil.php?i=<?php echo $dadosLit['idUsuarioSha1']; ?>';">Postado por: <span class="foto-nome"><img class="fotoPerfilDescricao" src="<?php echo $dadosLit['urlFotoPerfil'] ?>"> <?php echo $dadosLit['nomeUsuario']; ?></span></label>
						<?php if (!$meuUsuario){ ?><button id="btnSeguir" onclick="inscreverSeAjax()"<?php if ($estaSeguindo){?> class="btnDeixarDeSeguir">Deixar de seguir<?php }else{?> class="btnSeguir">Seguir<?php } ?></button><?php } ?>
						<div class="divCategorias">
							<?php foreach($dadosItemCat as $categoria){ ?>
							<a style="text-decoration: none" href="busca.php?icat=<?php echo sha1($categoria['idCategoria']); ?>"><div class="lblNomeCategoria"><?php echo $categoria['nomeCategoria']; ?></div></a>
							<?php } echo $txtSemCat;?>
						</div>
						<div class="datas_classificacao">
							<div class="data_lancamento">
								<label class="texto"><b>Lançamento:</b></label>
								<label class="texto"><?php echo $dadosLit['dataLanc']; ?></label>
							</div>
							<div class="data_lancamento">
								<label class="texto"><b>Última edição:</b></label>
								<label class="texto"><?php echo $dadosLit['dataEdit']; ?></label>
							</div>
							<?php include($urlClassif); ?>
						</div>
						<label class="lblDescricaoLivro texto"><?php echo $dadosLit['descricao']; ?></label>
						<hr class="linha">
						<div class="lista">
							<label id="lblQtdePagsId"><b>Quantidade de páginas:</b> Carregando...</label>
							<label><b>Visualizações:</b> <?php echo $dadosLit['views']; ?></label>
							<label><b>Capítulos:</b> <?php echo $qtdeCapsTxt; ?></label>
						</div>
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
								<button name="sbmtLike" type="submit" class="btnCurtir" id="likeId" title="Curtir"><span id="idImgCurtir" style="--corSVG: var(--verde); height: 20px">
								<?php if ($curtido == 1){ include('icones/GosteiFill.svg'); } else if ($curtido != 1){ include('icones/Gostei.svg'); } ?></span><label id="lblLikeId">?</label></button>
								<button name="sbmtDeslike" type="submit" class="btnCurtir" id="likeId" title="Não Curtir"><span id="idImgNaoCurtir" style="--corSVG: var(--vermelho); height: 20px">
								<?php if ($curtido == 0){ include('icones/NaoGosteiFill.svg'); } else if ($curtido != 0){include('icones/NaoGostei.svg');} ?></span><label id="lblDeslikeId">?</label></button>
							</div>
						</form>
					</div>
				</div>	
			</div>
			<? if ($qtdeLinhs > 0) { ?>
			<div class="divCapitulos">
				<div class="headerCaps">
					<label class="lblCapsTituloHeader">Capítulos</label>
				</div> <!--headerCaps-->
				<div class="divCapCorpo">
					<?php foreach($dadosCapLit as $capitulo){ ?>
					<a class="nomeCapLink" href="leitor.php?i=<?php echo sha1($capitulo['idLit']) . "&cap=" . $capitulo['numCapitulo']; ?>">
						<div class="capitulo">
							<label class="nomeCap texto"><?php echo $capitulo['nomeCapitulo']; ?></label>
						</div>
					</a>
					<?php } ?>
				</div><!--divCapCorpo-->
			</div> <!--divCapitulos-->
			<? } ?>
			<?php include_once('comentarios.php'); ?>
		</main>
		
		<?php include('footer.php');?>
	</body>
</html>

<script src="/bibliotecas/build/pdf.js"></script>

<script><?php include_once('js/livro.js'); ?></script>

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