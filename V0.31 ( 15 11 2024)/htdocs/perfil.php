<?php include_once('forcaRota.php'); ?>
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
<?php include_once('header.php');?>
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
	<img class="Banner" src="<?php echo $dadosUsuario['banner']; ?>"> <!--Banner.svg-->
</div>
<div class="usuario">
	<div class="infoUsuario">
		<img class="imgPerfil" src="<?php echo $dadosUsuario['urlFotoPerfil']; ?>" <?php if ($meuUsuario) { ?> onclick="openPopupImgPerfilEdit()" style="cursor: pointer;"<?php } ?>>
		<div class="nomeStats">
			<div class="apelidoNome">
				<label class="apelidoUsuario"><?php echo $dadosUsuario['nomeUsuario']; if ($meuUsuario == true) { ?>(Seu perfil)<?php } ?></label>
				<label class="nomeUsuario"> <?php echo $dadosUsuario['nome'] . " " . $dadosUsuario['sobrenome']; ?></label>
			</div>
			<div style="color: green;"><?php if ($dadosUsuario['tipoConta'] == 2) { include_once('icones/editoraVerificada.svg'); ?> Editora verificada<? } ?></div>
			<div class="statsUser">
				<label class="NumInscritos"><?php echo $qtdeSeguidores; if ($qtdeSeguidores == 1){ ?> Seguidor<?php }else{ ?> Seguidores<?php ;} ?></label>
				<label class="NumObras"><?php echo $qtdlits; if ($qtdlits == 1){ ?> Obra<?php }else{ ?> Obras<?php ;} ?></label>
			</div>
		</div>
	</div>
	<div class="botoesUsuario">
		<?php if ($meuUsuario == false) { ?>
			<button id="btnSeguir" onclick="inscreverSeAjax()"<?php if ($estaSeguindo){?> class="btnDeixarDeSeguir">Deixar de seguir<?php }else{?> class="btnSeguir">Seguir<?php } ?></button>
		<?php } ?>
		<?php if ($meuUsuario){ ?>
			<button class="botao" onclick="location.href='alterarSenha.php'">Alterar Senha</button>
			<button class="botao" onclick="openPopupBannerEdit()">Alterar Banner</button>
		<?php } ?>
	</div>
</div>



<?php if ($txtMsg != null){ ?>
	<div style='animation-name: Rotacao3d; animation-duration: 1s; ' class='alert alert-danger' role='alert' id='idDivMsgPerfil'><center><? echo $txtMsg; ?></center></div>
<? } ?>

<!--Poupop lit publicada com sucesso-->
<?php if (isset($_SESSION['msgLitPubli'])) { if($_SESSION['msgLitPubli'] == true) { ?>
<div id="popup-container">
        <div id="popup">
            <h2>Publicado com sucesso!</h2>
            <p>Sua literatura foi publicada com sucesso</p>
            <button onclick="fecharPopup()" class="botao verde">OK</button>
        </div>
    </div>
	
<?php unset($_SESSION['msgLitPubli']); } } ?>

<!--Poupop lit excluída com sucesso-->
<?php if (isset($_SESSION['msgBDExLit'])) { if($_SESSION['msgBDExLit'] == 2) { ?>
<div id="popup-container">
        <div id="popup">
            <h2>Excluído com sucesso!</h2>
            <p>Sua literatura foi excluída com sucesso</p>
            <button onclick="fecharPopup()" class="botao verde">OK</button>
        </div>
    </div>
	
<?php unset($_SESSION['msgBDExLit']); } } ?>

