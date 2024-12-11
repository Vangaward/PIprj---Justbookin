<?php include_once('forcaRota.php'); ?>

<html>

<head>

<title>Alterar Senha|JustBookIn</title>
<?php include_once('b.php'); ?>
<link rel="stylesheet" href="Balacowork/Balacowork.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<?php include_once('Styles/alterarSenha.css'); ?>

<body>

	<?php if ($txtMsg != null){ ?>
		<div style='animation-name: Rotacao3d; animation-duration: 1s; ' class='alert alert-danger' role='alert' id='idDivMsgPerfil'><center><? echo $txtMsg; ?></center></div>
	<? } ?>

		<div class="container">
			<div class="btnAlterarPopUp">
				<h1>Alterar Senha</h1>

				<form method="POST" action="BDalterarSenha.php">
					<input type="hidden" name="tokenFrmAltSenha" value="<?php echo $_SESSION['TSFAltSenha']; ?>">

					<label>Digite sua senha atual:</label>
					<input type="password" name="SenhaAtual" id="idExibirSenhaAtual" required>

					<label>Digite a sua nova senha:</label>
					<input type="password" name="NovaSenha" oninput="validarSenha()" id="idExibirNovaSenha" required>

					<label>Confirme a sua nova senha</label>
					<input type="password" name="ConfirmarSenha" id="idExibirConfirmarSenha" required>

					<label class="lblErro" >
						As senhas devem conter ao menos 8 caracteres e no máximo 20, com ao menos: 1 número, 1 letra maiúscula e minúscula e 1 caractere especial.
					</label>

					<button type="submit">Alterar Senha</button>
				</form>
					<button type="button" onclick="window.location.href = '/perfil';">Voltar</button>

			</div>
		</div>


</body>

</html>

<script language="Javascript" src="js/alterarSenha.js"></script>