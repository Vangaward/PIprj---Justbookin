<?php
include_once ('conexao.php');
include_once ('Vlogin.php');
include_once ('Vcli.php');
include_once('configs.php');

$idLitSha1 = $_GET['i'];
$temCaps;
$urlCapVazia;
// Preparar a consulta SQL usando um prepared statement
$queryLit = "SELECT * FROM Literatura WHERE sha1(idLit) = ?";
$stmt = mysqli_prepare($conexao, $queryLit);

if ($stmt) {
    // Vincular os parâmetros ao prepared statement
    mysqli_stmt_bind_param($stmt, 's', $idLitSha1);

    // Executar a consulta
    if (mysqli_stmt_execute($stmt)) {
        // Obter o resultado
        $result = mysqli_stmt_get_result($stmt);
        $dadosLit = mysqli_fetch_array($result); // Obter os dados do resultado

        // Verifique se foram retornados dados
        if (!$dadosLit) {
            echo '<input type="button" onclick="window.location=\'index.php\';" value="Voltar"><br><br>';
            die('Literatura não encontrada');
        }
    } else {
        // Erro ao executar a consulta
        echo '<input type="button" onclick="window.location=\'index.php\';" value="Voltar"><br><br>';
        die('<b>Erro ao executar a consulta: </b>' . mysqli_error($conexao));
    }

    // Fechar o statement
    mysqli_stmt_close($stmt);
} else {
    // Erro ao preparar a consulta
    echo '<input type="button" onclick="window.location=\'index.php\';" value="Voltar"><br><br>';
    die('<b>Erro ao preparar a consulta: </b>' . mysqli_error($conexao));
}
	
	
	$_SESSION['ajaxLeitorViews'] = $dadosLit['idLit']; //Variável usada pelo arquivo ajaxBDViewsLeitor.php
	
/*Meu Usuário*/
$meuUsuario = false;
	if ($logado == 1)
	{
		if ($dadosLit['idUsuario'] == $dadosLogin['idUsuario'])
		{
			$meuUsuario = true;
		}
	}

/*caps*/
 $queryCapsLit = mysqli_query($conexao, "SELECT * from capituloLit where sha1(idLit) = '$idLitSha1';");
		if (!$queryCapsLit)
		{
            echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
            die('<b>Query Inválida: </b>'/* . @mysqli_error($conexao)*/);  
	    }
		if(mysqli_num_rows($queryCapsLit) <=0)
		{$temCaps = 0;}
		else
		{
			$temCaps = 1;
				/*cap*/
			if (isset($_GET['cap']))
			{
				$numCap = $_GET['cap'];
				$urlCapVazia = 0;
			}
			else {$numCap = 1; $urlCapVazia = 1; }
			 $queryCapLit = mysqli_query($conexao, "SELECT * from capituloLit where sha1(idLit) = '$idLitSha1' and numCapitulo = '$numCap';");
				if (!$queryCapLit)
				{
					echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
					die('<b>Query Inválida: </b>'/* . @mysqli_error($conexao)*/);  
				}
				$dadosCapLit = mysqli_fetch_array($queryCapLit);
				
				$queryCapLitProxCap = mysqli_query($conexao, "SELECT * from capituloLit where sha1(idLit) = '$idLitSha1' and numCapitulo = " . $numCap + 1 . ";");
				if (!$queryCapLitProxCap)
				{
					echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
					die('<b>Query Inválida: </b>'/* . @mysqli_error($conexao)*/);  
				}
				if(mysqli_num_rows($queryCapLitProxCap) > 0) {$haProxCap = 1;} else {$haProxCap = 0;}
				$dadosCapLitProxCap = mysqli_fetch_array($queryCapLitProxCap);
				
				$queryCapLitAntCap = mysqli_query($conexao, "SELECT * from capituloLit where sha1(idLit) = '$idLitSha1' and numCapitulo = " . $numCap - 1 . ";");
				if (!$queryCapLitAntCap)
				{
					echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
					die('<b>Query Inválida: </b>'/* . @mysqli_error($conexao)*/);  
				}
				if(mysqli_num_rows($queryCapLitAntCap) > 0) {$haAntCap = 1;} else {$haAntCap = 0;}
				$dadosCapLitAntCap = mysqli_fetch_array($queryCapLitAntCap);
		
		$linkBtnCapAnt;
		if (isset($dadosCapLitAntCap['numCapitulo']))
		{
			if ($dadosCapLitAntCap['numCapitulo'] == null)
			{
				$linkBtnCapAnt = "leitor.php?i=" . $idLitSha1;
			}
			else
			{
				$linkBtnCapAnt = "leitor.php?i=" . $idLitSha1 . "&cap=" . $dadosCapLitAntCap['numCapitulo'];
			}
		}
		/**//**/
		$linkBtnCapProx;
		if ($dadosCapLitProxCap['numCapitulo'] == null)
		{
			$linkBtnCapProx = "leitor.php?i=" . $idLitSha1 . "&cap=" . $dadosCapLit['numCapitulo'];
		}
		else
		{
			$linkBtnCapProx = "leitor.php?i=" . $idLitSha1 . "&cap=" . $dadosCapLitProxCap['numCapitulo'];
		}
		
		} //tem caps
		
		//Histórico de visualizações
		/*if ($logado == 1)
		{
			$queryInsertLike = mysqli_query($conexao, "INSERT INTO curtidasLit (curtida, idUsuario, idLit) values (1, '$idUsuario', '$idLit')");
		}*/
		
?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<?php include_once("detalhesHead.php"); ?>
		<link rel="stylesheet" href="Balacowork/Balacowork.css">
		<link rel="stylesheet" href="Styles/leitor.css">
		<title>Exibir PDF</title>
		<?php include_once ("b.php"); ?>
    </head>
<body>

<?php include_once("header.php");?>

<?php if ($dadosLit['status'] > 0 && $meuUsuario || $dadosLit['status'] == 0){ ?>

<!--<div id="popup-container">
        <div id="popup">
            <img class="loading4Img" src="imagens/loading4.gif">
        </div>
    </div>
!-->
	<center>
		<button class="btnVoltar" onclick="window.location.href='livro.php?i=<?php echo $idLitSha1; ?>'">Voltar à página do livro</button>
		<div class="livro">
			<div class="botoes">
				<div class="anteProx">
					<?php if ($temCaps == 1){?>
					<button class="btnAnt" onclick="window.location.href='<?php echo $linkBtnCapAnt; ?>'">Anterior</button>
					<?php } ?>
				</div>
			</div>
				<div class="pdfViewerBorda">
					<div id="pdfViewer"></div>
				</div>
			<div class="botoes">
				<div class="anteProx">
					<?php if ($temCaps == 1){?>
					<button class="btnPro" onclick="window.location.href='<?php echo $linkBtnCapProx; ?>'">Próximo</button>
					<?php } ?>
				</div>
			</div>
		</div>
		<button class="btnVoltar" onclick="window.location.href='livro.php?i=<?php echo $idLitSha1; ?>'">Voltar à página do livro</button>
	</center>
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
            var scale = 1.5;
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
		<h2>Essa literaura é privada.</h2>
		<button onclick="location.href='index.php'">Voltar à página inicial</button>
		<?php include('footer.php');?>
		<?
	}
?>