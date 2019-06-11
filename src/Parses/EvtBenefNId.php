<?php


namespace NFePHP\EFDReinf\Parses;

/**
 * 
 */

use NFePHP\EFDReinf\Parses\Parse;
use stdClass;

class EvtBenefNId extends Parse{

	public function convert(){

		$this->obParsed->config = new stdClass();

		$this->obParsed->config->eventoVersion = $this->eventoVersion;

		$this->obParsed->config->serviceVersion = $this->serviceVersion;

		$this->obParsed->modo = $this->ob[0][1];
    	
    	$this->obParsed->idEvento = $this->ob[0][3];

		$this->obParsed->config->empregador = new stdClass();

		$this->obParsed->config->transmissor = $this->obParsed->config->empregador;

    	$this->obParsed->ideEvento = new stdClass();

    	$this->obParsed->ideEvento->indretif = $this->ob[1][1];

    	$this->obParsed->ideEvento->nrrecibo = $this->ob[1][2];

		$this->obParsed->ideEvento->perApur = $this->ob[1][3];

		$this->obParsed->config->empregador->ideEvento->nmRazao = $this->ob[1][4];

		$this->obParsed->config->ideEvento->tpAmb = $this->ob[1][5];

		$this->obParsed->config->ideEvento->procEmi = $this->ob[1][6];

		$this->obParsed->config->ideEvento->verProc = $this->ob [1][7];

		$this->obParsed->ideContri = new stdClass();

		$this->obParsed->ideContri->empregador->tpInsc = $this->ob[1][8];

		$this->obParsed->ideContri->empregador->nrInsc = $this->ob[1][9];

		$this->obParsed->ideEstab = new stdClass();

		$this->obParsed->ideEstab->tpInscEstab = $this->ob[1][10];

		$this->obParsed->ideEstab->nrInscEstab = $this->ob[1][11];

		$index = 2;

        $lastIdeEstab = null;

        $this->obParsed->ideestab = array();

        for ($i = $index; $i < count($this->ob); $i++){
            
            $auxOb = $this->ob[$i];

            $cabecario = $auxOb[0];

            if ($cabecario == 'IDENAT'){

                $aux = new stdClass();

                $aux->natRendim =  $auxOb[1];

                $this->obParsed->ideestab[] = $aux;

                $lastIdeEstab =  $aux;

            } else if ($cabecario == 'INFOPGTO'){

            	$aux = new stdClass();

            	if (!isset($lastIdeEstab->infopgto)){

            		$lastIdeEstab->infopgto = array();

            	}

            	$aux->dtFG = $auxOb[1];

            	$aux->vlrLiq = $auxOb[2];

            	$aux->vlrReaj = $auxOb[3];

            	$aux->vlrIR = $auxOb[4];

            	$aux->descr = $auxOb[5];

            	$lastIdeEstab->infopgto[] = $aux;

            	$lastInfoPgto = $aux;

            }

        }

		return $this->obParsed;

	}

}

?>