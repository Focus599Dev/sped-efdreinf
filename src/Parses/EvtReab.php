<?php


namespace NFePHP\EFDReinf\Parses;

/**
 * 
 */

use NFePHP\EFDReinf\Parses\Parse;
use stdClass;

class EvtReab extends Parse{

	public function convert(){

		$this->obParsed->config = new stdClass();

		$this->obParsed->config->eventoVersion = $this->eventoVersion;

		$this->obParsed->config->serviceVersion = $this->serviceVersion;

		$this->obParsed->modo = $this->ob[0][1];
    	
    	$this->obParsed->idEvento = $this->ob[0][3];

    	$this->obParsed->ideEvento = new stdClass();

		$this->obParsed->ideEvento->perApur = $this->ob[1][1];

		$this->obParsed->config->empregador = new stdClass();

		$this->obParsed->config->transmissor = $this->obParsed->config->empregador;

		$this->obParsed->config->empregador->ideEvento->nmRazao = $this->ob[1][2];

		$this->obParsed->config->ideEvento->tpAmb = $this->ob[1][3];

		$this->obParsed->config->ideEvento->procEmi = $this->ob[1][4];

		$this->obParsed->config->ideEvento->verProc = $this->ob [1][5];

		$this->obParsed->ideContri = new stdClass();

		$this->obParsed->ideContri->empregador->tpInsc = $this->ob[1][6];

		$this->obParsed->ideContri->empregador->nrInsc = $this->ob[1][7];

		return $this->obParsed;

	}

}
?>