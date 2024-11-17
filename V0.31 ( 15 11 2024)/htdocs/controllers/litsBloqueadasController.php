<?php

include_once('adm/Vadm.php');
include_once('configs.php');

include_once('models/litsBloqueadasModel.php');
	
$dadosLit = getLits();
	
$_SESSION['rota'] = true;
include_once('adm/litsBloqueadas.php');
unset($_SESSION['rota']);
?>