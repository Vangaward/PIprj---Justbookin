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

// Define os controladores com base no caminho da URL
switch ($requestUri)
{
    case '/':
        require 'controllers/inicioController.php';
        break;

    case '/perfil':
        require 'controllers/perfilController.php';
        break;
	case '/busca':
		require 'controllers/buscaController.php';
		break;
		
	case '/livro':
		require 'controllers/livroController.php';
		break;
		
	case '/publicarObraP1':
		require 'controllers/publicarObraP1Controller.php';
		break;
		
	case '/publicarObraP2':
		require 'controllers/publicarObraP2Controller.php';
		break;
	
	case '/editarLivro':
		require 'controllers/editarLivroController.php';
		break;
		
	case '/leitor':
		require 'controllers/leitorController.php';
		break;
		
	case '/favoritos':
		require 'controllers/favoritosController.php';
		break;
		
	case '/inscricao':
		require 'controllers/inscricaoController.php';
		break;
		
	case '/excluirLiteratura':
		require 'controllers/excluirLiteraturaController.php';
		break;
		
	case '/alterarSenha':
		require 'controllers/alterarSenhaController.php';
		break;
		
	case '/adm/painelControle':
		require 'controllers/painelControleController.php';
		break;
		
	case '/adm/litsBloqueadas':
		require 'controllers/litsBloqueadasController.php';
		break;
		
	case '/adm/editorasVerificadas':
		require 'controllers/editorasVerificadasController.php';
		break;
		
	case '/login/index':
		require 'controllers/loginController.php';
		break;

    default:
        require 'controllers/inicioController.php'; //'notFound.php';
        break;
}

?>