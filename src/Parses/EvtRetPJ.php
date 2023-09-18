<?php


namespace NFePHP\EFDReinf\Parses;

/**
 * 
 */

use NFePHP\EFDReinf\Parses\Parse;
use stdClass;

class EvtRetPJ extends Parse{

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

		$lastIdeBenef = null;

		$lastInfoProcJud = null;

		$lastDespProcJud = null;

		$lastIdePgto = null;

		$lastideOpSaude = null;

		$this->obParsed->infoPgto = array();

		for ($i = $index; $i < count($this->ob); $i++){

			$auxOb = $this->ob[$i];

			$cabecario = $auxOb[0];

			if ($cabecario == 'IDEBENEF'){

				$aux = new stdClass();

				$aux->cnpjBenef = $auxOb[1];

				$aux->nmBenef = $auxOb[2];

				$aux->isenImun = $auxOb[3];

				$aux->ideEvtAdic = $auxOb[4];

				$this->obParsed->idebenef = $aux;

				$lastIdeBenef = $aux;

			} else if ($cabecario == 'IDEPGTO'){

				$aux = new stdClass();

				if (!isset($lastIdeBenef->idepgto)){

					$lastIdeBenef->idepgto = array();

				}

				$aux->natRend = $auxOb[1];

				$aux->observ = $auxOb[2];

				$lastIdeBenef->idepgto[] = $aux;

				$lastIdePgto = $aux;

			} else if ($cabecario == 'INFOPGTO'){

				$aux = new stdClass();

				if (!isset($lastIdePgto->infopgto)){

					$lastIdePgto->infopgto = array();

				}

				$aux->dtFG = $auxOb[1];

				$aux->vlrBruto = $auxOb[2];

				$aux->indFciScp = $auxOb[3];

				$aux->nrInscFciScp = $auxOb[4];

				$aux->percSCP = $auxOb[5];

				$aux->indJud = $auxOb[6];

				$aux->paisResidExt = $auxOb[7];

				$aux->dtEscrCont = $auxOb[8];
				
				$aux->observ = $auxOb[9];

				if ($auxOb[10] || $auxOb[11] || $auxOb[12] || $auxOb[13] || $auxOb[14] || $auxOb[15] || $auxOb[16] || $auxOb[17] || $auxOb[18] || $auxOb[19] ){

					$aux->retencoes = new stdClass();

					$aux->retencoes->vlrBaseIR = $auxOb[10];

					$aux->retencoes->vlrIR = $auxOb[11];

					$aux->retencoes->vlrBaseAgreg = $auxOb[12];

					$aux->retencoes->vlrAgreg = $auxOb[13];

					$aux->retencoes->vlrBaseCSLL = $auxOb[14];

					$aux->retencoes->vlrCSLL = $auxOb[15];

					$aux->retencoes->vlrBaseCofins = $auxOb[16];

					$aux->retencoes->vlrCofins = $auxOb[17];

					$aux->retencoes->vlrBasePP = $auxOb[18];

					$aux->retencoes->vlrPP = $auxOb[19];
				
				}

				$lastIdePgto->infopgto[] = $aux;

				$lastInfoPgto = $aux;

			} else if ($cabecario == 'INFOPROCRET'){

				$aux = new stdClass();

				if (!isset($lastInfoPgto->infoprocret)){

					$lastInfoPgto->infoprocret = array();

				}

				$aux->tpProcRet = $auxOb[1];

				$aux->nrProcRet = $auxOb[2];

				$aux->codSusp = $auxOb[3];

				$aux->vlrBaseSuspIR = $auxOb[4];

				$aux->vlrNIR = $auxOb[5];

				$aux->vlrDepIR = $auxOb[6];

				$aux->vlrBaseSuspCSLL = $auxOb[7];

				$aux->vlrNCSLL = $auxOb[8];

				$aux->vlrDepCSLL = $auxOb[9];

				$aux->vlrBaseSuspCofins = $auxOb[10];

				$aux->vlrNCofins = $auxOb[11];

				$aux->vlrDepCofins = $auxOb[12];

				$aux->vlrBaseSuspPP = $auxOb[13];

				$aux->vlrNPP = $auxOb[14];

				$aux->vlrDepPP = $auxOb[15];

				$lastInfoPgto->infoprocret[] = $aux;
			
			} else if ($cabecario == 'INFOPROCJUD'){

				$aux = new stdClass();

				if (!isset($lastInfoPgto->infoProcJud)){

					$lastInfoPgto->infoProcJud = new stdClass();

				}

				$aux->nrProc = $auxOb[1];

				$aux->indOrigRec = $auxOb[2];

				$aux->cnpjOrigRecurso = $auxOb[3];

				$aux->desc = $auxOb[4];

				$aux->vlrDespCustas = $auxOb[5];

				$aux->vlrDespAdvogados = $auxOb[6];

				$lastInfoPgto->infoProcJud = $aux;

				$lastInfoProcJud = $aux;

			} else if ($cabecario == 'INFOPROCJUDAD'){

				$aux = new stdClass();

				if (!isset($lastInfoProcJud->infoProcJud)){

					$lastInfoProcJud->infoProcJud =  new stdClass();

					if (!isset($lastInfoProcJud->infoProcJud->ideadv)){
						$lastInfoProcJud->infoProcJud->ideadv = array();
					}

				}


				$aux->tpInscAdv = $auxOb[1];

				$aux->nrInscAdv = $auxOb[2];

				$aux->vlrAdv = $auxOb[3];

				$lastInfoProcJud->infoProcJud->ideadv[] = $aux;

			} else if ($cabecario == 'INFOPGTOEXT'){

				$aux = new stdClass();

				if(!isset($lastIdePgto->infoPgto->infoPgtoExt)){

					$lastIdePgto->infoPgto->infoPgtoExt = new stdClass();

				}

				$aux->indNIF = $auxOb[1];

				$aux->nifBenef = $auxOb[2];

				$aux->frmTribut = $auxOb[3];

				if ($$auxOb[4] ||$auxOb[5] || $auxOb[6] || $auxOb[7] || $auxOb[8] || $auxOb[9]){
					$aux->endExt = new stdClass();

					$aux->endExt->dscLograd = $auxOb[5];
					
					$aux->endExt->nrLograd = $auxOb[6];

					$aux->endExt->complem = $auxOb[7];

					$aux->endExt->bairro = $auxOb[8];

					$aux->endExt->cidade = $auxOb[9];

					$aux->endExt->estado = $auxOb[10];

					$aux->endExt->codPostal = $auxOb[11];
					
					$aux->endExt->telef = $auxOb[12];

				}

				$lastIdePgto->infoPgto->infoPgtoExt = $aux;

			}  else if ($cabecario == 'IDEOPSAUDE'){

				$aux = new stdClass();

				if(!isset($lastIdePgto->infoPgto->ideOpSaude)){

					$lastIdePgto->infoPgto->ideOpSaude = array();

				}

				$aux->nrInsc = $auxOb[1];

				$aux->regANS = $auxOb[2];

				$aux->vlrSaude = $auxOb[3];

				$lastIdePgto->infoPgto->ideOpSaude = $aux;

				$lastideOpSaude = $aux;
			} else if ($cabecario == 'INFOREEMB'){

				$aux = new stdClass();

				if(!isset($lastideOpSaude->infoReemb)){

					$lastideOpSaude->infoReemb = array();

				}

				$aux->tpInsc = $auxOb[1];

				$aux->nrInsc = $auxOb[2];

				$aux->vlrReemb = $auxOb[3];

				$aux->vlrReembAnt = $auxOb[4];

				$aux->vlrReembAnt = $auxOb[4];

				$lastideOpSaude->infoReemb[] = $aux;

			} else if ($cabecario == 'INFODEPENDPL'){

				$aux = new stdClass();

				if(!isset($lastideOpSaude->infoDependPl)){

					$lastideOpSaude->infoDependPl = array();

				}

				$aux->cpfDep = $auxOb[1];

				$aux->vlrSaude = $auxOb[2];

				$lastideOpSaude->infoDependPl[] = $aux;

				$lastinfoDependPl = $aux;

			} else if ($cabecario == 'INFOREEMBDEP'){

				$aux = new stdClass();

				if(!isset($lastinfoDependPl->infoReembDep)){

					$lastinfoDependPl->infoReembDep = array();

				}

				$aux->tpInsc = $auxOb[1];

				$aux->nrInsc = $auxOb[2];

				$aux->vlrReemb = $auxOb[3];

				$aux->vlrReembAnt = $auxOb[4];

				$lastinfoDependPl->infoReembDep[] = $aux;

			}

		}

		return $this->obParsed;

	}

}
?>