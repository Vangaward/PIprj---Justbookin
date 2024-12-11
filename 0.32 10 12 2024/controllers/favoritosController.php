<?

require_once('models/favoritosModel.php');

include_once("conexao.php");
include_once('Vlogin.php');
include_once('rsnl.php');

$idUsuario = $dadosLogin['idUsuario'];

list($dadosLit, $qtdFavs, $txtQtdFavs) = buscaFav($idUsuario);

$_SESSION['rota'] = true;
require_once "favoritos.php";
unset($_SESSION['rota']);

?>