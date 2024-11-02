<?php
require_once 'classes/Cripto.php';

include_once('conexao.php');
include_once('Vlogin.php');
include_once('Vcli.php');
include_once('helperBD.php');

$splashScreen = false;

if (!isset($_GET['splash'])) {
    $splashScreen = false; //não mexer aqui
}


/*function mf($valor)
{
	return $valor;
}
$teste = "0a57cb53ba59c46fc4b692527a38a87c78d84028";

//$queryTeste = mysqli_query($conexao, "SELECT * FROM Literatura where password_hash('idLit', PASSWORD_BCRYPT) = '$teste'");//hash('sha1', $valor);

$queryTeste = mysqli_query($conexao, "SELECT * FROM Literatura where " . (new Cripto(""))->getTc() . "(idLit) = '$teste'");


$dadosTeste = mysqli_fetch_array($queryTeste);

die($dadosTeste['titulo']);
*/
$queryLitTop = mysqli_query($conexao, "
    SELECT l.idLit, l.titulo, l.urlCapa, u.nomeUsuario, u.nome, COUNT(cl.curtida = 1) as qtdCurtidas, SUM(cl.curtida = 0) as qtdeNaoCurtidas 
    FROM Literatura l 
    INNER JOIN usuario u ON l.idUsuario = u.idUsuario 
    LEFT JOIN curtidasLit cl ON l.idLit = cl.idLit
    WHERE cl.curtida = 1 and " . $litBloqOuPriv . "
    GROUP BY l.idLit 
    ORDER BY qtdCurtidas DESC, qtdeNaoCurtidas 
    LIMIT 10;
");

$queryLitMaisViews = mysqli_query($conexao, "
    SELECT l.idLit, l.titulo, l.urlCapa, u.nomeUsuario, u.nome
    FROM Literatura l
    INNER JOIN usuario u ON l.idUsuario = u.idUsuario
	WHERE " . $litBloqOuPriv . "
	ORDER BY views DESC LIMIT 10;
");

$queryLitMaisFavs = mysqli_query($conexao, "
SELECT 
    f.idLit,
    l.titulo,
    l.urlCapa,
    u.nomeUsuario,
    u.nome,
    COUNT(*) AS qtdeFavoritos
FROM 
    favorito f
INNER JOIN 
    Literatura l ON l.idLit = f.idLit
INNER JOIN 
    usuario u ON l.idUsuario = u.idUsuario
	WHERE " . $litBloqOuPriv . "
GROUP BY 
    f.idLit, l.titulo, l.urlCapa, u.nomeUsuario, u.nome
ORDER BY 
    qtdeFavoritos DESC;
");

$queryLitMaisRecentes = mysqli_query($conexao, "
    SELECT l.idLit, l.titulo, l.urlCapa, u.nomeUsuario, u.nome
    FROM Literatura l
    INNER JOIN usuario u ON l.idUsuario = u.idUsuario
	WHERE " . $litBloqOuPriv . "
	ORDER BY dataLanc DESC LIMIT 10;
");

$queryLitTodas = mysqli_query($conexao, "
    SELECT l.idLit, l.titulo, l.urlCapa, u.nomeUsuario, u.nome
    FROM Literatura l
    INNER JOIN usuario u ON l.idUsuario = u.idUsuario
	WHERE " . $litBloqOuPriv . ";
");

if (!$queryLitTop || !$queryLitTodas) {
    echo '<input type="button" onclick="window.location=\'index.php\';" value="Voltar"><br><br>';
    die('<b>Query Inválida:</b>');  
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include_once("detalhesHead.php"); ?>
    <title>JustBookIn</title>
	<link rel="stylesheet" href="Balacowork/Balacowork.css">
    <link rel="stylesheet" href="Styles/inicio.css">
    <link rel="stylesheet" href="Styles/fonte.css">
    <link rel="stylesheet" href="Styles/card.css">
</head>
<body id="bodyInicio">
    <?php include_once("splashScreen.php"); ?>
    <?php include_once("header.php"); ?>
    
	<?
		//echo (new Cripto(1))->getCripto();
	?>
	
    <main class="conteudo">
        <div class="inicio" id="inicioId">
            <div class="input-group mb-3">
                <?php include_once('barraPesquisa.php'); ?>
            </div>
            <label class="tituloPagina">Top 10 com mais curtidas:</label>
            <div id="idTopLits" class="litsHoriz">
                <?php while ($dadosLitTop = mysqli_fetch_array($queryLitTop)) { 
                    $img = $dadosLitTop['urlCapa'] ? "imagensCapa/" . $dadosLitTop['urlCapa'] : "imagens/batata.png";
                    $idLitCard = sha1($dadosLitTop['idLit']);
                    $titulo = $dadosLitTop['titulo'];
                    $nomeUser = $dadosLitTop['nomeUsuario'];
                    include("cardLivro.php"); 
                } ?>
            </div><!-- litsHoriz -->

            <label class="tituloPagina">Top 10 mais visualizadas:</label>
            <div id="idMaisViewsLits" class="litsHoriz">
                <?php while ($dadosLitMaisViews = mysqli_fetch_array($queryLitMaisViews)) { 
                    $img = $dadosLitMaisViews['urlCapa'] ? "imagensCapa/" . $dadosLitMaisViews['urlCapa'] : "imagens/batata.png";
                    $idLitCard = sha1($dadosLitMaisViews['idLit']);
                    $titulo = $dadosLitMaisViews['titulo'];
                    $nomeUser = $dadosLitMaisViews['nomeUsuario'];
                    include("cardLivro.php"); 
                } ?>
            </div><!-- litsHoriz -->
			
			<label class="tituloPagina">Top 10 mais favoritadas:</label>
            <div id="idMaisViewsLits" class="litsHoriz">
                <?php while ($dadosLitMaisFavs = mysqli_fetch_array($queryLitMaisFavs)) { 
                    $img = $dadosLitMaisFavs['urlCapa'] ? "imagensCapa/" . $dadosLitMaisFavs['urlCapa'] : "imagens/batata.png";
                    $idLitCard = sha1($dadosLitMaisFavs['idLit']);
                    $titulo = $dadosLitMaisFavs['titulo'];
                    $nomeUser = $dadosLitMaisFavs['nomeUsuario'];
                    include("cardLivro.php"); 
                } ?>
            </div><!-- litsHoriz -->
			
			<label class="tituloPagina">Acabaram de sair do forno:</label>
            <div id="idMaisViewsLits" class="litsHoriz">
                <?php while ($dadosLitMaisRecentes = mysqli_fetch_array($queryLitMaisRecentes)) { 
                    $img = $dadosLitMaisRecentes['urlCapa'] ? "imagensCapa/" . $dadosLitMaisRecentes['urlCapa'] : "imagens/batata.png";
                    $idLitCard = sha1($dadosLitMaisRecentes['idLit']);
                    $titulo = $dadosLitMaisRecentes['titulo'];
                    $nomeUser = $dadosLitMaisRecentes['nomeUsuario'];
                    include("cardLivro.php"); 
                } ?>
            </div><!-- litsHoriz -->
			
			<label class="tituloPagina">Todas as literaturas:</label>
            <div id="idTodasLits" class="litsHoriz">
                <?php while ($dadosLitTodas = mysqli_fetch_array($queryLitTodas)) { 
                    $img = $dadosLitTodas['urlCapa'] ? "imagensCapa/" . $dadosLitTodas['urlCapa'] : "imagens/batata.png";
                    $idLitCard = sha1($dadosLitTodas['idLit']);
                    $titulo = $dadosLitTodas['titulo'];
                    $nomeUser = $dadosLitTodas['nomeUsuario'];
                    include("cardLivro.php"); 
                } ?>
            </div><!-- litsHoriz -->
			
        </div><!-- inicio -->
    </main>

    <div class="clearfix"></div>
    <?php include_once("footer.php"); ?>
</body>
</html>

<script src="bibliotecas/jquery.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    var scrollContainer = document.querySelector('.divDivisor');

    scrollContainer.addEventListener('mousemove', function (e) {
        if (e.buttons === 1) { // Verifica se o botão do mouse está pressionado (botão esquerdo)
            scrollContainer.scrollLeft += e.movementX; // Move a barra de rolagem horizontal com o movimento do mouse
        }
    });
});
</script>
<script>
document.getElementById('idTopLits').addEventListener('wheel', function(event) {
    if (event.deltaY !== 0) {
        // Se a roda do mouse rolar verticalmente, não faz nada
        return;
    }

    // Se a roda do mouse rolar horizontalmente
    this.scrollLeft += event.deltaX;
    event.preventDefault();
});
</script>
