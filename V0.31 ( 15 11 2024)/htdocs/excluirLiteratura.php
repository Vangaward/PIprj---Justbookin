<?php include_once('forcaRota.php'); ?>

<html lang="pt-br">

<head>

<title>Excluir Literatura|JustBookIn</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php include_once('b.php'); ?>

</head>
<?php include_once('Styles/excluirLiteratura.css'); ?>
<body>

<?php if ($erro != null){ ?>
			<div style="animation-name: Rotacao3d; animation-duration: 1s;" class="alert alert-danger shadow"><div class="divErro"><?php echo $erro; ?></div></div>
<?php } ?>

<form action="BDexcluirLiteratura.php?i=<?php echo $idLitSha1; ?>" method="post">
	<div class="container">

		<input type="hidden" name="tokenFrmDeletarLit" value="<?php echo $_SESSION['TSFDeletarLit']; ?>">
		<label>Você está prestes a excluir PERMANENTEMENTE sua literatura</label>

		<label>(<?php echo $dadosLit['titulo']; ?>)</label>

		<label>Digite sua senha para confirmar a exclusão:</label>

		<input type="password" name="senhaName" id="senhaid" required>

		<input type="submit" name="excLitName" value="confirmar exclusão">

	</div>

</body>

</html>

<script language="Javascript">

    function verSenha ()
    {
        var senha1 = document.getElementById("senhaid");
        
        if (senha1.type == "password")
        {
            senhaid.type = ("text");
        }
        else
        {
            senhaid.type = ("password");
        }
    }
    
</script>