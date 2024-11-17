<?php include_once('forcaRota.php'); ?>

<html language="pt-br">

    <head>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Arimo">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Armata">
		<title>Editar obra|JustBookin</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="Balacowork/Balacowork.css">
		<?php include_once("b.php");?>
    </head>

<?php include_once("Styles/editarLivro.css");?>
<?php include_once("Styles/fonte.css");?>

    <body>
	<div id="loader" style="padding: 20px;"><h3>Por favor, aguarde...<h3></div>
<div id="divConteudoId" style="display: none;">
		<?php include_once("header.php");?>
		<main class="conteudo">
		
		<!--popup de carregamento-->
		<div class="popup-containerChamadoPorBotao" id="popup-containerCarregamento">
			<div class="popupChamadoPorBotao">
				<div class="cabecalhoPopup"><h2 class="h2CarregandoImgPerfil">Aguarde...</h2><img class="gifCarregandoImgPerfil" src="imagens/loading4.gif"></div>
				<p>Não feche essa janela enquanto atualizamos sua literatura!</p>
			</div>
		</div>
		
			<label class="tituloPagina tituloEditarLivro">EDITAR OBRA</label>
			<a class="texto linkVoltarLivro" href="javascript:history.back()"><img style="height: 25px" src="./icones/Seta_Voltar.svg">Voltar à página do livro</a>
			<form id="frmEditarLitId" class="form" action="BDeditarLiteratura.php?i=<?php echo $idLiSha1; ?>" method="post">
				<input type="hidden" name="tokenFrmeditLit" value="<?php echo $_SESSION['TSFEditLit']; ?>">
				<!--Poupop já havia capítulos-->
				<div id="popup-container">
					<div id="popup">
						<h2>Excluir capítulos?</h2>
						<p>Você tem <?php echo $qtdeCaps; ?> capítulos salvos cadastrados nesta literatura. Ao selecionar que seu livro <b>não</b> possui subdivisões, todos eles serão excluidos.</p>
						<button type="submit" onclick="abrirPopupCarregamento()" name="btnPublicarSemCapitulos" class="btnSalvarPoupop">Ok</button>
						<input type="button" onclick="fecharPopup()" value="Cancelar" class="btnOkPopUp">
					</div>
				</div>
				<!--|-->
				
				<label class="texto passoseditarLivro">1. Título do livro:</label>
				<br>
				<input type="text" class="txtTituloLivro" name="tituloLivroName" rows="1" value="<?php echo $dadosLit['titulo']; ?>" required>
				<br><br>
				<label class="texto passoseditarLivro">2. Descrição:</label>
				<br>
				<textarea class="txtDescricao" name="descricaoLivroName" rows="5" required><?php echo $dadosLit['descricao']; ?></textarea>
				<br><br>
				<label class="texto passoseditarLivro">3. Gêneros:</label>
				<br>
				<!---->
				<div class="divCat">
					<div class="checkboxCat">
						<?php foreach ($dadosCategoria as $categoria) { ?>
							<input type="checkbox" name="checkboxCat[]" id="<?php echo $categoria['idCatCripto']; ?>" value="<?php echo $categoria['idCatCripto']; ?>" <?php if($categoria['isChecked']) echo "checked"; ?>>
							<label for="<?php echo $categoria['idCatCripto']; ?>"><?php echo $categoria['nomeCategoria']; ?></label>
						<?php } ?>
					</div>
				</div>
				<!---->
				<br>
				<label class="texto passoseditarLivro" id="labelLivro">5. O seu livro possui <span id="spanQtdPaginasId">...</span> <span id="spanTxtCapitulosPluralId">...</span>. Ele é dividido em capítulos?</label>
				<br>
                <br>
				<div class="radioBtn">
					<input id="radio1" type="radio" name="opcao" value="Sim" onclick="haCapitulosFunc('sim')">
					<label class="texto respostaRadio" for="radio1">Sim, meu livro está dividido em subdivisões</label>
				</div>
				<br>
				<div class="radioBtn">
					<input id="radio2" type="radio" name="opcao" value="Não" onclick="haCapitulosFunc('nao')">
					<label class="texto respostaRadio" for="radio2">Não, meu livro não possui subdivisões</label>
				</div>
				<br>
				<div class="seletorCapitulos" id="seletorCapitulosId">
					<label class="texto passoseditarLivro">6. <span id="spanTxtSeletorCapitulosId"></span> informe qual a quantidade de capítulos/subdivisões que o seu livro tem, o nome deles e em qual página se iniciam:</label>
					<br>
					<!--<input type="number"  value="">-->
					<div class="hEditCap">
						<label for="quantidade">Quantidade de Capítulos:</label>
						<input type="number" id="quantidade" name="quantidade" min="1" readonly>
						<button type="button" id="adicionar-capitulo">Adicionar Capítulo</button>
						<button type="button" id="remover-capitulo">Remover Capítulo</button>
					</div>
					<div class="editorCapitulos texto">
						<div class="capitulos" id="capitulos-container"></div>
						<br>
					</div> <!--editor de capítulos-->
					
					<button class="btnPublicar" type="submit" name="btnPublicarHaCapitulos"><?php include('icones/Publicar.svg'); ?>Salvar alterações</input>
				</div>
				
				<label class="texto passoseditarLivro" >7. Selecione a classificação indicativa</label>
				<select id="classifIndicId" name="classifIndic">
				<?php foreach ($dadosClassif as $classif) { ?>
					<option value="<? echo $classif['idClassificacao']; ?>"<? if($classif['idClassificacao'] == $dadosLit['idClassificacao']) echo 'selected'; ?>><? echo $classif['idade']; ?></option>
				<? } ?>
				</select>
				<br>
				<label class="texto passoseditarLivro" id="labelLivro">8. Selecione a visibilidade</label>
				<br>
				<label>Pública: Qualquer um pode acessar de qualquer lugar do site.</label>
				<br>
				<label>Privada: Somente você poderá acessar a sua literatura. Ela também não aparecerá para outros usuários.</label>
				<br>
				
				<select id="sctAlterarVisibilidadeId" name="sctAlterarVisibilidade">
				<option value="0">Pública</option>
				<option value="1">Privada</option>
				</select>
				
				<input type="hidden" name="hiddenPublicarSemCapitulos" id="hiddenPublicarSemCapitulos" value="">
				<div class="btnsPub">
					<input class="botao secundario" type="button" onclick="window.location='livro.php?i=<?php echo $idLiSha1; ?>'" value="Cancelar">
					<?php if ($qtdeCaps > 0){ ?>
						<button class="btnPublicar" type="button" onclick="abrirPopup()" id="btnPublicarSemCapitulosId" style="display: none;"><?php include('icones/Publicar.svg'); ?>Salvar alterações</button>
					<?php }else{?>
						<button type="submit" onclick="abrirPopupCarregamento()" class="btnPublicar" name="btnPublicarSemCapitulos" type="button" id="btnPublicarSemCapitulosId" style="display: none;"><?php include('icones/Publicar.svg'); ?>Salvar alterações</button>
					<?php } ?>
				</div>
			</form>
		</main>
		<div class="clearfix"></div>
		<?php include_once("footer.php");?>
		</div><!--Div conteúdo-->
	</body>

