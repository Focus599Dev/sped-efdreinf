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

        $this->obParsed->indretif = $this->ob[1][8];

        $this->obParsed->perapur = $this->ob[1][7];

		$this->obParsed->ideEstab = new stdClass();

		$this->obParsed->ideEstab->tpInscEstab = $this->ob[1][9];

		$this->obParsed->ideEstab->nrInscEstab = $this->ob[1][10];
		
		$this->obParsed->ideEstab->natJur = $this->ob[1][11];

		$index = 2;

		$lastInfoPgto = null;

		$lastIdeNat = null;

		$lastInfoProcJud = null;

		$lastDespProcJud = null;

		$lastIdePgto = null;

		$lastideOpSaude = null;

        for ($i = $index; $i < count($this->ob); $i++){
            
            $auxOb = $this->ob[$i];

            $cabecario = $auxOb[0];

            if ($cabecario == 'IDENAT'){

                $aux = new stdClass();

                $aux->natRend =  $auxOb[1];

                $this->obParsed->ideestab[] = $aux;

                $lastIdeNat =  $aux;

            } else if ($cabecario == 'INFOPGTO'){

            	$aux = new stdClass();

            	if (!isset($lastIdeNat->infoPgto)){

            		$lastIdeNat->infoPgto = array();

            	}

            	$aux->dtFG = $auxOb[1];

            	$aux->vlrLiq = $auxOb[2];

            	$aux->vlrBaseIR = $auxOb[3];

            	$aux->vlrIR = $auxOb[4];

            	$aux->dtEscrCont = $auxOb[5];

            	$aux->descr = $auxOb[6];

            	$lastIdeNat->infoPgto[] = $aux;

            	$lastInfoPgto = $aux;

            } else if ($cabecario == 'INFOPROCRET'){

            	$aux = new stdClass();

            	if (!isset($lastInfoPgto->infoProcRet)){

            		$lastInfoPgto->infoProcRet = array();

            	}

            	$aux->tpProcRet = $auxOb[1];

            	$aux->nrProcRet = $auxOb[2];

            	$aux->codSusp = $auxOb[3];

            	$aux->vlrBaseSuspIR = $auxOb[4];

            	$aux->vlrNIR = $auxOb[5];

            	$aux->vlrDepIR = $auxOb[6];

            	$lastInfoPgto->infoProcRet[] = $aux;

            	$lastInfoPgto = $aux;

            }

        }

		return $this->obParsed;

	}

}

?>