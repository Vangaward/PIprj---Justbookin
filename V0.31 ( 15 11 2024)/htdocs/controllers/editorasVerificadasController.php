<?php

include_once('models/editorasVerificadasModel.php');
	
$dadosEditoras = getEditoras();

$_SESSION['rota'] = true;
require_once "adm/editorasVerificadas.php";
unset($_SESSION['rota']);

?>