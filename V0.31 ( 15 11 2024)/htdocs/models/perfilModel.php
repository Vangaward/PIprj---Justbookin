<?php

require_once("conexao.php");
require_once("helperBD.php");
require_once("configs.php");
include_once ('Vlogin.php');

function isMeuUsuario($idUsuarioCripto)
{
	global $logado;
	global $dadosLogin;
	$meuUsuario = false;
	$idUsuarioSha1 = $idUsuarioCripto;
	if ($idUsuarioCripto != null) //Não estou acessando meu perfil
	{
		if ($logado == 1)
		{
			if ($idUsuarioCripto != sha1($dadosLogin['idUsuario']))
			{
				$meuUsuario = false;
			}
		}
		if ($logado == 0)
		{
			$meuUsuario = false;
		}
	}
	if ($logado == 1)
	{
		if ($idUsuarioCripto == null) //estou acessando meu perfil com o meu id na url
		{	
			$idUsuarioSha1 = sha1($dadosLogin['idUsuario']);//estou acessando meu perfil sem o meu id na url
			$meuUsuario = true;
		}
		else if ($idUsuarioCripto == sha1($dadosLogin['idUsuario']))
		{
			$idUsuarioSha1 = sha1($dadosLogin['idUsuario']);
			$meuUsuario = true;
		}
	}
	
	return [$meuUsuario, $idUsuarioSha1];
}

function selectUsuario($idUsuarioSha1)
{
    global $conexao;
    global $dirBanner;
    global $dirFotoPerfil;
    
    $queryUsuario = "SELECT * FROM usuario WHERE sha1(idUsuario) = ?";
    $stmt = mysqli_prepare($conexao, $queryUsuario);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $idUsuarioSha1);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $dadosUsuario = [];
            // Verificar se a obtenção do resultado foi bem-sucedida
            if ($result) {
                // Obter os dados com fetch_array
                $dadosUsuario = mysqli_fetch_array($result);  // Pegar todos os resultados como array associativo

                // Verificar se $dadosUsuario retornou algo
                if (isset($dadosUsuario) && is_array($dadosUsuario))
				{
                    $numRowsqueryUsuario = count($dadosUsuario);
					// Fechar o statement
					mysqli_stmt_close($stmt);

					// Definir URLs de foto de perfil e banner
					$dadosUsuario['urlFotoPerfil'] = $dadosUsuario['urlFotoPerfil'] ? $dirFotoPerfil . $dadosUsuario['urlFotoPerfil'] : "imagens/userPerfil.svg";
					$dadosUsuario['banner'] = $dadosUsuario['urlBanner'] ? $dirBanner . $dadosUsuario['urlBanner'] : "imagens/Banner.svg";
				}else {
					$numRowsqueryUsuario = 0;
				}
            }
        } else {
            echo '<input type="button" onclick="window.location=\'index.php\';" value="Voltar"><br><br>';
            die('<b>Erro ao executar a consulta:</b> ' . mysqli_error($conexao));
        }
    } else {
        echo '<input type="button" onclick="window.location=\'index.php\';" value="Voltar"><br><br>';
        die('<b>Erro ao preparar a consulta:</b> ' . mysqli_error($conexao));
    }

    return [$dadosUsuario, $numRowsqueryUsuario];
}

function selectLits($idUsuarioSha1, $lad, $meuUsuario)
{
	global $conexao;
	global $dirCapa;
	$queryLit = mysqli_query($conexao, "SELECT l.idLit, l.titulo, l.urlCapa, l.status, u.idUsuario, u.nomeUsuario, u.nome
	 FROM Literatura l
	INNER JOIN usuario u ON l.idUsuario = u.idUsuario where sha1(l.idUsuario) = '$idUsuarioSha1' order by l.idLit $lad;
	");
	$qtdlits = mysqli_num_rows($queryLit);
	$dadosLits = mysqli_fetch_all($queryLit, MYSQLI_ASSOC);
	
	foreach ($dadosLits as &$literatura) { // Use a referência (&) para modificar o array original
        $literatura['img'] = $literatura['urlCapa'] ? $dirCapa . $literatura['urlCapa'] : "imagens/batata.png";
		$literatura['idLit'] = sha1($literatura['idLit']);
		
		if ($literatura['status'] == 1 && !$meuUsuario){
			$literatura['titulo'] = "Literatura privada";
			$literatura['img'] = "imagens/batata.png";
		}
		else if ($literatura['status'] == 2 && !$meuUsuario){
			$literatura['titulo'] = "Literatura bloqueada";
			$literatura['img'] = "imagens/batata.png";
		}
		
    }
	
	return[$dadosLits, $qtdlits];
}

function selectSeguidores($dadosUsuario)
{
	global $conexao;
	global $logado;
	global $dadosLogin;
	@$idUsuarioSeguido = $dadosUsuario['idUsuario'];
	$queryQtdSeguidores = mysqli_query($conexao, "SELECT * from seguidos where idUsuarioSeguido = '$idUsuarioSeguido'");
	$qtdeSeguidores = mysqli_num_rows($queryQtdSeguidores);

	/*Verificar se está seguindo*/
	$estaSeguindo = false;
	if ($logado == 1){
		$idUsuarioLogado = $dadosLogin['idUsuario'];
		$queryInscrito = mysqli_query($conexao, "SELECT * from seguidos where idUsuario = '$idUsuarioLogado' && idUsuarioSeguido = '$idUsuarioSeguido'");
		if (mysqli_num_rows($queryInscrito) > 0)
		{$estaSeguindo = true; }
	}
	
	return[$estaSeguindo, $qtdeSeguidores];
}

function showMsg()
{
	if (isset($_SESSION['perfilMsg']))
	{
        $msgErro="";
        if ($_SESSION['perfilMsg'] == 1)
        {
            $msgErro = "A extensão do arquivo não é permitida, selecione apenas arquivos .jpg, .jpeg ou .png";
        }
		if ($_SESSION['perfilMsg'] == 2)
        {
            $msgErro = "O nome do arquivo não deve conter mais de 41 caractes!";
        }
		if ($_SESSION['perfilMsg'] == 3)
        {
            $msgErro = "Pedimos desculpas, houve um erro da nossa parte, por favor, teve novamente!";
        }
		if ($_SESSION['perfilMsg'] == 4)
        {
            $msgErro = "Houve um problema com o token.";
        }
		if ($_SESSION['perfilMsg'] == 5)
        {
            $msgErro = "A conta foi definida como uma Editora com sucesso!";
        }
		if ($_SESSION['perfilMsg'] == 6)
        {
            $msgErro = "A conta foi definida como conta padrão";
        }

		unset($_SESSION['perfilMsg']);
		return $msgErro;
	}
	else
	{ return null; }
}

?>