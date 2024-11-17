<?php
include_once('conexao.php');

if (isset($_GET['icat'])){
$IdCatSha1 = $_GET['icat']; }

$txtPesquisa = "";
if (isset($_GET['search']))
{
	$txtPesquisa = $_GET['search'];
}

/*Categorias e categorias filtradas*/
 $queryCats = mysqli_query($conexao, "SELECT * FROM Categoria");
		if (!$queryCats)
		{
            echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
            die('<b>Query Inválida: </b>' . @mysqli_error($conexao));  
	    }


?>

<?php include_once('Styles/barraPesquisa.css');?>

<style>

.divAjaxPesquisa {
	background-color: var(--branco);
	border: 2.5px solid var(--cor1);
	border-radius: 10px;
	visibility: hidden;
	box-sizing: none;
	width: calc(80% - 50px);
	position: absolute;
	z-index: 1;
	max-height: 500px;
    overflow-y: auto;
}

.divAjaxPesquisa::-webkit-scrollbar {
    width: 10px;               /* width of the entire scrollbar */
	height: 10px;
}

.divAjaxPesquisa::-webkit-scrollbar-track {
    background: transparent;        /* color of the tracking area */
    border-radius: 20px;
    width: 10px;
	height: 10px;
}

.divAjaxPesquisa::-webkit-scrollbar-thumb {
    background: var(--azulGradiente);    /* color of the scroll thumb */
    border-radius: 20px;       /* roundness of the scroll thumb */
    width: 10px;
	height: 10px;
}

.resultadoPesquisa {
	color: var(--cor4Escuro);
	text-decoration: none;
}

.paragraph {
	padding: 10px;
	margin: 0;
}

.paragraph:hover {
	background: var(--cor4Claro);
}

.line {
	margin: 0;
	color: var(--cinzaMaisClaro);
	opacity: 1;
}

</style>
<script src="bibliotecas/jquery.js"></script>
<script>
// Função para carregar os resultados usando Ajax
function carregarResultados(search) {
	var divAjaxPesquisa = document.getElementById('divAjaxPesquisaId');
    if (search.trim() !== "") {
        // Limpa o conteúdo anterior
        divAjaxPesquisa.innerHTML = '';

        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'ajax/ajaxBarraPesquisa.php?search=' + search, true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                var data = JSON.parse(xhr.responseText);
                // Adiciona os novos resultados ao div
                data.forEach(function (result) {
                    var link = document.createElement('a');
					link.classList.add('resultadoPesquisa')
                    link.href = 'livro.php?i=' + result.idLitSha1;
                    link.innerHTML = 'Título: ' + result.titulo + '<br>Postado por: ' + result.nome;
                    var paragraph = document.createElement('p');
					paragraph.classList.add('paragraph')
                    paragraph.appendChild(link);
                    divAjaxPesquisa.appendChild(paragraph);
					var line = document.createElement('hr');
					line.classList.add('line');
					divAjaxPesquisa.appendChild(line);
                });
            } else {
                console.error('Erro na requisição Ajax:', xhr.statusText);
            }
        };

        xhr.onerror = function () {
            console.error('Erro na requisição Ajax.');
        };

        xhr.send();
		divAjaxPesquisa.style.visibility = 'visible';
    } else {
        divAjaxPesquisa.innerHTML = '';
		divAjaxPesquisa.style.visibility = 'hidden';
    }
}
</script>
<div class="barraPesquisaCategorias">
	<div class="barraPesquisaAjax">
		<div class="barraPesquisa">
			<input class="txtBarraPesquisa" class="form-control" type="text" oninput="carregarResultados(this.value)" id="searchId" value="<?php echo $txtPesquisa; ?>" placeholder="Pesquise por um livro..." aria-label="Recipient's username" aria-describedby="button-addon2">
			<button class="btnBarraPesquisa" onclick="search()" type="button" id="button-addon2"><?php include_once('icones/Pesquisar.svg'); ?></button><br>
		</div>
		<div id="divAjaxPesquisaId" class="divAjaxPesquisa"></div>
	</div>

	<div class="divCategorias" style="position: relative;">
	<?php while($dadosCats=mysqli_fetch_array($queryCats)){ ?>
		<div onclick="filtrarCat('<?php echo sha1($dadosCats['idCategoria']); ?>')" class="lblNomeCategoria"><?php echo $dadosCats['nomeCategoria']; ?></div>
	<?php } ?>
	</div>
</div>

<script>

function search()
{
	var search = document.getElementById('searchId').value.trim();
	if (search != "")
		window.location = "busca.php?search=" + search;
}
document.getElementById('searchId').addEventListener('keyup', function (event) {
    if (event.key === 'Enter' && document.activeElement === this) {
        search();
    }
});

</script>

<script>

function filtrarCat(idCatSha1)
{ 
	var parametros = new URLSearchParams(window.location.search);
	if (parametros.has('search'))
	{
		var search =  parametros.get('search');
		if (document.getElementById("searchId").value == "")
		{
			search = "";
		}
		window.location.href="busca.php?search=" + search + "&icat=" + idCatSha1;
	}
	else
	{
		window.location.href="busca.php?icat=" + idCatSha1;
	}
}
</script>
<script>
document.querySelectorAll('.lblNomeCategoria').forEach(function(div) {
    div.addEventListener('click', function() {
        this.classList.toggle('filled');
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    var search = document.getElementById('searchId');
    var divAjaxPesquisa = document.getElementById('divAjaxPesquisaId');

    search.addEventListener('focus', () => {
        console.log('Textbox focada');
        divAjaxPesquisa.style.display = 'block';
    });

    search.addEventListener('blur', () => {
        console.log('Textbox desfocada');
        divAjaxPesquisa.style.display = 'none';
    });
});
</script>