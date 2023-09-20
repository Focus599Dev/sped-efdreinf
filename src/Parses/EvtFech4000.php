<?php

namespace NFePHP\EFDReinf\Parses;


/**
 *
 */


use NFePHP\EFDReinf\Parses\Parse;
use stdClass;

class EvtFech4000 extends Parse{

	public function convert(){

		$this->obParsed->config = new stdClass();

		$this->obParsed->modo = $this->ob[0][1];
    	
    	$this->obParsed->idEvento = $this->ob[0][3];
		
        $this->obParsed->nrrecibo = $this->ob[1][0];

    	$this->obParsed->config->tpAmb = $this->ob[1][1];
    	
    	$this->obParsed->config->verProc = $this->ob[1][3];

    	$this->obParsed->config->eventoVersion = $this->eventoVersion;
        
        $this->obParsed->config->serviceVersion = $this->serviceVersion;
    	
    	$this->obParsed->config->empregador = new stdClass();
    	
    	$this->obParsed->config->empregador->tpInsc = $this->ob[1][4];

    	$this->obParsed->config->empregador->nrInsc = $this->ob[1][5];

    	$this->obParsed->config->transmissor = $this->obParsed->config->empregador;

        $this->obParsed->config->empregador->nmRazao = $this->ob[1][6];

        $this->obParsed->perapur = $this->ob[1][7];

		$index = 2;

		for ($i = $index; $i < count($this->ob); $i++){

			$auxOb = $this->ob[$i];

            $cabecario = $auxOb[0];

            if ($cabecario == 'IDERESPINF'){

            	$aux = new stdClass();

            	$aux->nmResp =  $auxOb[1];

            	$aux->cpfResp =  $auxOb[2];

            	$aux->telefone =  $auxOb[3];

            	$aux->email =  $auxOb[4];

            	$this->obParsed->ideRespInf = $aux;

            } else if ($cabecario == 'INFOFECH'){


            	$this->obParsed->fechRet =  $auxOb[1];

            }

		}

		return $this->obParsed;

	}
}