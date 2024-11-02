<?php
/* Arquivo usado para atualizar a quantidade de visualizações no banco */

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest')
{
    exit('Acesso proibido');
}

include_once('../conexao.php');
include_once('../Vlogin.php');

if (isset($_SESSION['ajaxLeitorViews']))
{
    $idLit = $_SESSION['ajaxLeitorViews'];

    $queryLit = mysqli_prepare($conexao, "SELECT * FROM Literatura WHERE idLit = ?");
    mysqli_stmt_bind_param($queryLit, 'i', $idLit);
    mysqli_stmt_execute($queryLit);

    if (!$queryLit) {
        die("Erro na consulta: " . mysqli_error($conexao));
    }

	mysqli_stmt_close($queryLit);

    $queryUpdateLit = mysqli_prepare($conexao, "UPDATE Literatura SET views = views + 1 WHERE idLit = ?");
    mysqli_stmt_bind_param($queryUpdateLit, 'i', $idLit);
    mysqli_stmt_execute($queryUpdateLit);

    if (mysqli_stmt_errno($queryUpdateLit) !== 0) {
        die("Erro na consulta: " . mysqli_stmt_error($queryUpdateLit));
    }

	mysqli_stmt_close($queryUpdateLit);
	mysqli_close($conexao);
    unset($_SESSION['ajaxLeitorViews']);
}
else
{
	echo 'Não executado';
}
?>