</html>

<script>
        function selecionarOpcao(index) {
            var select = document.getElementById('sctAlterarVisibilidadeId');
            select.selectedIndex = index;
        }
		selecionarOpcao(<?php echo $dadosLit['status']; ?>)
    </script>

<script src="/bibliotecas/build/pdf.js"></script>

<script>
 
	const pdfFileURL = "<?php echo $dirPdf . $dadosLit['urlPdf']; ?>";
	
	pdfjsLib.getDocument(pdfFileURL).promise.then(function (pdfDoc) {
		const numPages = pdfDoc.numPages;
		document.getElementById('spanQtdPaginasId').textContent = numPages;
		/**/
		var txtCapitulosPlural = "páginas";
		if (numPages == 1)
		{txtCapitulosPlural = "página";}
		else if (numPages > 1)
		{
			document.getElementById('spanTxtSeletorCapitulosId').textContent = "Dentre as " + numPages + " páginas do seu PDF, ";
		}
		document.getElementById('spanTxtCapitulosPluralId').textContent = txtCapitulosPlural;
		/**/
		
		document.getElementById('loader').style.display = 'none';
		document.getElementById('divConteudoId').style.display = 'block';
		carregarVisualizadorCaps(numPages);
		
		/**/
	}).catch(function (error) {
		document.getElementById('divConteudoId').style.display = 'none';
		document.getElementById('loader').style.display = 'none';
		console.error('Erro: ', error);
		alert('Erro ao carregar documento PDF, verifique sua conexão com a Internet.')
		window.location.href="livro.php?i=<?php echo $idLiSha1; ?>";
	});
	
