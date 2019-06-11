<?php 

namespace NFePHP\EFDReinf\Parses;

/**
*
*/

use NFePHP\EFDReinf\Parses\Parse;
use stdClass;

class EvtTotalContrib extends Parse {

	public function convert(){

		$this->obParsed->config = new stdClass();

		$this->obParsed->config->empregador = new stdClass();

		$this->obParsed->config->transmissor = $this->obParsed->config->empregador;

		$this->obParsed->modo = $this->ob[0][1];

        $this->obParsed->idEvento = $this->ob[0][3];

        $this->obParsed->ideEvento = new stdClass();

		$this->obParsed->config->empregador->ideEvento->nmRazao = $this->ob[1][1];

		$this->obParsed->config->ideEvento->perRef = $this->ob[1][2];

		$this->obParsed->ideContri = new stdClass();

		$this->obParsed->ideContri->tpInsc = $this->ob[1][3];

		$this->obParsed->ideContri->nrInsc = $this->ob[1][4];

		$this->obParsed->ideRecRetorno = new stdClass();

		$this->obParsed->ideRecRetorno->idestatus = new stdClass();

		$this->obParsed->idestatus->cdRetorno = $this->ob[2][1];

		$this->obParsed->idestatus->descRetorno = $this->ob[2][2];

		$index = 2;

		$lastRecOcorrs = null;

		$lastRTom = null;

		$lastInfoTotalContrib = null;

		$lastinfoCRTom = null;

		$lastRprest = null;

		$lastRRecRepAD = null;

		$lastRComl = null;

		$lastRCPRB = null;

		$this->obParsed->idestatus = array();

		for ($i = $index; $i < count($this->ob); $i++){

			$auxOb = $this->ob[$i];

			$cabecario = $auxOb[0];

			if ($cabecario == 'REGOCORRS') {

				$aux = new stdClass();

				$aux->tpOcorr = $auxOb[1];

				$aux->localErroAviso = $auxOb[2];

				$aux->codresp = $auxOb[3];

				$aux->dscresp = $auxOb[4];

				$this->obParsed->regocorrs[] = $aux;

				$lastRecOcorrs = $aux;

			} else if ($cabecario == 'INFORECEV') {

				$aux = new stdClass();

				$aux->nrProtEntr = $auxOb[1];

				$aux->dhProcess = $auxOb[2];

				$aux->tpEv = $auxOb[3];

				$aux->idEv = $auxOb[4];

				$aux->hash = $auxOb[5];

				$this->obParsed->inforecev[] = $aux;

			} else if ($cabecario == 'INFOTOTALCONTRIB') {

				$aux = new stdClass();

				$aux->nrRecArqBase = $auxOb[1];

				$aux->indExistInfo = $auxOb[2];

				$this->obParsed->infototalcontrib[] = $aux;

				$lastInfoTotalContrib = $aux;

			} else if ($cabecario == 'RTOM') {

				$aux = new stdClass();

				if(!isset($lastInfoTotalContrib->rtom)){

					$lastInfoTotalContrib->rtom = array();

				}

				$aux->cnpjPrestador = $auxOb[1];

				$aux->cno = $auxOb[2];

				$aux->vlrTotalBaseRet = $auxOb[3];

				$lastInfoTotalContrib->rtom[] = $aux;

				$lastRTom = $aux;

			} else if ($cabecario == 'INFOCRTOM') {

				$aux = new stdClass();

				if(!isset($lastRTom->infocrtom)){

					$lastRTom->infocrtom = array();

				}

				$aux->CRTom = $auxOb[1];

				$aux->vlrCRTom = $auxOb[2];

				$aux->vlrCRTomSusp = $auxOb[3];

				$lastRTom->infocrtom[] = $aux;

				$lastinfoCRTom = $aux;

			} else if ($cabecario == 'RPREST') {

				$aux = new stdClass();

				$aux->tpInscTomador = $auxOb[1];

				$aux->nrInscTomador = $auxOb[2];

				$aux->vlrTotalBaseRet = $auxOb[3];

				$aux->vlrTotalRetPrinc = $auxOb[4];

				$aux->vlrTotalRetAdic = $auxOb[5];

				$aux->vlrTotalNRetPrinc = $auxOb[6];

				$aux->vlrTotalNRetAdic = $auxOb[7];

				$this->obParsed->rprest[] = $aux;

				$lastRprest = $aux;

			} else if ($cabecario == 'RRECREPAD'){

				$aux = new stdClass();

				$aux->CRRecRepAD = $auxOb[1];

				$aux->vlrCRRecRepAD = $auxOb[2];

				$aux->vlrCRRecRepADSusp = $auxOb[3];

				$this->obParsed->rrecrepad[] = $aux;

				$lastRRecRepAD = $aux;

			} else if ($cabecario == 'RCOML') {

				$aux = new stdClass();

				if (!isset($lastRecOcorrs->rcoml)){

					$lastRecOcorrs->rcoml = array();

				}

				$aux->CRComl = $auxOb[1];

				$aux->vlrCRComl = $auxOb[2];

				$aux->vlrCRComlSusp = $auxOb[3];

				$this->obParsed->rcoml[] = $aux;

				$lastRComl = $aux;

			} else if ($cabecario == 'RCPRB') {

				$aux = new stdClass();

				if (!isset($lastRecOcorrs->rcprb)){

					$lastRecOcorrs->rcprb = array();

				}

				$aux->CRCPRB = $auxOb[1];

				$aux->vlrCRCPRB = $auxOb[2];

				$aux->vlrCRCPRBSusp = $auxOb[3];

				$this->obParsed->rcprb[] = $aux;

				$lastRCPRB = $aux;

			}			

		}

		return $this->obParsed;

	}

}

?>