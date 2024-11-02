<a href="../livro.php?i=<?php echo $idLitCard; ?>">
<div class="divDivisor">
				<div class="cardLivro">
					<img class="imgCard" src="<?php echo $img; ?>">
					<div class="overlay" style="background-image: url(<?php echo $img; ?>)"></div>
					<label class="tituloCard">
						<?php echo $titulo; ?>
						<br>
						<?php echo 'Postado por: ' . $nomeUser; ?>
					</label>
				</div>
			</a>
		</div> <!--divDivisor-->