<?php

if ($dadosLit['status'] > 0)
{
	?>
		<h4>Sua literatura está privada ou bloqueada, não é possível visualizar os comentários.</h4>
	<?
}
else
{ ?>
	<div id="divMsgComsSup"></div><!--Essa div é necessária-->
	
	<?php if($msgComentarios != null){ ?>
	<div style="animation-name: Rotacao3d; animation-duration: 1s; animation-delay: 1.2s; " class="alert alert-<?php echo $corErro; ?> shadow"><div class="divErro"><?php echo $msgComentarios; ?></div></div>
	<?php } ?>
	
<div class="sessaoComentarios titulo">
    <div class="headerComents">
        <label class="tituloComents">Comentários (<?php echo $qtdComs; ?>)</label>
        <label><?php if ($qtdComs <= 0) { ?> Ninguém comentou ainda, seja o primeiro! <?php } ?></label>
    </div><!--headerComents-->

    <div class="comentCorpo">
        <?php if ($logado == 1) { ?>
            <form class="comentar" name="enviaComent" action="BDcomentarioLit.php?i=<?php echo $idLitSha1; ?>" method="post">
                <input type="hidden" name="tokenFrmNoCo" value="<?php echo $_SESSION['TSFNovoComent']; ?>">
                <input type="text" class="form-control txtComentario" name="nameTxtComent" id="inptComentId" maxlength="100" oninput="digitaComent();" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1" required>
                <button class="btnEnviar azul" name="submEnviaComent" type="submit"><?php include_once('icones/aviaoPapel.svg'); ?></button>
                <label id="lblQtdCaracteresId"></label>
            </form>
        <?php } else { ?>
            <label>(<a style="text-decoration: none" href="login"><b>Faça login</b></a> para fazer um comentário)</label>
        <?php } ?>

        <?php if ($qtdComs <= 0) { ?>
            <img class="imgSemComents" src="imagens/semComentarios.jpg">
        <?php } ?>

        <div class="comentarios">
            <!-- Comentários do usuário logado -->
            <?php if ($logado == 1 && !empty($dadosComLogado)) {
                 foreach ($dadosComLogado as $comentario) { ?>
                    <div class="comentario">
                        <a style="text-decoration: none" href="perfil.php?i=<?php echo $comentario['idUsuarioCripto']; ?>">
                            <img class="fotoPerfilCometario" src="<?php echo $comentario['caminhoFotoPerfil']; ?>">
                            <div class="corpoComent">
                                <div>
                                    <span class="nomeUsuario"><?php echo $comentario['nomeUsuario']; ?></span>
                                </a>
                                <span class="dataHorario"><?php echo (new DateTime($comentario['dataCom']))->format('d/m/Y H:i'); ?></span>
                                </div>
                                <span class="textoComentario"><?php echo $comentario['txtComentario']; ?></span>
                                <form method="POST" name="likeDeslikComLogado" action="BDLikeComent.php?i=<?php echo sha1($comentario['idComentario']); ?>">
                                    <input type="hidden" name="TokenLikeDeslCom" value="<?php echo $_SESSION['TSFLikeDeslCom']; ?>">
                                    <button class="botaoLike" name="btnLikeComent" type="submit" style="--corSVG: var(--verde); height: 20px"><?php include('icones/GosteiFill.svg'); ?></button><?php echo $comentario['qtdeLikes']; ?>
                                    <button class="botaoLike" name="btnDeslikeComent" type="submit" style="--corSVG: var(--vermelho); height: 20px"><?php include('icones/NaoGosteiFill.svg'); ?></button><?php echo $comentario['qtdeDeslikes']; ?>
                                </form>
                            </div>
                            <form method="post" action="BDexcluirComentario.php?i=<?php echo sha1($comentario['idComentario']); ?>&iu=<?php echo sha1($comentario['idUsuario']); ?>">
                                <input type="hidden" name="tokenFrmExCo" value="<?php echo $_SESSION['TSFExcluiCo']; ?>">
                                <button class="btnExcluir" type="submit" name="excluirCom"><?php include('icones/Excluir.svg'); ?><?php include('icones/Excluir_Hover.svg'); ?></button>
                            </form>
                        </a>
                        <hr>
                    </div> <!--comentario-->
                <?php } ?>
            <?php } ?>

            <!-- Demais comentários -->
            <?php if (!empty($dadosCom)) { ?>
                <?php foreach ($dadosCom as $comentario) { ?>
                    <div class="comentario">
                        <a style="text-decoration: none" href="perfil.php?i=<?php echo $comentario['idUsuarioCripto']; ?>">
                            <img class="fotoPerfilCometario" src="<?php echo $comentario['caminhoFotoPerfil']; ?>">
                            <div class="corpoComent">
                                <div>
                                    <span class="nomeUsuario"><?php echo $comentario['nomeUsuario']; ?></span>
                                </a>
                                <span class="dataHorario"><?php echo (new DateTime($comentario['dataCom']))->format('d/m/Y H:i'); ?></span>
                                </div>
                                <span class="textoComentario"><?php echo $comentario['txtComentario']; ?></span>
                                <?php if ($logado == 1) { ?>
                                    <form method="POST" name="likeDeslikComLogado" action="BDLikeComent.php?i=<?php echo sha1($comentario['idComentario']); ?>">
                                        <input type="hidden" name="TokenLikeDeslCom" value="<?php echo $_SESSION['TSFLikeDeslCom']; ?>">
                                        <button class="botaoLike" name="btnLikeComent" type="submit" style="--corSVG: var(--verde); height: 20px"><?php include('icones/GosteiFill.svg'); ?></button><?php echo $comentario['qtdeLikes']; ?>
                                        <button class="botaoLike" name="btnDeslikeComent" type="submit" style="--corSVG: var(--vermelho); height: 20px"><?php include('icones/NaoGosteiFill.svg'); ?></button><?php echo $comentario['qtdeDeslikes']; ?>
                                    </form>
                                <?php } ?>
                                <hr>
                            </div>
                        </a>
                    </div> <!--comentario-->
                <?php } ?>
            <?php } ?>
        </div> <!--comentarios-->
    </div> <!--comentCorpo-->
</div> <!--sessaoComentarios-->

	<script>
	function digitaComent ()
	{
			var inptComent = document.getElementById('inptComentId').value;
			var carcAtual = inptComent.length;
			var caracRest;
			
			if (carcAtual == 0) {
				caracRest = null;
			}
			else {
				caracRest = 100 - carcAtual + " Caracteres" //caracRest = caracteres restantes)
			};

			document.getElementById('lblQtdCaracteresId').innerHTML = caracRest;
	}
	</script>
	
<?php } ?>