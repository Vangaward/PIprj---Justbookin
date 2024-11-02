<?php 
include_once('conexao.php');
include_once('Vlogin.php');
include_once('Vcli.php');

if ($logado == 1) {
?>

<!DOCTYPE html>
<html>
<head>
    <title>Novo Livro | JustBookin</title>
    <?php include_once("detalhesHead.php"); ?>
    <link rel="stylesheet" href="Balacowork/Balacowork.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <?php include_once("Styles/publicarObraP1.css"); ?>
    <?php include_once("Styles/fonte.css"); ?>

    <style>
        .pdfViewerBorda {
            width: 200px;
            height: 300px;
            overflow: auto; /* Permite rolagem se o PDF for maior */
        }

        .pdfPage {
            display: block;
            margin-bottom: 20px;
            border: 1px solid var(--cor4Escuro); /* Borda individual para cada página */
            padding: 5px; /* Espaço interno da borda */
        }

        .pdfPage canvas {
            max-width: 100%; /* Garante que o canvas não exceda a largura da div */
            height: auto; /* Mantém a proporção do PDF */
        }
    </style>
</head>

<body>
    <?php include_once("header.php"); ?>

    <main class="conteudo">
        <?php
        // Exibe mensagens de erro se houver
        if (isset($_SESSION['publicarObraP1.phpErro'])) {
            $msgErro = "";
            switch ($_SESSION['publicarObraP1.phpErro']) {
                case 1:
                    $msgErro = "O arquivo selecionado não é um PDF, por favor, selecione apenas arquivos em formato PDF!";
                    break;
                case 2:
                    $msgErro = "Faltam arquivos, anexe o PDF e a Capa e tente novamente!";
                    break;
                case 3:
                    $msgErro = "Houve um erro da nossa parte, por favor, tente novamente.";
                    break;
                case 4:
                    $msgErro = "O arquivo da capa não é válido, selecione apenas arquivos .jpg, .jpeg, ou .png!";
                    break;
                case 5:
                    $msgErro = "O nome de um dos arquivos é muito grande para o upload.";
                    break;
            }
            echo "<div class='alert alert-danger' role='alert' style='animation-name: Rotacao3d; animation-duration: 1s;'><center>$msgErro</center></div>";
            unset($_SESSION['publicarObraP1.phpErro']);
        }
        ?>

        <label class="tituloPagina">PUBLICAR OBRA</label>
        <form method="POST" action="publicarObraP2.php" id="frmPublicarId" enctype="multipart/form-data">
            <div class="etapas">
                <div class="selecaoArquivo">
                    <label class="texto">1. Selecione o conteúdo (PDF):</label>
                    <div class="input-wrapper">
                        <div class="pdfViewerBorda">
                            <div id="pdfViewer"></div>
                        </div>
                    </div>
                    <div class="btnArquivo">
                        <label class="lblArquivo" for="arquivoPdfId">Enviar PDF</label>
                        <input type="file" id="arquivoPdfId" name="arquivoPdf" placeholder="Anexar PDF" onchange="carregarPDF(); validarEnvio();" accept="application/pdf" required>
                    </div>
                </div>
                <div class="selecaoArquivo">
                    <label class="texto">2. Selecione a imagem da capa:</label>
                    <div class="input-wrapper">
                        <div class="pdfViewerBorda">
                            <div class="imgCard" id="CapaViewer"></div>
                        </div>
                    </div>
                    <div class="btnArquivo">
                        <label class="lblArquivo" for="capaId">Enviar Imagem</label>
                    </div>
                </div>
            </div>
            <input id="capaId" type="file" name="arquivoCapa" placeholder="Anexar Capa" onchange="exibirImagem(event); validarEnvio();" accept="image/*"><br>
            <input type="hidden" name="qtdPaginas" id="numeroPaginasInput">
            <div class="input-wrapper">
                <button class="btnPro" onclick="enviarFormPublicar()" name="publicarObraP1Form" id="publicarObraP1FormId"><?php include_once('icones/Seta_Avancar.svg'); ?> Próximo</button>
            </div>
        </form>
    </main>

    <?php include_once("footer.php"); ?>
</body>

</html>

<script src="/bibliotecas/build/pdf.js"></script>
<script>
    var btnProximo = document.getElementById('publicarObraP1FormId');
    var qtdPaginas = document.getElementById('numeroPaginasInput');

    function carregarPDF() {
        btnProximo.disabled = true;
        btnProximo.innerText = "Aguarde...";

        var fileInput = document.getElementById('arquivoPdfId');
        var pdfFile = fileInput.files[0];
        if (pdfFile) {
            var pdfFileURL = URL.createObjectURL(pdfFile);
            pdfjsLib.getDocument(pdfFileURL).promise.then(function (pdfDoc) {
                var numPages = pdfDoc.numPages;
                qtdPaginas.value = numPages;

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
                            pageDiv.classList.add('pdfPage');
                            pageDiv.appendChild(canvas);
                            document.getElementById('pdfViewer').appendChild(pageDiv);

                            if (pageNumber < numPages) {
                                loadPage(pageNumber + 1);
                            }
                        });
                    });
                };
                loadPage(1);

                btnProximo.disabled = false;
                btnProximo.innerText = "<?php include_once('icones/Seta_Avancar.svg'); ?> Próximo";
            });
        }
    }
</script>

<script>
    function exibirImagem(event) {
        btnProximo.disabled = true;
        btnProximo.innerText = "Aguarde...";

        var input = event.target;
        var reader = new FileReader();

        reader.onload = function () {
            var imagem = document.createElement("img");
            imagem.src = reader.result;
            document.getElementById("CapaViewer").innerHTML = "";
            document.getElementById("CapaViewer").appendChild(imagem);

            btnProximo.disabled = false;
            btnProximo.innerText = "<?php include_once('icones/Seta_Avancar.svg'); ?> Próximo";
        };
        reader.readAsDataURL(input.files[0]);
    }
</script>

<script>
    function validarEnvio() {
        var inputArquivoCapa = document.getElementById('capaId');
        var inputArquivoPdf = document.getElementById('arquivoPdfId');
        var tamanhoMaximoNome = 42;

        if (inputArquivoCapa.files[0]) {
            var nomeArquivoCapa = inputArquivoCapa.files[0].name;
            if (nomeArquivoCapa.length > tamanhoMaximoNome) {
                alert('O nome do arquivo da capa é muito grande. Por favor, escolha um nome de arquivo mais curto. (Máximo de 42 caracteres)');
                btnProximo.disabled = true;
                document.getElementById('pdfViewer').innerHTML = '';
                location.reload();
            }
        }

        if (inputArquivoPdf.files[0]) {
            var nomeArquivoPdf = inputArquivoPdf.files[0].name;
            if (nomeArquivoPdf.length > tamanhoMaximoNome) {
                alert('O nome do arquivo PDF é muito grande. Por favor, escolha um nome de arquivo mais curto.');
                btnProximo.disabled = true;
                document.getElementById('pdfViewer').innerHTML = '';
                location.reload();
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
</script>

<?php
} else {
    // Redireciona para a página de login se não estiver logado
    header('Location: login');
    exit;
}
?>