</script>

<script>

function carregarVisualizadorCaps(quantidadePaginas)
{
	var adicionarCapituloButton = document.getElementById('adicionar-capitulo');
	var removerCapituloButton = document.getElementById('remover-capitulo');
	var quantidadeInput = document.getElementById('quantidade');
	var capitulosContainer = document.getElementById('capitulos-container');
	var capituloData = []; // Array para armazenar os dados dos capítulos

	// Função para adicionar um capítulo
	function adicionarCapitulo() {
	  var quantidade = capituloData.length + 1;

	  // Cria os campos de entrada para o novo capítulo
	  var inputLabel = document.createElement('label');
	  inputLabel.textContent = 'Capítulo ' + quantidade + ' - Nome: ';
	  inputLabel.classList.add('lblIn');

	  var inputField = document.createElement('input');
	  inputField.setAttribute('type', 'text');
	  inputField.setAttribute('name', 'capitulo[]');
	  inputField.classList.add('txtNomeCapitulo');
	  inputField.setAttribute('value', 'Capítulo ' + quantidade);
	  inputField.setAttribute('required', 'required');

	  var paginaLabel = document.createElement('label');
	  paginaLabel.textContent = 'Página Inicial:';
	  paginaLabel.classList.add('lblPag');
	  
	  var paginaField = document.createElement('input');
	  paginaField.setAttribute('type', 'number');
	  paginaField.setAttribute('name', 'pagina[]');
	  paginaField.setAttribute('min', '1');
	  paginaField.setAttribute('max', quantidadePaginas);
	  paginaField.classList.add('txtPaginaCapitulo');
	  paginaField.setAttribute('required', 'required');

	  var novoItem = document.createElement('hr');
		novoItem.classList.add('linhaCap');
		
	  // Adiciona o event listener para validar o valor inserido
	  paginaField.addEventListener('input', function() {
		var value = parseInt(paginaField.value);
		if (isNaN(value) || value < 1) {
		  paginaField.value = '1';
		} else if (value > quantidadePaginas) {
		  paginaField.value = quantidadePaginas.toString();
		}
	  });

	  // Adiciona o event listener para detectar o "Backspace" e limpar o campo se o valor for "1"
	  paginaField.addEventListener('keyup', function(event) {
		var value = paginaField.value;

		if (event.keyCode === 8 && value === "1") {
		  setTimeout(function() {
			paginaField.value = "";
		  }, 0);
		}
	  });

	  capitulosContainer.appendChild(inputLabel);
	  capitulosContainer.appendChild(inputField);
	  capitulosContainer.appendChild(document.createElement('br'));
	  capitulosContainer.appendChild(paginaLabel);
	  capitulosContainer.appendChild(paginaField);
	  capitulosContainer.appendChild(document.createElement('br'));
	  capitulosContainer.appendChild(novoItem); // Adiciona a linha horizontal
	  
	  capituloData.push({
		nome: inputField.value,
		paginaInicial: paginaField.value
	  }); // Armazena os dados do capítulo atual
	  
	  quantidadeInput.value = quantidade; // Atualiza o campo de quantidade
	}
	
	// Adicionar o capítulo inicial ao carregar a página
	<?php if ($qtdeCaps < 1)
	{ ?>
		adicionarCapitulo();
	<? } ?>

	adicionarCapituloButton.addEventListener('click', adicionarCapitulo);

	removerCapituloButton.addEventListener('click', function() {
	  if (capituloData.length > 1) {
		capitulosContainer.removeChild(capitulosContainer.lastChild); // Remove a linha horizontal
		capitulosContainer.removeChild(capitulosContainer.lastChild); // Remove a quebra de linha
		capitulosContainer.removeChild(capitulosContainer.lastChild); // Remove o campo de entrada de página
		capitulosContainer.removeChild(capitulosContainer.lastChild); // Remove o label de página
		capitulosContainer.removeChild(capitulosContainer.lastChild); // Remove a quebra de linha
		capitulosContainer.removeChild(capitulosContainer.lastChild); // Remove o campo de entrada de capítulo
		capitulosContainer.removeChild(capitulosContainer.lastChild); // Remove o label de capítulo

		capituloData.pop(); // Remove o último capítulo do array

		var quantidade = capituloData.length;
		quantidadeInput.value = quantidade; // Atualiza o campo de quantidade
	  }
	});
	/***/
	/*var enviarButton = document.getElementById('enviar');
	enviarButton.addEventListener('click', function() {
	  var formData = new FormData();

	  for (var i = 0; i < capituloData.length; i++) {
		formData.append('capitulo[]', capituloData[i].nome);
		formData.append('pagina[]', capituloData[i].paginaInicial);
	  }

	  console.log(capituloData); // Exibe o array de capítulos no console para depurar
	}); */
	/***/

function carregaCapitulosBanco(nomeCap, paginaCap) {
		
	  var quantidade = capituloData.length + 1;

	  // Cria os campos de entrada para o novo capítulo
	  var inputLabel = document.createElement('label');
	  inputLabel.textContent = 'Capítulo ' + quantidade + ' - Nome: ';
	  inputLabel.classList.add('lblIn');

	  var inputField = document.createElement('input');
	  inputField.setAttribute('type', 'text');
	  inputField.setAttribute('name', 'capitulo[]');
	  inputField.classList.add('txtNomeCapitulo');
	  inputField.setAttribute('value', nomeCap);
	  inputField.setAttribute('required', 'required');

	  var paginaLabel = document.createElement('label');
	  paginaLabel.textContent = 'Página Inicial:';
	  paginaLabel.classList.add('lblPag');
	  
	  var paginaField = document.createElement('input');
	  paginaField.setAttribute('type', 'number');
	  paginaField.setAttribute('name', 'pagina[]');
	  paginaField.setAttribute('min', '1');
	  paginaField.setAttribute('max', quantidadePaginas);
	  paginaField.classList.add('txtPaginaCapitulo');
	  paginaField.setAttribute('value', paginaCap);
	  paginaField.setAttribute('required', 'required');

	  var novoItem = document.createElement('hr');
		novoItem.classList.add('linhaCap');
		
	  // Adiciona o event listener para validar o valor inserido
	  paginaField.addEventListener('input', function() {
		var value = parseInt(paginaField.value);
		if (isNaN(value) || value < 1) {
		  paginaField.value = '1';
		} else if (value > quantidadePaginas) {
		  paginaField.value = quantidadePaginas.toString();
		}
	  });

	  // Adiciona o event listener para detectar o "Backspace" e limpar o campo se o valor for "1"
	  paginaField.addEventListener('keyup', function(event) {
		var value = paginaField.value;

		if (event.keyCode === 8 && value === "1") {
		  setTimeout(function() {
			paginaField.value = "";
		  }, 0);
		}
	  });

	  capitulosContainer.appendChild(inputLabel);
	  capitulosContainer.appendChild(inputField);
	  capitulosContainer.appendChild(document.createElement('br'));
	  capitulosContainer.appendChild(paginaLabel);
	  capitulosContainer.appendChild(paginaField);
	  capitulosContainer.appendChild(document.createElement('br'));
	  capitulosContainer.appendChild(novoItem); // Adiciona a linha horizontal

	  capituloData.push({
		nome: inputField.value,
		paginaInicial: paginaField.value
	  }); // Armazena os dados do capítulo atual

	  quantidadeInput.value = quantidade; // Atualiza o campo de quantidade
	}
	<?php if ($qtdeCaps > 0){

	foreach ($dadosCaps as $capitulo) { ?>

	carregaCapitulosBanco("<?php echo $capitulo['nomeCapitulo']; ?>", <?php echo $capitulo['paginaInicial']; ?>);

	<?php } } ?>

	} //carregarVisualizadorCaps

