<?

require_once '../classes/Cripto.php';
session_start();
include_once('../conexao.php');
date_default_timezone_set('America/Sao_Paulo');

if (isset($_POST["btnEsqueciSenha"]))
{
	if ($_POST['tokenFrmReSe'] != $_SESSION['TSFReSe'])
	{
		$_SESSION['marcaPagina'] = 1;
		$_SESSION['telaLoginErro'] = "<li>Houve um problema com o token, tente novamente!</li>";
		$_SESSION['mostrarErro'] = 1;
		header("Location: index.php");
		die();
	}
	
	$emailES = $_POST['emailRedefineSenha']; // ES = Esqueci a Senha

	$stmt = $conexao->prepare("SELECT * FROM usuario WHERE email = ?");
	$stmt->bind_param("s", $emailES);
	$stmt->execute();

	$resultado = $stmt->get_result();
	$dadosES = $resultado->fetch_assoc();
	$num_linhas = $resultado->num_rows;
	
	$stmt->close();
	$conexao->close();
	
	if ($num_linhas > 0)
	{
?>
	<script>
	var confirmacao = confirm("Deseja que um link para redefinição de senha seja enviado para o email: <?php echo $dadosES['email']; ?>? Se o E-mail realmente estiver cadastrado um link para redefinição de senha será enviado.");
	if (confirmacao)
	{
		window.location.href = "verificaEmailEsqueciSenha.php?i=<?php echo (new Cripto($dadosES['idUsuario']))->getCripto(); ?>";
		document.write("Aguarde...");
	}
	else
		window.location = 'index.php';
	</script>
	<?php
	}else {
		?>
			<script>
				alert("Se o email existir, uma mensagem para redefinição de senha será enviada.");
				window.location = 'index.php';
			</script>
		<?
	}
}
?>