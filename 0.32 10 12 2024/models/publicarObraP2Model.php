<?php

function getCategorias()
{
	global $conexao;
    $queryCategoria = mysqli_query($conexao, "SELECT * FROM Categoria");

    if (!$queryCategoria) {
        echo ("Houve um erro ao carregar as categorias. #1");
        return []; // Retorna um array vazio em caso de erro
    }

    $categorias = [];
    
    while ($dadosCats = mysqli_fetch_array($queryCategoria)) {
        $categorias[] = $dadosCats; // Adiciona cada categoria ao array
    }
    
    return $categorias; // Retorna todas as categorias
}

function validaArquivos()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
                $qtdPaginas = $_POST['qtdPaginas'];
				$nomeCompletoPDF = $_FILES['arquivoPdf']['name'];
				$nomeCompletoCapa = $_FILES['arquivoCapa']['name'];
                
            // Verifica se o arquivo foi enviado
            if (isset($_FILES['arquivoPdf']) && $_FILES['arquivoPdf']['error'] === UPLOAD_ERR_OK)
			{
                // Obtém a extensão do arquivo
                $extensao = pathinfo($_FILES['arquivoPdf']['name'], PATHINFO_EXTENSION);

                // Verifica se a extensão é PDF
                if ($extensao === 'pdf' && $qtdPaginas != null) //O arquivo é um PDF
                {
                    $nomeArquivoPDF = $_FILES['arquivoPdf']['name']; //para reenviar PDF pelo form
                    $caminhoTemporarioPDF = $_FILES['arquivoPdf']['tmp_name']; //para reenviar PDF pelo form
                    $dadosArquivoPDF = file_get_contents($caminhoTemporarioPDF); //para reenviar PDF pelo form
                }
                else if ($extensao === 'pdf' && $qtdPaginas == null)
                {
                    $_SESSION['publicarObraP1.phpErro'] = 3;
                    header('Location: publicarObraP1.php');
                    exit();
                }
                else //não é PDF
                {
                    $_SESSION['publicarObraP1.phpErro'] = 1;
                    header('Location: publicarObraP1.php');
                    exit();
                }
            }
             if (isset($_FILES['arquivoCapa']) && $_FILES['arquivoCapa']['error'] === UPLOAD_ERR_OK)
            {
                $nomeArquivoCapa = $_FILES['arquivoCapa']['name'];
                $caminhoTemporarioCapa = $_FILES['arquivoCapa']['tmp_name']; //para reenviar imagem pelo form
                $dadosArquivoCapa = file_get_contents($caminhoTemporarioCapa); //para reenviar imagem pelo form

                $extensao = strtolower(pathinfo($nomeArquivoCapa, PATHINFO_EXTENSION));
                $extensoesPermitidas = array('jpg', 'jpeg', 'png');

                if (!in_array($extensao, $extensoesPermitidas))
                {
                    $_SESSION['publicarObraP1.phpErro'] = 4;
                    header('Location: publicarObraP1.php');
                    exit();
                }
                $dadosCapaImgBase64 = file_get_contents($_FILES['arquivoCapa']['tmp_name']);
            }
            if ($_FILES['arquivoPdf']['error'] === 4)
            {
                $_SESSION['publicarObraP1.phpErro'] = 2;
                    header('Location: publicarObraP1.php');
                    exit();
            }
			/**//**/
			if (mb_strlen($nomeCompletoPDF) > 42 || mb_strlen($nomeCompletoCapa) > 42)
				{
					$_SESSION['publicarObraP1.phpErro'] = 5;
                    header('Location: publicarObraP1.php');
                    exit();
				}
        }
		return [$qtdPaginas, $nomeArquivoPDF, $dadosArquivoPDF, @$nomeArquivoCapa, @$dadosArquivoCapa];
}

function formataTxtCapitulos($qtdPaginas)
{
	$txtseletorCapitulos = "";
	$txtCapitulosPlural = "página";

	if ($qtdPaginas > 1)
	{
		$txtseletorCapitulos = "Dentre as $qtdPaginas páginas do seu PDF,";
		$txtCapitulosPlural = "páginas";
	}
		
	return [$txtseletorCapitulos, $txtCapitulosPlural];
}
function buscaClassificacao()
{
	global $conexao;
	$stmt = $conexao->prepare("SELECT * FROM classificacao");
	$stmt->execute();
	$result = $stmt->get_result();
	$dadosClassif = $result->fetch_all(MYSQLI_ASSOC);
	$stmt->close();
	
	return $dadosClassif;
}

?>