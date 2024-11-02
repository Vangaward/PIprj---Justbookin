<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest')
{
    exit('Acesso proibido');
}

include_once('../conexao.php');
include_once('../Vlogin.php');
include_once('../Vcli.php');
include_once('../helperBD.php');

$search = $_GET['search'];

$queryLit = "SELECT l.idLit, l.idLit, l.titulo, l.urlCapa, u.nome
 FROM Literatura l
INNER JOIN usuario u ON l.idUsuario = u.idUsuario
where l.titulo like '%$search%' and l." . $litBloqOuPriv . " or l.descricao like '%$search%' and l." . $litBloqOuPriv;

$resultado = mysqli_query($conexao, $queryLit);

// Inicializa um array para armazenar os resultados
$dadosLitArray = array();

// Loop através dos resultados e adiciona cada linha ao array
while ($dadosLit = mysqli_fetch_array($resultado)) {
    $dadosLitArray[] = array(
        'titulo' => $dadosLit['titulo'],
        'nome' => $dadosLit['nome'],
        'urlCapa' => $dadosLit['urlCapa'],
		'idLitSha1' => sha1($dadosLit['idLit']),
    );
}

// Fecha a conexão com o banco de dados
mysqli_close($conexao);

// Retorna os resultados como JSON
echo json_encode($dadosLitArray);
?>