</script>

<script language="Javascript">

    var qtdCapitulos = document.getElementById("quantidade").value;
    
    function addCapitulo ()
    {
        qtdCapitulos++;
        quantidade.value = qtdCapitulos;
    }

    function valorMenorUm ()
    {

        if (qtdCapitulos < 1)
        {
            quantidade.value = 1;
        }
    }
	
    function haCapitulosFunc(haCapitulos)
	{
		var seletorCapitulosDiv = document.getElementById('seletorCapitulosId');
		var btnPublicarSemCapitulos = document.getElementById('btnPublicarSemCapitulosId');
		var campos = seletorCapitulosDiv.getElementsByTagName('input'); // Substitua 'input' pelo tipo de campo que você deseja desabilitar

		if (haCapitulos === "sim") {
			btnPublicarSemCapitulos.style.display = 'none';
			seletorCapitulosDiv.style.display = 'block';

			for (var i = 0; i < campos.length; i++) {
				campos[i].disabled = false;
			}
		} else if (haCapitulos === "nao") {
			seletorCapitulosDiv.style.display = 'none';
			btnPublicarSemCapitulos.style.display = 'flex';

			for (var i = 0; i < campos.length; i++) {
				campos[i].disabled = true;
			}
		}
	}

</script>
	
<script language="Javascript">