<?php if ($meuUsuario) { ?>
<!--Form para manipular imagem de perfil-->

<form name="frmFotoPerfil" id="frmFotoPerfilId" method="post" action="BDFotoPerfil.php" enctype="multipart/form-data">
	<input type="hidden" name="tokenFrmAltFotoPerfil" value="<?php echo $_SESSION['TSFAltFotoPerfil']; ?>">
	<!--popup da imagem-->
	<div class="popup-containerChamadoPorBotao" id="popup-containerAtualizandoImgPerfil">
        <div class="popupChamadoPorBotao">
            <div class="cabecalhoPopup"><h2 class="h2CarregandoImgPerfil">Aguarde...</h2><img class="gifCarregandoImgPerfil" src="imagens/loading4.gif"></div>
            <p>Não feche essa janela enquanto atualizamos a sua foto de perfil.</p>
        </div>
    </div>

<!--popup excluir imagem-->
	<div class="popup-containerChamadoPorBotao" id="popup-containerExcluirImgPerfil">
        <div class="popupChamadoPorBotao">
            <h2>Tem certeza de que deseja excluir a sua foto de perfil?</h2>
			<div class="botoes">
				<input class="btnCancelarPopUp" type="button" onclick="fecharPopupExcluirImgPerfil()" value="Cancelar">
				<button type="submit" name="excluFoto" onclick="openPopupAtualizandoImgPerfil()" class="btnExcluirPopUp">Excluir</button>
			</div>
		</div>
    </div>
	<div class="popup-containerChamadoPorBotao" id="popup-containerImgPerfilEdit">
        <div class="popupChamadoPorBotao fotoPerfilEdit">
			<h2>Foto de Perfil</h2>
			<div class="botoes" style="flex-direction: column">
				<label for="arquivoFotoPerfilId" class="botao azul">
				<span><?php if ($dadosUsuario['urlFotoPerfil'] == ""){?>Adicionar<?php }else{ ?>Alterar<?php } ?></span>
				<input style="display: none" type="file" id="arquivoFotoPerfilId" name="arquivoFotoPerfil" onchange="enviarFormularioImgPerfil()" accept="image/*"></label><?php if ($dadosLogin['urlFotoPerfil'] != ""){ ?>
				<button class="botao vermelho" type="button" onclick="openPopupExcluirImgPerfil()">Excluir</button><?php } ?>
				<button class="btnCancelarPopUp" type="button" onclick="fecharPopupImgPerfilEdit()">Cancelar</button>
			</div>
		</div>
	</div>
</form>

<!--Form para manipular banner de perfil-->
	<form name="frmBanner" id="frmBanner" method="post" action="BDalterarBanner.php" enctype="multipart/form-data">
		<input type="hidden" name="tokenFrmAltBanner" value="<?php echo $_SESSION['TSFAltBanner']; ?>">

		<!--popup da imagem-->
	<div class="popup-containerChamadoPorBotao" id="popup-containerAtualizandoBanner">
        <div class="popupChamadoPorBotao">
            <div class="cabecalhoPopup"><h2 class="h2CarregandoImgPerfil">Aguarde...</h2><img class="gifCarregandoImgPerfil" src="imagens/loading4.gif"></div>
            <p>Não feche essa janela enquanto atualizamos o banner do seu perfil.</p>
        </div>
    </div>

<!--popup excluir banner-->
	<div class="popup-containerChamadoPorBotao" id="popup-containerExcluirBanner">
        <div class="popupChamadoPorBotao">
            <h2>Tem certeza de que deseja excluir o banner do seu perfil?</h2>
			<div class="botoes">
				<input class="btnCancelarPopUp" type="button" onclick="fecharPopupExcluirBanner()" value="Cancelar">
				<button type="submit" name="excluBanner" onclick="openPopupAtualizandoBanner()" class="botao vermelho">Excluir</button>
			</div>
		</div>
    </div>
	<div class="popup-containerChamadoPorBotao" id="popup-containerBannerEdit">
        <div class="popupChamadoPorBotao bannerEdit">
			<h2>Banner do Perfil</h2>
			<div class="botoes" style="flex-direction: column">
				<label for="arquivoBannerId" class="btnAlterarPopUp">
				<span><?php if ($dadosUsuario['banner'] == ""){?>Adicionar<?php }else{ ?>Alterar<?php } ?></span>
				<input class="botao azul" type="file" id="arquivoBannerId" name="arquivoBanner" onchange="enviarFormularioBanner()" accept="image/*"></label><?php if ($dadosLogin['urlBanner'] != ""){ ?>
				<button class="botao vermelho" type="button" onclick="openPopupExcluirBanner()">Excluir</button><?php } ?>
				<button class="btnCancelarPopUp" type="button" onclick="fecharPopupImgBanner()">Cancelar</button>
			</div>
		</div>
	</div>
</form>
<?php } ?>

<?php if ($logado == 1){ if ($dadosLogin['tipoConta'] == 1 && $dadosUsuario['tipoConta'] != 1){?><button class="botao azul" onclick="verificaEditora()"><?php if ($dadosUsuario['tipoConta'] == 3) echo "Promover a editora"; else echo "Remover verificação de editora"; ?></button><? } } ?>

<div class="conteudo">
	<div class="containerFlex">
	<label class="lblObras"><?php if ($meuUsuario == true) { ?>SUAS OBRAS:<?php } else { ?> OBRAS DE <?php echo $dadosUsuario['nomeUsuario'] . ":"; } ?></label>
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

	<div class="listaDeCards">

		<?php
		foreach ($dadosLitPerfil as $literatura){ ?>
			<?php include("cardLivro.php"); ?>
		<?php } ?>

	</div><!--row-->

	</div> <!--containerObras-->
</div>
<?php include_once('footer.php'); ?>

</body>

</html>
	
<script language="Javascript">
<?php include_once('js/perfil.js'); ?>
</script>