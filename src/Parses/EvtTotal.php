<?php


namespace NFePHP\EFDReinf\Parses;

/**
*
*/

use NFePHP\EFDReinf\Parses\Parse;
use stdClass;

class EvtTotal extends Parse{

	public function convert(){

		$this->obParsed->config = new stdClass;

		$this->obParsed->config->eventoVersion = $this->eventoVersion;

		$this->obParsed->config->serviceVersion = $this->serviceVersion;

		$this->obParsed->config->empregador = new stdClass();

		$this->obParsed->modo = $this->ob[0][1];

		$this->obParsed->idEvento = $this->ob[0][3];

		$this->obParsed->ideEvento = new stdClass();

		$this->obParsed->config->ideEvento->empregador->nmRazao = $this->ob[1][1];

		$this->obParsed->ideEvento->perapur = $this->ob[1][2];

		$this->obParsed->ideContri = new stdClass();

		$this->obParsed->ideContri->tpinsc = $this->ob[1][3];

		$this->obParsed->ideContri->nrinsc = $this->ob[1][4];

		$this->obParsed->ideRecRetorno = new stdClass();

		$this->obParsed->ideRecRetorno->ideStatus = new stdClass();

		$this->obParsed->ideStatus->cdretorno = $this->ob[2][1];

		$this->obParsed->ideStatus->descRetorno = $this->ob[2][2];

		$index = 2;

		$lastRecOcorrs = null;

		$lastInfoCRTom = null;

		$lastRRecEspetDesp = null;

		$lastInfoTotal = null;

		$lastIdeEstab = null;

		$lastRCPRB = null;

		$lastRComl = null;

		$lastInfoCRTom = null;

		$lastRTom = null;

		$lastRRecRepAD = null;

		$lastInfoCRTom = null;

		$this->obParsed->idestatus = array();

		for ($i = $index; $i < count($this->ob); $i++){

			$auxOb = $this->ob[$i];

			$cabecario = $auxOb[0];

			if ($cabecario == 'REGOCORRS') {

				$aux = new stdClass();

				$aux->tpocorr = $auxOb[1];

				$aux->localerroaviso = $auxOb[2];

				$aux->codresp = $auxOb[3];

				$aux->dscresp = $auxOb[4];

				$this->obParsed->idestatus[] = $aux;

				$lastRecOcorrs = $aux;

			} else if ($cabecario == 'INFORECEV') {

				$aux = new stdClass();

				$aux->nrprotentr = $auxOb[1];

				$aux->dhprocess = $auxOb[2];

				$aux->tpEv = $auxOb[3];

				$aux->idEv = $auxOb[4];

				$aux->hash = $auxOb[5];

				$this->obParsed->inforecev[] = $aux;

			} else if ($cabecario == 'INFOTOTAL') {

				$aux = new stdClass();

				$aux->nrrecarqbase = $auxOb[1];

				$this->obParsed->infototal[] = $aux;

				$lastInfoTotal = $aux;

			} else if ($cabecario == 'IDEESTAB') {

				$aux = new stdClass();

				if (!isset($lastInfoTotal->ideestab)){
                    
                    $lastInfoTotal->ideestab = array();

                }

				$aux->ideestab = $auxOb[1];

				$aux->ideestab = $auxOb[2];

				$lastInfoTotal->ideestab[] = $aux;

				$lastIdeEstab = $aux;

			} else if ($cabecario == 'RTOM') {

				$aux = new stdClass();

				if (!isset($lastIdeEstab->rtom)){
                    
                    $lastIdeEstab->rtom = array();

                }

                $aux->cnpjprestador = $auxOb[1];

                $aux->cno = $auxOb[2];

                $aux->vlrtotalbaseret = $auxOb[3];

                $lastIdeEstab->rtom[] = $aux;

                $lastRTom = $aux;

			} else if ($cabecario == 'INFOCRTOM') {

				$aux = new stdClass();

				if (!isset($lastRTom->infocrtom)){
                    
                    $lastRTom->infocrtom = array();

                }

                $aux->crtom = $auxOb[1];

                $aux->vlrcrtom = $auxOb[2];

                $aux->vlrcrtomsusp = $auxOb[3];

                $lastRTom->infocrtom[] = $aux;

                $lastInfoCRTom = $aux;

			} else if ($cabecario == 'RPREST') {

				$aux = new stdClass();

				if (!isset($lastIdeEstab->rprest)){
                    
                    $lastIdeEstab->rprest = array();

                }

                $aux->tpinsctomador = $auxOb[1];

                $aux->nrinsctomador = $auxOb[2];

                $aux->vlrtotalbaseret = $auxOb[3];

                $aux->vlrtotalpetprinc = $auxOb[4];

                $aux->vlrtotalretadic = $auxOb[5];

                $aux->vlrtotalnretprinc = $auxOb[6];

                $aux->vlrtotalnretadic = $auxOb[7];

                $lastIdeEstab->rprest[] = $aux;

			} else if ($cabecario == 'RRECREPAD') {

				$aux = new stdClass();

				if (!isset($lastIdeEstab->rrecrepad)){
                    
                    $lastIdeEstab->rrecrepad = array();

                }

                $aux->cnpjassocdesp = $auxOb[1];

                $aux->vlrtotalrep = $auxOb[2];

                $aux->crrecrepad = $auxOb[3];

                $aux->vlrcrrecrepad = $auxOb[4];

                $aux->vlrcrrecrepadsusp = $auxOb[5];

                $lastIdeEstab->rrecrepad[] = $aux;

                $lastRRecRepAD = $aux;

			} else if ($cabecario == 'RCOML') {

				$aux = new stdClass();

				if (!isset($lastIdeEstab->rcoml)){
                    
                    $lastIdeEstab->rcoml = array();

                }

                $aux->crcoml = $auxOb[1];

                $aux->vlrcrcoml = $auxOb[2];

                $aux->vlrcrcomlsusp = $auxOb[3];

                $lastIdeEstab->rcoml[] = $aux;

                $lastRComl = $aux;

			} else if ($cabecario == 'RCPRB') {

				$aux = new stdClass();

				if (!isset($lastIdeEstab->rcprb)){
                    
                    $lastIdeEstab->rcprb = array();

                }

                $aux->CRCPRB = $auxOb[1];

                $aux->vlrCRCPRB = $auxOb[2];

                $aux->vlrCRCPRBSusp = $auxOb[3];

                $lastIdeEstab->rcprb[] = $aux;

                $lastRCPRB = $aux;

			} else if ($cabecario == 'RRECESPETDESP') {

				$aux = new stdClass();

				if (!isset($lastIdeEstab->rrecespetdesp)){
                    
                    $lastIdeEstab->rrecespetdesp = array();

                }

                $aux->CRRecEspetDesp = $auxOb[1];

                $aux->vlrReceitaTotal = $auxOb[2];

                $aux->vlrCRRecEspetDesp = $auxOb[3];

                $aux->vlrCRRecEspetDespSusp = $auxOb[4];

                $lastIdeEstab->rrecespetdesp[] = $aux;

                $lastRRecEspetDesp = $aux;
			
			}
			
		}

		return $this->obParsed;

	}

}

?>