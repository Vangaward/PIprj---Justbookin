<?php

session_start();

// Captura a URL completa com os parâmetros
$requestUri = $_SERVER['REQUEST_URI']; 

// Remove a query string para comparar apenas o caminho
$requestUri = strtok($requestUri, '?');

// Captura apenas os parâmetros da URL (parte após o '?')
$queryString = $_SERVER['QUERY_STRING'];

// Converte os parâmetros em um array associativo
parse_str($queryString, $params);

//Configurações de parâmetros
/*$iPar = null; // parâmetro 'i'
$iSearch = null;
if (isset($params['i'])) { 
	$iPar = $params['i']; 
}
if (isset($params['search'])) {
	$iSearch = $params['search'];
}	*/

// Define os controladores com base no caminho da URL
switch ($requestUri)
{
    case '/':
        require 'controllers/inicioController.php';
        /*$controller = new InicioController();
        $controller->index();*/
        break;

    case '/perfil':
        require 'controllers/perfilController.php';
        /*$controller = new PerfilController();
        $controller->index($iPar); // Passa o parâmetro, se existir*/
        break;
	case '/busca':
		require 'controllers/buscaController.php';
		break;
		
		case '/livro':
		require 'controllers/livroController.php';
		break;

    default:
        require 'controllers/inicioController.php';
        /*$controller = new InicioController();
        $controller->index();*/
        break;
}
?>