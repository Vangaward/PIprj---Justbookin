<?php

include_once('adm/Vadm.php');
include_once('configs.php');

function getEditoras()
{
	global $conexao, $dirFotoPerfil;
	$stmt = mysqli_prepare($conexao, "SELECT * FROM usuario WHERE tipoConta = 2;");
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	
	$dadosEditoras = mysqli_fetch_all($result, MYSQLI_ASSOC);

	// Processa cada literatura para adicionar a imagem correta e gerar o hash do ID
	foreach ($dadosEditoras as &$editora) {
	    if ($editora['urlFotoPerfil'])
		{
			$editora['img'] = "../" . $dirFotoPerfil . $editora['urlFotoPerfil'];
		} else {
			$editora['img'] = "../imagens/batata.png";
		}

        $editora['idUsuario'] = sha1($editora['idUsuario']);
    }
	/*var_dump($dadosEditoras[0]['img']);
    die();*/
	return $dadosEditoras;
}

?>