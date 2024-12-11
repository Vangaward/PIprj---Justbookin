<?php include_once('forcaRota.php'); ?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<?php include_once("detalhesHead.php"); ?>
		<link rel="stylesheet" href="Balacowork/Balacowork.css">
		<link rel="stylesheet" href="Styles/leitor.css">
		<title>Exibir PDF</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php include_once ("b.php"); ?>
    </head>
<body>

	<?php include_once("header.php");?>
	<main class="conteudo">
	<?php if ($dadosLit['status'] > 0 && $meuUsuario || $dadosLit['status'] == 0){ ?>
		<div id="popup-container">
			<div id="popup">
				<img class="loading4Img" src="imagens/loading4.gif">
			</div>
		</div>
		
		<center style="display: flex; flex-direction: column; gap: 20px">
			<button class="btnVoltar" onclick="window.location.href='livro.php?i=<?php echo $idLitSha1; ?>'">Voltar à página do livro</button>
			<div class="livro">
				<div class="botoes">
					<div class="anteProx">
						<?php if ($temCaps == 1){?>
						<button class="btnAnt" onclick="window.location.href='<?php echo $linkBtnCapAnt; ?>'"><label class="iconBtn">❮</label><label class="textBtn">Anterior</label></button>
						<?php } ?>
					</div>
				</div>
					<div class="pdfViewerBorda">
						<div id="pdfViewer"></div>
					</div>
				<div class="botoes">
					<div class="anteProx">
						<?php if ($temCaps == 1){?>
						<button class="btnPro" onclick="window.location.href='<?php echo $linkBtnCapProx; ?>'"><label class="iconBtn">❯</label><label class="textBtn">Próximo</label></button>
						<?php } ?>
					</div>
				</div>
			</div>
			<button class="btnVoltar" onclick="window.location.href='livro.php?i=<?php echo $idLitSha1; ?>'">Voltar à página do livro</button>
		</center>
	</main>
	<?php include_once("footer.php");?>
</body>
</html>
  
    <script src="/bibliotecas/build/pdf.js"></script>
	
	<script>
var pagInicial;
var pagFinal;
var temCaps = <?php echo $temCaps; ?>;
var urlDoPDF = '<?php echo $dirPdf . $dadosLit['urlPdf']; ?>';

pdfjsLib.getDocument(urlDoPDF).promise.then(function (pdfDoc) {
	
	if (temCaps == 0)
	{
		pagInicial = 1
		pagFinal = pdfDoc.numPages;
	}
	<?php if (isset($haProxCap) && isset($haAntCap)){ ?>
	else //há caps
	{
		pagInicial = <?php if ($temCaps == 1 && $urlCapVazia == 0){echo $dadosCapLit['paginaInicial']; } if ($temCaps == 1 && $urlCapVazia == 1) {echo 1;} if ($temCaps == 0){echo 0;}?>;
		pagFinal = <?php if ($temCaps == 1 && $haProxCap == 1){echo $dadosCapLitProxCap['paginaInicial']; ?> - 1;
	<?php }else {?>
		//alert(<?php echo $haProxCap; ?>)
		pdfDoc.numPages;
		<?php } ?>
	}
	<?php } ?>
		
    var startPage = pagInicial; // Página inicial do intervalo desejado
    var endPage = pagFinal; // Página final do intervalo desejado
	
    var pdfViewer = document.getElementById('pdfViewer'); // Carrega e exibe o PDF

    var loadPage = function (pageNumber) {
        pdfDoc.getPage(pageNumber).then(function (page) {
            // Define a escala com base na largura da tela
			var scale = 1.5; // Padrão para desktops
			if (window.innerWidth <= 1024) {
				scale = 2; // Escala maior para tablets
			}
			if (window.innerWidth <= 768) {
				scale = 2.5; // Escala ainda maior para smartphones
			}

			var viewport = page.getViewport({ scale: scale });


            var canvas = document.createElement('canvas');
            var context = canvas.getContext('2d');
            canvas.width = viewport.width;
            canvas.height = viewport.height;

            var renderContext = {
                canvasContext: context,
                viewport: viewport
            };

            page.render(renderContext).promise.then(function () {
                var pageDiv = document.createElement('div');
                pageDiv.classList.add('pdfPage'); // Adiciona a classe pdfPage
                pageDiv.appendChild(canvas);
                pdfViewer.appendChild(pageDiv);

                // Verifica se ainda há páginas para carregar
                if (pageNumber < endPage) {
                    loadPage(pageNumber + 1);
                } else {
                    // Todas as páginas foram carregadas
                    setTimeout(fecharPopup, 1000);
                }
            });
        });
    };

    loadPage(startPage);
});

function fecharPopup() {
    var popupContainer = document.getElementById("popup-container");
    popupContainer.style.display = "none";
}
</script>

<script>
// Função para ajax das visualizações

function atualizarViews() {
    var xhr = new XMLHttpRequest();

    // Configura a requisição
    xhr.open("GET", "ajax/ajaxBDViewsLeitor.php", true);
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300)
		{
			//alert("visualizado");
        } else {
            console.error("Erro na visualização");
        }
    };
	xhr.send();
}

// Verifica se já foi executado o comando para incluir a visualização
if (!localStorage.getItem('viewsAtualizados')) {
    localStorage.setItem('viewsAtualizados', true);
    // Chama a função depois de 2000 milissegundos (2 segundos) na primeira carga da página
    setTimeout(function() {
        atualizarViews();
    }, 5000);
}

// Limpa o localStorage ao fechar a página completamente
window.addEventListener('beforeunload', function(event) {
    // Verifica se a página está sendo fechada completamente
    if (event.clientX < 0 || event.clientY < 0 || event.pageX < 0 || event.pageY < 0) {
        localStorage.removeItem('viewsAtualizados');
    }
});

</script>

<?php
	} //verifica se está privada
	else
	{ ?>
		<h2>Essa literaura é privada ou bloqueada.</h2>
		<button onclick="location.href='index.php'">Voltar à página inicial</button>
		<?php include('footer.php');?>
		<?
	}
?>