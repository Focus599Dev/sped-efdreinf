<?php


namespace NFePHP\EFDReinf\Parses;

/**
 * 
 */

use NFePHP\EFDReinf\Parses\Parse;
use stdClass;

class EvtAqProd extends Parse{

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

        $this->obParsed->tpInscAdq = $this->ob[1][8];

        $this->obParsed->nrInscAdq = $this->ob[1][9];

        $this->obParsed->tpInscProd = $this->ob[1][10];

        $this->obParsed->nrInscProd = $this->ob[1][11];

        $this->obParsed->indOpcCP = $this->ob[1][12];
		
		$index = 2;

		$lastInfoPgto = null;

		$lastIdeNat = null;

		$lastInfoProcJud = null;

		$lastDespProcJud = null;

		$lastIdePgto = null;

		$lastDetaquis = null;

        for ($i = $index; $i < count($this->ob); $i++){
            
            $auxOb = $this->ob[$i];

            $cabecario = $auxOb[0];

            if ($cabecario == 'DETAQUIS'){

                $aux = new stdClass();

                $aux->indAquis =  $auxOb[1];

                $aux->vlrBruto =  $auxOb[2];

                $aux->vlrCPDescPR =  $auxOb[3];

                $aux->vlrRatDescPR =  $auxOb[4];

                $aux->vlrSenarDesc =  $auxOb[5];

                $this->obParsed->detaquis[] = $aux;

                $lastDetaquis =  $aux;

            } else if ($cabecario == 'INFOPROCJUD'){

            	$aux = new stdClass();

            	if (!isset($lastDetaquis->infoProcJud)){

            		$lastDetaquis->infoProcJud = array();

            	}

            	$aux->nrProcJud = $auxOb[1];

            	$aux->codSusp = $auxOb[2];

            	$aux->vlrCPNRet = $auxOb[3];

            	$aux->vlrRatNRet = $auxOb[4];

            	$aux->vlrSenarNRet = $auxOb[5];

            	$lastDetaquis->infoProcJud [] = $aux;

            } 

        }

		return $this->obParsed;

	}

}

?>