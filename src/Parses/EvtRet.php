<?php

namespace NFePHP\EFDReinf\Parses;

/**
*
*/

use NFePHP\EFDReinf\Parses\Parse;
use stdClass;

class EvtRet extends Parse {


	public function convert(){

		$this->obParsed->config = new stdClass();

		$this->obParsed->config->empregador = new stdClass();

		$this->obParsed->config->transmissor = $this->obParsed->config->empregador;

        $this->obParsed->modo = $this->ob[0][1];

        $this->obParsed->idEvento = $this->ob[0][3];

        $this->obParsed->ideevento = new stdClass();

		$this->obParsed->config->empregador->ideevento->nmRazao = $this->ob[1][1];

		$this->obParsed->config->ideevento->perRef = $this->ob[1][2];

		$this->obParsed->ideContri = new stdClass();

		$this->obParsed->ideContri->tpInsc = $this->ob[1][3];

		$this->obParsed->ideContri->nrInsc = $this->ob[1][4];

		$this->obParsed->ideRecRetorno = new stdClass();

		$this->obParsed->ideRecRetorno->ideStatus = new stdClass();

		$this->obParsed->ideStatus->cdRetorno = $this->ob[2][1];

		$this->obParsed->ideStatus->descRetorno = $this->ob[2][2];

		$index = 2;

        $lastInfoTotal = null;

        $lastIdeEstab = null;

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

				$this->obParsed->ideStatus[] = $aux;

				$lastRegOcorrs = $aux;

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

                $aux->tpInsc = $auxOb[1];

                $aux->nrInsc = $auxOb[2];

                $lastInfoTotal->ideestab[] = $aux;

                $lastIdeEstab = $aux;

			} else if ($cabecario == 'TOTAPURMEN') {

				$aux = new stdClass();

				if (!isset($lastIdeEstab->totApurMen)){
                    
                    $lastIdeEstab->totApurMen = array();

                }

                $aux->CRMen = $auxOb[1];

                $aux->vlrBaseCRMen = $auxOb[2];

                $aux->vlrCRMen = $auxOb[3];

                $aux->vlrBaseCRMenSusp = $auxOb[4];

                $aux->vlrCRMenSusp = $auxOb[5];

                $lastIdeEstab->totApurMen[] = $aux;

                $lastTotApurMen = $aux;

            } else if ($cabecario == 'TOTAPURQUI') {

            	$aux = new stdClass();

				if (!isset($lastIdeEstab->totApurQui)){
                    
                    $lastIdeEstab->totApurQui = array();

                }

                $aux->perApurQui = $auxOb[1];

                $aux->CRQui = $auxOb[2];

                $aux->vlrBaseCRQui = $auxOb[3];

                $aux->vlrCRQui = $auxOb[4];

                $aux->vlrBaseCRQuiSusp = $auxOb[5];

                $aux->vlrCRQuiSusp = $auxOb[6];

                $lastIdeEstab->totApurQui[] = $aux;

                $lastTotApurQui = $aux;

            } else if ($cabecario == 'TOTAPURDEC') {

            	$aux = new stdClass();

				if (!isset($lastIdeEstab->totApurDec)){
                    
                    $lastIdeEstab->totApurDec = array();

                }

                $aux->perApurQui = $auxOb[1];

                $aux->CRQui = $auxOb[2];

                $aux->vlrBaseCRQui = $auxOb[3];

                $aux->vlrCRQui = $auxOb[4];

                $aux->vlrBaseCRQuiSusp = $auxOb[5];

                $aux->vlrCRQuiSusp = $auxOb[6];

                $lastIdeEstab->totApurDec[] = $aux;

                $lastTotApurDec = $aux;

            } else if ($cabecario == 'TOTAPURSEM') {

            	$aux = new stdClass();

				if (!isset($lastIdeEstab->totApurSem)){
                    
                    $lastIdeEstab->totApurSem = array();

                }

                $aux->perApurSem = $auxOb[1];

                $aux->CRSem = $auxOb[2];

                $aux->vlrBaseCRSem = $auxOb[3];

                $aux->vlrCRSem = $auxOb[4];

                $aux->vlrBaseCRSemSusp = $auxOb[5];

                $aux->vlrCRSemSusp = $auxOb[6];

                $lastIdeEstab->totApurSem[] = $aux;

                $lastTotApurSem = $aux;

            } else if ($cabecario == 'TOTAPURDIA') {

            	$aux = new stdClass();

				if (!isset($lastIdeEstab->totApurDia)){
                    
                    $lastIdeEstab->totApurDia = array();

                }

                $aux->perApurDia = $auxOb[1];

                $aux->CRDia = $auxOb[2];

                $aux->vlrBaseCRDia = $auxOb[3];

                $aux->vlrCRDia = $auxOb[4];

                $aux->vlrBaseCRDiaSusp = $auxOb[5];

                $aux->vlrCRDiaSusp = $auxOb[6];

                $lastIdeEstab->totApurDia[] = $aux;

                $lastTotApurDia = $aux;

            }
     
     	}

     	return $this->obParsed;
    
    } 

}
?>