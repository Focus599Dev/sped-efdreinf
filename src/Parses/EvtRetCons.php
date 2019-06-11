<?php

namespace NFePHP\EFDReinf\Parses;

/**
*
*/

use NFePHP\EFDReinf\Parses\Parse;
use stdClass;


class EvtRetCons extends Parse {

	public function convert(){

		$this->obParsed->config = new stdClass();

		$this->obParsed->modo = $this->ob[0][1];
    	
    	$this->obParsed->idEvento = $this->ob[0][3];

		$this->obParsed->config->eventoVersion = $this->eventoVersion;
    	
    	$this->obParsed->config->serviceVersion = $this->serviceVersion;

    	$this->obParsed->config->empregador = new stdClass();

    	$this->obParsed->config->transmissor = $this->obParsed->config->empregador;

    	$this->obParsed->ideevento = new stdClass();

    	$this->obParsed->config->empregador->ideevento->nmRazao = $this->ob[1][1];
    	
    	$this->obParsed->ideevento->perapur = $this->ob[1][2];

    	$this->obParsed->ideContri = new stdClass();

    	$this->obParsed->config->empregador->ideContri->tpInsc = $this->ob[1][3];

    	$this->obParsed->config->empregador->ideContri->nrInsc = $this->ob[1][4];

    	$this->obParsed->ideRecRetorno = new stdClass();

		$this->obParsed->ideRecRetorno->ideStatus = new stdClass();

		$this->obParsed->ideStatus->cdRetorno = $this->ob[2][1];

		$this->obParsed->ideStatus->descRetorno = $this->ob[2][2];

		$index = 2;

		$lastRecOcorrs = null;

		$lastInfoTotalContrib = null;

		$lastTotApurMen = null;

		$lastTotApurQui = null;

		$lastTotApurDec = null;

		$lastTotApurSem = null;

		$lastTotApurDia = null;

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

				$this->obParsed->indexistinfo[] = $aux;

				$lastInfoTotalContrib = $aux;

			} else if ($cabecario == 'TOTAPURMEN') {

				$aux = new stdClass();

				if(!isset($lastInfoTotalContrib->totapurmen)){

					$lastInfoTotalContrib->totapurmen = array();

				}

				$aux->CRMen = $auxOb[1];

				$aux->vlrBaseCRMen = $auxOb[2];

				$aux->vlrCRMen = $auxOb[3];

				$aux->vlrBaseCRMenSusp = $auxOb[4];

				$aux->vlrCRMenSusp = $auxOb[5];

				$lastInfoTotalContrib->totapurmen[] = $aux;

				$lastTotApurMen = $aux;

			} else if ($cabecario == 'TOTAPURQUI') {

				$aux = new stdClass();

				if(!isset($lastInfoTotalContrib->totapurqui)){

					$lastInfoTotalContrib->totapurqui = array();

				}

				$aux->perApurQui = $auxOb[1];

				$aux->CRQui = $auxOb[2];

				$aux->vlrBaseCRQui = $auxOb[3];

				$aux->vlrCRQui = $auxOb[4];

				$aux->vlrBaseCRQuiSusp = $auxOb[5];

				$aux->vlrCRQuiSusp = $auxOb[6];

				$lastInfoTotalContrib->totapurqui[] = $aux;

				$lastTotApurQui = $aux;

			} else if ($cabecario == 'TOTAPURDEC') {

				$aux = new stdClass();

				if(!isset($lastInfoTotalContrib->totapurdec)){

					$lastInfoTotalContrib->totapurdec = array();

				}

				$aux->perApurDec = $auxOb[1];

				$aux->CRDec = $auxOb[2];

				$aux->vlrBaseCRDec = $auxOb[3];

				$aux->vlrCRDec = $auxOb[4];

				$aux->vlrBaseCRDecSusp = $auxOb[5];

				$aux->vlrCRDecSusp = $auxOb[6];

				$lastInfoTotalContrib->totapurdec[] = $aux;

				$lastTotApurDec = $aux;

			} else if ($cabecario == 'TOTAPURSEM') {

				$aux = new stdClass();

				if(!isset($lastInfoTotalContrib->totapursem)){

					$lastInfoTotalContrib->totapursem = array();

				}

				$aux->perApurSem = $auxOb[1];

				$aux->CRSem = $auxOb[2];

				$aux->vlrBaseCRSem = $auxOb[3];

				$aux->vlrCRSem = $auxOb[4];

				$aux->vlrBaseCRSemSusp = $auxOb[5];

				$aux->vlrCRSemSusp = $auxOb[6];

				$lastInfoTotalContrib->totapursem[] = $aux;

				$lastTotApurSem = $aux;

			} else if ($cabecario == 'TOTAPURDIA') {

				$aux = new stdClass();

				if(!isset($lastInfoTotalContrib->totapurdia)){

					$lastInfoTotalContrib->totapurdia = array();

				}

				$aux->perApurDia = $auxOb[1];

				$aux->CRDia = $auxOb[2];

				$aux->vlrBaseCRDia = $auxOb[3];

				$aux->vlrCRDia = $auxOb[4];

				$aux->vlrBaseCRDiaSusp = $auxOb[5];

				$aux->vlrCRDiaSusp = $auxOb[6];

				$lastInfoTotalContrib->totapurdia[] = $aux;

				$lastTotApurDia = $aux;

			}

		}

		return $this->obParsed;

	}

}

?>