<?php

class Cripto
{ //Cripto Abreveação de criptografia
    private $valor;
	
    public function __construct($valor)
	{
        $this->valor = $valor;
    }
	
    public function getCripto()
	{
        return sha1($this->valor);
    }
	
	public function getTc() //Get tipo de criptografia
	{
        return "sha1";
    }
}

?>