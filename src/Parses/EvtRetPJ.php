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

		$this->obParsed->config->eventoVersion = $this->eventoVersion;

		$this->obParsed->config->serviceVersion = $this->serviceVersion;

		$this->obParsed->modo = $this->ob[0][1];

		$this->obParsed->idEvento = $this->ob[0][3];

		$this->obParsed->ideEvento = new stdClass();

		$this->obParsed->ideEvento->indRetif = $this->ob[1][1];

		$this->obParsed->ideEvento->nrRecibo = $this->ob[1][2];

		$this->obParsed->ideEvento->perApur = $this->ob[1][3];

		$this->obParsed->config->transmissor = $this->obParsed->config->empregador;

		$this->obParsed->config->ideEvento->empregador->nmRazao = $this->ob[1][4];

		$this->obParsed->config->ideEvento->tpAmb = $this->ob[1][5];

		$this->obParsed->config->ideEvento->procEmi = $this->ob[1][6];

		$this->obParsed->config->ideEvento->verProc = $this->ob[1][7];

		$this->obParsed->config->empregador = new stdClass();

		$this->obParsed->ideContri = new stdClass();

		$this->obParsed->config->empregador->ideContri->tpInsc = $this->ob[1][8];

		$this->obParsed->config->empregador->ideContri->nrInsc = $this->ob[1][9];

		$this->obParsed->ideEstab = new stdClass();

		$this->obParsed->ideEstab->tpInscEstab = $this->ob[1][10];

		$this->obParsed->ideEstab->nrInscEstab = $this->ob[1][11];

		$index = 2;

		$lastInfoPgto = null;

		$lastIdeBenef = null;

		$lastInfoProcJud = null;

		$lastDespProcJud = null;

		$lastIdePgto = null;

		$this->obParsed->infoPgto = array();

		for ($i = $index; $i < count($this->ob); $i++){

			$auxOb = $this->ob[$i];

			$cabecario = $auxOb[0];

			if ($cabecario == 'IDEBENEF'){

				$aux = new stdClass();

				$aux->cnpjBenef = $auxOb[1];

				$aux->nmBenef = $auxOb[2];

				$aux->isenImun = $auxOb[3];

				$this->obParsed->idebenef[] = $aux;

				$lastIdeBenef = $aux;

			} else if ($cabecario == 'IDEPGTO'){

				$aux = new stdClass();

				if (!isset($lastIdeBenef->idepgto)){

					$lastIdeBenef->idepgto = array();

				}

				$aux->natRend = $auxOb[1];

				$aux->paisResid = $auxOb[2];

				$aux->observ = $auxOb[3];

				$lastIdeBenef->idepgto[] = $aux;

				$lastIdePgto = $aux;

			} else if ($cabecario == 'INFOPGTO'){

				$aux = new stdClass();

				if (!isset($lastIdePgto->infopgto)){

					$lastIdePgto->infopgto = array();

				}

				$aux->dtFG = $auxOb[1];

				$aux->vlrTotalPag = $auxOb[2];

				$aux->vlrTotalCred = $auxOb[3];

				$lastIdePgto->infopgto[] = $aux;

				$lastInfoPgto = $aux;

			} else if ($cabecario == 'IR'){

				$aux = new stdClass();

				if (!isset($lastInfoPgto->ir)){

					$lastInfoPgto->ir = array();

				}

				$aux->vlrBaseIR = $auxOb[1];

				$aux->vlrIR = $auxOb[2];

				$aux->vlrBaseNIR = $auxOb[3];

				$aux->vlrNIR = $auxOb[4];

				$aux->vlrDepIR = $auxOb[5];

				$lastInfoPgto->ir[] = $aux;

			} else if ($cabecario == 'CSLL'){

				$aux = new stdClass();

				if (!isset($lastInfoPgto->csll)){

					$lastInfoPgto->csll = array();

				}

				$aux->vlrBaseCSLL = $auxOb[1];

				$aux->vlrCSLL = $auxOb[2];

				$aux->vlrBaseNCSLL = $auxOb[3];

				$aux->vlrNCSLL = $auxOb[4];

				$aux->vlrDepCSLL = $auxOb[5];

				$lastInfoPgto->csll[] = $aux;

			} else if ($cabecario == 'COFINS'){

				$aux = new stdClass();

				if (!isset($lastInfoPgto->cofins)){

					$lastInfoPgto->csll = array();

				}

				$aux->vlrBaseCofins = $auxOb[1];

				$aux->vlrCofins = $auxOb[2];

				$aux->vlrBaseNCofins = $auxOb[3];

				$aux->vlrNCofins = $auxOb[4];

				$aux->vlrDepCofins = $auxOb[5];

				$lastInfoPgto->cofins[] = $aux;

			} else if ($cabecario == 'PP'){

				$aux = new stdClass();

				if (!isset($lastInfoPgto->pp)){

					$lastInfoPgto->pp = array();

				}

				$aux->vlrBasePP = $auxOb[1];

				$aux->vlrPP = $auxOb[2];

				$aux->vlrBaseNPP = $auxOb[3];

				$aux->vlrNPP = $auxOb[4];

				$aux->vlrDepPP = $auxOb[5];

				$lastInfoPgto->pp[] = $aux;

			} else if ($cabecario == 'FCI'){

				$aux = new stdClass();

				if (!isset($lastInfoPgto->fci)){

					$lastInfoPgto->fci = array();

				}

				$aux->nrInscFCI = $auxOb[1];

				$lastInfoPgto->fci[] = $aux;

			} else if ($cabecario == 'SCP'){

				$aux = new stdClass();

				if (!isset($lastInfoPgto->scp)){

					$lastInfoPgto->scp = array();

				}

				$aux->nrInscSCP = $auxOb[1];

				$aux->percSCP = $auxOb[2];

				$lastInfoPgto->scp[] = $aux;

			} else if ($cabecario == 'INFOPROCRET'){

				$aux = new stdClass();

				if (!isset($lastInfoPgto->infoprocret)){

					$lastInfoPgto->infoprocret = array();

				}

				$aux->infoProcRet = $auxOb[1];

				$aux->tpProcRet = $auxOb[2];

				$aux->nrProcRet = $auxOb[3];

				$aux->codSusp = $auxOb[4];

				$aux->nIR = $auxOb[5];

				$aux->depIR = $auxOb[6];

				$aux->nCSLL = $auxOb[7];

				$aux->depCSLL = $auxOb[8];

				$aux->nCofins = $auxOb[9];

				$aux->depCofins = $auxOb[10];

				$aux->nPP = $auxOb[11];

				$aux->depPP = $auxOb[12];

				$lastInfoPgto->infoprocret[] = $aux;
			
			} else if ($cabecario == 'INFOPROCJUD'){

				$aux = new stdClass();

				if (!isset($lastInfoPgto->infoProcJud)){

					$lastInfoPgto->infoProcJud = array();

				}

				$aux->nrProc = $auxOb[1];

				$aux->indOrigemRecursos = $auxOb[2];

				$aux->desc = $auxOb[3];

				$lastInfoPgto->infoProcJud[] = $aux;

				$lastInfoProcJud = $aux;

			} else if ($cabecario == 'DESPPROCJUD'){

				$aux = new stdClass();

				if (!isset($lastInfoProcJud->despProcJud)){

					$lastInfoProcJud->despProcJud = array();

				}

				$aux->vlrDespCustas = $auxOb[1];

				$aux->vlrDespAdvogados = $auxOb[2];

				$aux->despProcJud->ideAdv = new stdClass();

				$aux->despProcJud->tpInscAdv = $auxOb[3];

				$aux->despProcJud->nrInscAdv = $auxOb[4];

				$aux->despProcJud->vlrAdv = $auxOb[5];

				$lastInfoProcJud->despProcJud[] = $aux;

				$lastDespProcJud = $aux;

			} else if ($cabecario == 'ORIGEMREC'){

				$aux = new stdClass();

				if (!isset($lastInfoProcJud->origemRec)){

					$lastInfoProcJud->origemRec = array();

				}

				$aux->cnpjOrigRecurso = $auxOb[1];
				
				$lastInfoProcJud->origemRec[] = $aux;

			} else if ($cabecario == 'ENDEXT'){

				$aux = new stdClass();

				if (!isset($lastIdePgto->infoPgtoExt->endExt)){

					$lastIdePgto->infoPgtoExt->endExt = array();

				}

				$aux->nrInscFCI = $auxOb[1];

				$aux->dscLograd = $auxOb[2];

				$aux->nrLograd = $auxOb[3];

				$aux->complem = $auxOb[4];

				$aux->bairro = $auxOb[5];

				$aux->cidade = $auxOb[6];

				$aux->estado = $auxOb[7];

				$aux->codPostal = $auxOb[8];

				$aux->telef = $auxOb[9];

				$lastIdePgto->infoPgtoExt->endExt[] = $aux;

			} else if ($cabecario == 'INFOFISCAL'){

				$aux = new stdClass();

				if(!isset($lastIdePgto->infoPgtoExt->infoFiscal)){

					$lastIdePgto->infoPgto->infoFiscal = array();

				}

				$aux->indNIF = $auxOb[1];

				$aux->nifBenef = $auxOb[2];

				$aux->relFontPg = $auxOb[3];

				$aux->frmTribut = $auxOb[4];

				$lastIdePgto->infoPgtoExt->infoFiscal[] = $aux;

			}

		}

		return $this->obParsed;

	}

}
?>