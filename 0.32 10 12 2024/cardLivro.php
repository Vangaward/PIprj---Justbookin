<link rel="stylesheet" href="Styles/card.css">
<div class="divDivisor">
	<a href="/livro.php?i=<?php echo $literatura['idLit']; ?>">
		<div class="cardLivro" <? if($literatura['qdeVerificacoes'] > 0){ ?>style="box-shadow: 0 0 0 2px var(--branco), 0 0 0 4px var(--azul), var(--sombra)"<? } ?>>
			<img class="imgCard" src="<?php echo $literatura['img']; ?>">
			<div class="overlay" style="background-image: url(<?php echo $literatura['img']; ?>)"></div>
			<label class="tituloCard">
				<?php echo $literatura['titulo']; ?>
				<br>
				<?php echo 'Postado por: ' . $literatura['nomeUsuario']; ?>
			</label>
		</div>
		<? if($literatura['qdeVerificacoes'] > 0){ ?>
		<span class="iconeVerificado" style="--corSVG: var(--azul); display: flex; width: 20%"><?php include('icones/LiteraturaVerificada.svg'); ?></span>
		<? } ?>
	</a>
</div> <!--divDivisor-->