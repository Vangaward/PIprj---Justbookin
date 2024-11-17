<?php

include_once('adm/Vadm.php');

$_SESSION['rota'] = true;
include_once('adm/painelControle.php');
unset($_SESSION['rota']);

?>