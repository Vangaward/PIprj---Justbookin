<a href="livro.php?i=<?php echo $literatura['idLit']; ?>">
<div class="divDivisor">
				<div class="cardLivro">
					<img class="imgCard" src="<?php echo $literatura['img']; ?>">
					<div class="overlay" style="background-image: url(<?php echo $literatura['img']; ?>)"></div>
					<label class="tituloCard">
						<?php echo $literatura['titulo']; ?>
						<br>
						<?php echo 'Postado por: ' . $literatura['nomeUsuario']; ?>
					</label>
				</div>
			</a>
		</div> <!--divDivisor-->