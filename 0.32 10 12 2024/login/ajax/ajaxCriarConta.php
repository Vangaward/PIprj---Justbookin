<?php

/*if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest')
{
    exit('403 Acesso proibido');
}*/

include_once('../../conexao.php');
include_once('../../Vlogin.php');

$nomeUsuario = $_GET['n'];
$emailUsuario = $_GET['e'];
$usuarioExiste = false;
$emailExiste = false;

/////////////////Nome de Usuario//////////////
$stmt = $conexao->prepare("SELECT * FROM usuario WHERE nomeUsuario = ?");
$stmt->bind_param("s", $nomeUsuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $usuarioExiste = true;
}
$stmt->close();

////////////////Email/////////////////////////
$stmt = $conexao->prepare("SELECT * FROM usuario WHERE email = ?");
$stmt->bind_param("s", $emailUsuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $emailExiste = true;
}
$stmt->close();
////////////////////////////////////////

/*Resposta Ajax*/
$respostaAjax = array(
	'nomeUsuarioExiste' => $usuarioExiste,
	'emailExistente' => $emailExiste,
);

// Retorna os dados codificados em JSON
echo json_encode($respostaAjax);
?>