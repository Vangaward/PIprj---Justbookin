// Função para ajax do botão de like/deslike

function atualizarQtdeLikesAjax() {
    var xhr = new XMLHttpRequest();

    // Configura a requisição
    xhr.open("GET", "../ajax/ajaxLike.php?i=<?php echo $idLitSha1; ?>", true);
	
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
			if (likeDeslike == 1) {
				document.getElementById('idImgCurtir').src = "icones/GosteiFill.svg";
				document.getElementById('idImgNaoCurtir').src = "icones/NaoGostei.svg";
			}
			if (likeDeslike == 0) {
				document.getElementById('idImgNaoCurtir').src = "icones/NaoGosteiFill.svg";
				document.getElementById('idImgCurtir').src = "icones/Gostei.svg";
			}
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
	
	window.onload = function() {
		atualizarQtdeLikesAjax();
		setInterval(atualizarQtdeLikesAjax, 5000); //5s
	};

function fecharPopup()
{
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
//

function selecionarOpcao(index)
{
	var select = document.getElementById('sctAlterarVisibilidadeId');
	if (index == 1)
		select.selectedIndex = 0;
	else if(index == 2)
		select.selectedIndex = 1;
}
	selecionarOpcao(<?php echo $dadosLit['status']; ?>)
//
<?php if ($logado == 1) { ?>
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
<?php } ?>
//
<?php if ($meuUsuario == false) { ?>
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

<?php } /*Meu usuário == false*/ else { ?>

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
	
	//
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
	//
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

<?php } ?>

const pdfFileURL = "<?php echo $dirPdf . $dadosLit['urlPdf']; ?>";
pdfjsLib.getDocument(pdfFileURL).promise.then(function (pdfDoc) {
	const numPages = pdfDoc.numPages;
	document.getElementById('lblQtdePagsId').innerHTML = document.getElementById('lblQtdePagsId').innerHTML.slice(0, -13);
	document.getElementById('lblQtdePagsId').innerHTML += numPages;
}).catch(function (error) {
	console.error('Erro: ', error);
	//alert('Erro ao carregar documento PDF.');
});

<?php if ($logado == 1){ if($dadosLogin['tipoConta'] == 2){ ?>
function verificaLit()
{
	var confirma = prompt("Deseja mesmo tornar a literatura \"<?php echo $dadosLit['titulo']; ?>\" uma literatura verificada?\nDigite \"confirmar\" na caixa abaixo para confirmar.");
	if (confirma == "confirmar")
		window.location.href="BDVerificaLit.php?i=<? echo sha1($idLit); ?>&token=<?php echo $_SESSION['TSFVerificaLit']; ?>";
	else
		alert("A ação não foi feita.");
}

<? } } ?>
