function toggleDropdown() {
            var dropdownContent = document.getElementById("dropdown-content");
            if (dropdownContent.style.display === "none" || dropdownContent.style.display === "") {
                dropdownContent.style.display = "block";
            } else {
                dropdownContent.style.display = "none";
            }
        }

function ordemDesc ()
{
	 window.location.href = 'perfil.php?i=<?php echo $idUsuarioSha1; ?>&lad=desc#containerObrasId'; //lad = Literaturas - Asc ou Desc
}
function ordemAsc ()
{
	 window.location.href = 'perfil.php?i=<?php echo $idUsuarioSha1; ?>&lad=asc#containerObrasId';
}

/**/

$(window).on('scroll', function() {
    let scrollTop = $(this).scrollTop();

    // Mova o banner a uma velocidade um pouco mais rápida que a rolagem normal
    $('.Banner').css('transform', 'translate3d(0,' + (scrollTop * 0.5) + 'px, 0)');
});
</script>

<script>
function fecharPopup() {
	var popupContainer = document.getElementById("popup-container");
	popupContainer.style.display = "none";
}

/**/

function enviarFormularioImgPerfil() {
	// Obtém o formulário pelo ID
	var formulario = document.getElementById('frmFotoPerfilId');
	var inputArquivoPerfil = document.getElementById('arquivoFotoPerfilId');
	var tamanhoMaximoNome = 41;
	// Verificar o campo de capa
		if (inputArquivoPerfil.files[0]) {
			var nomeArquivoPerfil = inputArquivoPerfil.files[0].name;
			// Verificar o tamanho do nome
			if (nomeArquivoPerfil.length > tamanhoMaximoNome) {
				alert('O nome do arquivo da foto de perfil é muito grande. Por favor, escolha um nome de arquivo mais curto. (Máximo de 41 caracteres)');
				window.location.reload();
			}
			else
			{
				// Envia o formulário
				openPopupAtualizandoImgPerfil();
				formulario.submit();
			}
				
		}
}

function openPopupAtualizandoImgPerfil() {
	fecharPopupExcluirImgPerfil();
	fecharPopupImgPerfilEdit();
    var containerImgPerfil = document.getElementById('popup-containerAtualizandoImgPerfil');
    containerImgPerfil.style.display = 'flex';
}

function openPopupExcluirImgPerfil() {
    var containerImgPerfil = document.getElementById('popup-containerExcluirImgPerfil');
    containerImgPerfil.style.display = 'flex';
}

function openPopupImgPerfilEdit() {
    var containerImgPerfil = document.getElementById('popup-containerImgPerfilEdit');
    containerImgPerfil.style.display = 'flex';
}

function fecharPopupExcluirImgPerfil ()
{
	var popupContainer = document.getElementById("popup-containerExcluirImgPerfil");
	popupContainer.style.display = "none";
}
function fecharPopupImgPerfilEdit ()
{
	var popupContainer = document.getElementById("popup-containerImgPerfilEdit");
	popupContainer.style.display = "none";
}

/**/

function enviarFormularioBanner() {
	// Obtém o formulário pelo ID
	var formulario = document.getElementById('frmBanner');
	var inputArquivo = document.getElementById('arquivoBannerId');
	var tamanhoMaximoNome = 41;
	// Verificar o campo de capa
		if (inputArquivo.files[0]) {
			var nomeArquivo = inputArquivo.files[0].name;
			// Verificar o tamanho do nome
			if (nomeArquivo.length > tamanhoMaximoNome) {
				alert('O nome do arquivo do banner é muito grande. Por favor, escolha um nome de arquivo mais curto. (Máximo de 41 caracteres)');
				window.location.reload();
			}
			else
			{
				// Envia o formulário
				openPopupAtualizandoBanner();
				formulario.submit();
			}
				
		}
} //popup-containerBanner

function openPopupAtualizandoBanner()
{
	fecharPopupImgBanner();
	fecharPopupExcluirBanner();
	var containerImgPerfil = document.getElementById('popup-containerAtualizandoBanner');
    containerImgPerfil.style.display = 'flex';
}

function openPopupBanner() {
    var containerImgPerfil = document.getElementById('popup-containerBanner');
    containerImgPerfil.style.display = 'flex';
}

function openPopupExcluirBanner() { //excluirConfirmação
    var containerImgPerfil = document.getElementById('popup-containerExcluirBanner');
    containerImgPerfil.style.display = 'flex';
	fecharPopupImgBanner();
}

function openPopupBannerEdit() { //principal
    var containerImgPerfil = document.getElementById('popup-containerBannerEdit');
    containerImgPerfil.style.display = 'flex';
}

function fecharPopupExcluirBanner ()
{
	var popupContainer = document.getElementById("popup-containerExcluirBanner");
	popupContainer.style.display = "none";
}
function fecharPopupImgBanner ()
{
	var popupContainer = document.getElementById("popup-containerBannerEdit");
	popupContainer.style.display = "none";
}

<?php if ($meuUsuario == false) { ?>

//Função para ajax do botão de Insecrever-se
function inscreverSeAjax() {
	document.getElementById('btnSeguir').textContent = '...';
	if (<?php echo $logado; ?> == 0){window.location.href = 'login';}
	else
	{
		var xhr = new XMLHttpRequest();

		// Configura a requisição
		xhr.open("GET", "ajax/ajaxBDInscreverSe.php?i=<?php echo $_GET['i']; ?>", true);
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
				{alert("você não pode seguir o seu próprio perfil!");}
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
	}
}

<?php } ?>

<?php if($dadosLogin['tipoConta'] == 1 && $dadosUsuario['tipoConta'] != 1){ ?>
function verificaEditora()
{
	var confirma = prompt("Deseja mesmo tornar a conta <?php echo $dadosUsuario['nomeUsuario']; ?> uma editora verificada?\nDigite \"confirmar\" na caixa abaixo para confirmar.");
	if (confirma == "confirmar")
		window.location.href="adm/BDverificaEditora.php?i=<? echo $idUsuarioSha1; ?>&token=<?php echo $_SESSION['TSFVerificaEditora']; ?>&tipoAtual=<?php echo $dadosUsuario['tipoConta']; ?>";
	else
		alert("A ação não foi feita.");
}

<? } ?>