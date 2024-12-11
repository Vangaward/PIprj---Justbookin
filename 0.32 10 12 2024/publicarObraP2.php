<?php include_once('forcaRota.php'); ?>

<html>
    <head>
		<title>Novo Livro|JustBookin</title>
		<?php include_once("detalhesHead.php");?>
		<link rel="stylesheet" href="Balacowork/Balacowork.css">
		<?php include_once("Styles/publicarObraP2.css");?>
		<?php include_once("Styles/fonte.css");?>
    </head>
    <body>
		<?php include_once("header.php");?>
		<main class="conteudo">
			<label class="tituloPagina tituloPublicarObra">PUBLICAR OBRA</label>
			<a class="texto linkVoltarPublicarObraP1" href="publicarObraP1.php"><img style="height: 25px" src="./icones/Seta_Voltar.svg">Voltar à seleção de conteúdo</a>
			<form class="formP2" action="BDpublicarObraP2.php" method="post" enctype="multipart/form-data">
				<?php if (isset($nomeArquivoCapa)){ ?>
					<input type="hidden" name="nomeArquivoCapa" value="<?php echo $nomeArquivoCapa; ?>">
					<input type="hidden" name="dadosArquivoCapa" value="<?php echo base64_encode($dadosArquivoCapa); ?>">
				<?php } ?>
					<input type="hidden" name="nomeArquivoPDF" value="<?php echo $nomeArquivoPDF; ?>">
					<input type="hidden" name="dadosArquivoPDF" value="<?php echo base64_encode($dadosArquivoPDF); ?>">
				
				<input type="hidden" name="tokenFrmPublicaLitP2" value="<?php echo $_SESSION['TSFPublicaLitP2']; ?>">
				<div class="passo">
					<label class="texto passosPublicarObra">3. Título do livro:</label>
					<div class="txtbox">
						<textarea class="txtTituloLivro" id="txtTituloId" name="tituloLivroName" oninput="qtdeCaracsTitulo(100)" rows="1" maxlength="100" required></textarea>
						<label class="limiteCarac" id="lblQtdeCaracTituloID" ></label>
					</div>
				</div>
				<div class="passo">
					<label class="texto passosPublicarObra">4. Descrição:</label>
					<div class="txtbox">
						<textarea class="txtDescricao" name="descricaoLivroName" oninput="qtdeCaracsDescricao(300)" id="txtDescricaoId"rows="5" maxlength="300" required></textarea>
						<label class="limiteCarac" id="lblQtdeCaracDescricaoID"></label>
					</div>
				</div>
				<div class="passo">
					<label class="texto passosPublicarObra">5. Gêneros:</label>
					<div class="divCat">
						<div class="checkboxCat">
							<?php foreach ($dadosCats as $categorias) { ?>
								<input type="checkbox" name="checkboxCat[]" id="<?php echo $categorias['idCategoria']; ?>" value="<?php echo sha1($categorias['idCategoria']); ?>">
								<label for="<?php echo $categorias['idCategoria']; ?>"><?php echo $categorias['nomeCategoria']; ?></label>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="passo">
					<label class="texto passosPublicarObra" >6. Selecione a classificação indicativa</label>
					<select id="classifIndicId" name="classifIndic">
						<?php foreach ($dadosClassif as $classif) { ?>
							<option value="<? echo $classif['idClassificacao']; ?>"><? echo $classif['idade']; ?></option>
						<? } ?>
					</select>
				</div>
				<div class="passo">
					<label class="texto passosPublicarObra">7. O seu livro possui <?php echo $qtdPaginas . " " . $txtCapitulosPlural;?>. Ele é dividido em capítulos?</label>
					<div>
						<div class="radioBtn">
							<input id="radio1" type="radio" name="opcao" value="Sim" onclick="haCapitulosFunc('sim')">
							<label class="texto respostaRadio" for="radio1">Sim, meu livro está dividido em subdivisões</label>
						</div>
						<br>
						<div class="radioBtn">
							<input id="radio2" type="radio" name="opcao" value="Não" onclick="haCapitulosFunc('nao')">
							<label class="texto respostaRadio" for="radio2">Não, meu livro não possui subdivisões</label>
						</div>
					</div>
					<div class="passo seletorCapitulos" id="seletorCapitulosId">
						<label class="texto passosPublicarObra">8. <?php echo $txtseletorCapitulos; ?> informe qual a quantidade de capítulos/subdivisões que o seu livro tem, o nome deles e em qual página se iniciam:</label>
						<!--<input type="number"  value="">-->
						<div class="listaCap">
							<div class="hEditCap">
								<label for="quantidade">Quantidade de Capítulos:</label>
								<input type="number" id="quantidade" name="quantidade" min="1" readonly>
								<button type="button" id="adicionar-capitulo">Adicionar Capítulo</button>
								<button type="button" id="remover-capitulo">Remover Capítulo</button>
							</div>
							<div class="editorCapitulos texto">
								<div class="capitulos" id="capitulos-container" id="capitulosContainerId"></div>
							</div> <!--editor de capítulos-->
						</div>
						<button class="btnPublicar" type="submit" name="btnPublicarHaCapitulos"><?php include('icones/Publicar.svg'); ?>Publicar</input>
					</div>
				</div>
				<button class="btnPublicar" type="submit" name="btnPublicarSemCapitulos" id="btnPublicarSemCapitulosId" style="display: none;"><?php include('icones/Publicar.svg'); ?>Publicar</input>
			</form>
		</main>
		<div class="clearfix"></div>
		<?php include_once("footer.php");?>
	</body>

</html>
<script><?php include_once('js/publicarObraP2.js'); ?></script>