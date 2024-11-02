<?php

include_once('configs.php');

if (!isset($logado)) {
    $logado = 0;
	}
	else
	{
		if ($logado == 1)
		{
			//Imagem de perfil
			$urlFotoPerfil;
			if ($dadosLogin['urlFotoPerfil'] == "")
			{ $urlFotoPerfil = "imagens/userPerfil.svg";}else{$urlFotoPerfil = $dirFotoPerfil . $dadosLogin['urlFotoPerfil'];}
			
			//Inscrições
			$idUsuariosessao = $dadosLogin['idUsuario'];
			$queryUsuarioSeguido = mysqli_query($conexao, "
			SELECT s.idUsuarioSeguido, u.nome, u.sobrenome, u.nomeUsuario, u.urlFotoPerfil FROM seguidos s
			INNER JOIN usuario u ON u.idUsuario = s.idUsuarioSeguido
			WHERE s.idUsuario = '$idUsuariosessao'");
		}
	}
?>
<?php include_once('Styles/Header.css'); ?>

<style>
	#btnSide {
		background: transparent !important;
		border: none;
		cursor: pointer;
		outline: none;
	}
</style>
<div class="bodyHeader" id="bodyHeader">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Armata">
    <header id="header">
        <div class="header-content">
            <span style="--corSVG: var(--cor3); height: 100%; cursor: pointer" onclick="location.href='../inicio.php'"><?php include('imagens/logo-justbookin.svg'); ?></span>
            <div class="btns">
				<?php if ($logado == 1) { ?>
					<!-- Conteúdo relacionado ao usuário logado, se necessário -->
						<button class="btnPub" onclick="location.href='publicarObraP1.php'"><?php include('imagens/Livro.svg'); ?>Publicar obra</button>
						<button class="btnSide" id="btnSide"><?php include('imagens/tracos.svg'); ?></button>
				<?php } else { ?>
					<button class="btnLog" onclick="location.href='login'" id="btnLogin">Login</button>
				<?php } ?>
			</div>
        </div>
    </header>
    <div class="container">
        <?php if ($logado == 1) { ?>
        <div class="sidebar" id="sidebar">
            <ul>
                <li class="li1"><a href="#">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="width: 40px; height: 40px; background: var(--cor3); border-radius: 5px; display: flex; justify-content: center; align-items: center;">
                            <div style="width: 26.25px; height: 30px; background: url('imagens/Vector.svg') center/contain no-repeat;"></div>
                        </div>
                        <div style="flex: 1; display: flex; flex-direction: column; align-items: flex-end;">
                            <div onclick="location.href='perfil.php'" style="color: var(--cor4Escuro); font-size: 20px; font-family: Arimo; font-weight: 400;"><?php echo $dadosLogin['nomeUsuario']; ?></div>
                            <div onclick="location.href='login/logoff.php'" style="color: var(--cor4Escuro); font-size: 16px; font-family: Arimo; font-weight: 400;">Sair da conta</div>
                        </div>
                        <div style="width: 62.5px; height: 62.5px; background: var(--cor4Escuro); border-radius: 50%; display: flex; justify-content: center; align-items: center;" onclick="location.href='perfil.php'">
                            <img style="width: 62.5px; height: 62.5px; border-radius: 50%;" src="<?php echo $urlFotoPerfil; ?>" />
                        </div>
                    </div>
                </a></li>
                <li class="li1"><a href="favoritos.php" class="btnFav" style="color: var(--cor4Escuro);">Obras Favoritas</a></li>
                <li class="li1"><a href="historico.php" class="btnHis" style="color: var(--cor4Escuro);">Histórico</a></li>
                <li class="li1"><a href="inscricao.php" class="btnIns" style="color: var(--cor4Escuro);">Inscrições</a>   
				<?php
					while($dadosUsuarioSeguido=mysqli_fetch_array($queryUsuarioSeguido))
					{
						if ($dadosUsuarioSeguido['urlFotoPerfil'] == "")
							{$img = "imagens/User.png";}else{$img = "fotosPerfil/" . $dadosUsuarioSeguido['urlFotoPerfil'];}
						?>
						<a class="aSeguidos" href="perfil.php?i=<?php echo sha1($dadosUsuarioSeguido['idUsuarioSeguido']); ?>">
						<label class="lblSeguidos"><span class="SpanUserSeguido"><img class="imgUserSeguido" src="<?php echo $img; ?>"></span></label>
						<div class="divInscricao"><?php echo $dadosUsuarioSeguido['nomeUsuario']; ?></div>
						</a>
						
						<?php 
					} 
				}?>
            </ul>
        </div>
        
		<!-- Lógica para a sidebar manter-se sempre encostada no header -->
		<script>
		function atualizarTopSidebar() {
			const header = document.getElementById('header');
			const sidebar = document.getElementById('sidebar');

			const alturaHeader = window.getComputedStyle(header).height;

			sidebar.style.top = alturaHeader;
		}
		
		atualizarTopSidebar();
		
		window.addEventListener('resize', atualizarTopSidebar);
		</script>
		
        <main>
            <!-- Conteúdo principal da página -->
        </main>
    </div>

</div><!--bodyHeader-->
<?php if ($logado == 1) { ?>
	    <script>
        const toggleSidebarButton = document.getElementById('btnSide');
        const sidebar = document.getElementById('sidebar');

        toggleSidebarButton.addEventListener('click', () => {
            if (sidebar.style.width === '250px') {
                sidebar.style.width = '0';
            } else {
                sidebar.style.width = '250px';
            }
        });
    </script>
<?php } ?>