if (<?php echo $qtdeCaps; ?> > 0) {
        document.getElementById('radio1').checked = true;
        document.getElementById('radio2').checked = false;
		haCapitulosFunc('sim');
}
else{
	document.getElementById('radio1').checked = false;
    document.getElementById('radio2').checked = true;
	haCapitulosFunc('nao');
}

</script>

<script>
	function enviaFormSemCaps() {
		if (<?php echo $qtdeCaps; ?> > 0) {
			var confirmacao = confirm('Você tinha capítulos atrelados à sua literatura.\nAo selecionar a opção "Não, meu livro não possui subdivisões", todos os capítulos desta literatura serão excluídos permanentemente!');
			if (confirmacao) {
				document.getElementById("hiddenPublicarSemCapitulos").value = "btnPublicarSemCapitulos";
				document.getElementById("frmEditarLitId").submit();
			}
		}
		else{
			document.getElementById("frmEditarLitId").submit();
		}
	}
	
	function fecharPopup() {
            var popupContainer = document.getElementById("popup-container");
            popupContainer.style.display = "none";
        }
	function abrirPopup()
	{
		var popupContainer = document.getElementById("popup-container");
		popupContainer.style.display = "flex";
	}
	function abrirPopupCarregamento()
	{
		var popupContainer = document.getElementById("popup-containerCarregamento");
		popupContainer.style.display = "flex";
		/*O bloco de código abaixo é para previnir bugs*/
		var seletorCapitulosDiv = document.getElementById('seletorCapitulosId');
		var btnPublicarSemCapitulos = document.getElementById('btnPublicarSemCapitulosId');
		var campos = seletorCapitulosDiv.getElementsByTagName('input');
		btnPublicarSemCapitulos.style.display = 'none';
		seletorCapitulosDiv.style.display = 'block';
		for (var i = 0; i < campos.length; i++) {
			campos[i].disabled = false;
			campos[i].removeAttribute('required');
		}
		/*Fim de*/
	}
	
    </script>