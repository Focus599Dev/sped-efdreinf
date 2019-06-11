<?php
		

namespace NFePHP\EFDReinf\Parses;

/**
 * 
 */
    
use NFePHP\EFDReinf\Parses\Parse;
use stdClass;

class EvtRetPF extends Parse{
	
	public function convert(){

		$this->obParsed->config = new stdClass();

		$this->obParsed->modo = $this->ob[0][1];

		$this->obParsed->idEvento = $this->ob[0][3];

		$this->obParsed->config->eventoVersion = $this->eventoVersion;

		$this->obParsed->config->serviceVersion = $this->serviceVersion;

		$this->obParsed->ideEvento = new stdClass();

		$this->obParsed->ideEvento->indRetif = $this->ob[1][1];

		$this->obParsed->idEvento->nrRecibo = $this->ob[1][2];

		$this->obParsed->ideEvento->perApur = $this->ob[1][3];

		$this->obParsed->config->empregador = new stdClass();

		$this->obParsed->config->transmissor = $this->obParsed->config->empregador;

		$this->obParsed->config->ideEvento->empregador->nmRazao = $this->ob[1][4];

		$this->obParsed->config->ideEvento->tpAmb = $this->ob[1][5];

		$this->obParsed->config->ideEvento->procEmi = $this->ob[1][6];

		$this->obParsed->config->ideEvento->verProc = $this->ob[1][7];

		$this->obParsed->ideContri = new stdClass();

		$this->obParsed->config->empregador->ideContri->tpInsc = $this->ob[1][8];

		$this->obParsed->config->empregador->ideContri->nrInsc = $this->ob[1][9];

		$this->obParsed->ideEstab = new stdClass();

		$this->obParsed->ideEstab->tpInscEstab = $this->ob[1][10];

		$this->obParsed->ideEstab->nrInscEstab = $this->ob[1][11];

		$this->obParsed->ideEstab->ideBenef = new stdClass();

		$this->obParsed->ideBenef->cpfBenef = $this->ob[1][12];

		$this->obParsed->ideBenef->nmBenef = $this->ob[1][13];

		$index = 2;

		$lastInfoPgto = null;

		$lastDetDed = null;

		$lastBenefPen = null;

		$lastRendIsento = null;

		$lastInfoProcRet = null;

		$lastDespProcJudinRRA = null;

		$lastInfoProcJud = null;

		$lastIdeAdvdoinRRA = null;

		$lastDespProcJuddesProc = null;

		$lastIdeAdvdesProc = null;

		$lastIdeBenef = null;

		$lastIdeOpSaude = null;

		$lastInfoReemb = null;

		$lastInfoDependPl = null;

		$this->obParsed->ideEstab = array();

		for ($i = $index; $i < count($this->ob); $i++){

			$auxOb = $this->ob[$i];

			$cabecario = $auxOb[0];

			if ($cabecario == 'IDEPGTO'){

				$aux = new stdClass();

				$aux->natRend = $auxOb[1];

				$aux->paisResid = $auxOb[2];

				$aux->observ = $auxOb[3];

				$this->obParsed->idepgto[] = $aux;

				$lastIdePgto = $aux;

            } else if ($cabecario == 'INFOPGTO'){

            	$aux = new stdClass();

            	if (!isset($lastIdePgto->infopgto)){

            		$lastIdePgto->infopgto = array();

            	}

            	$aux->dtFG = $auxOb[1];

            	$aux->indDecTerc = $auxOb[2];

            	$aux->vlrRendBruto = $auxOb[3];

            	$aux->vlrRendTrib = $auxOb[4];

            	$aux->vlrIR = $auxOb[5];

            	$aux->vlrRendSusp = $auxOb[6];

            	$aux->vlrNIR = $auxOb[7];

            	$aux->vlrDeposito = $auxOb[8];

            	$aux->vlrCompAnoCalend = $auxOb[9];

            	$aux->vlrCompAnoAnt = $auxOb[10];

            	$aux->vlrCompAnoAnt = $auxOb[11];

            	$lastIdePgto->infoPgto[] = $aux;

            	$lastInfoPgto = $aux;

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

            } else if ($cabecario == 'DETDED'){

            	$aux = new stdClass();

            	if (!isset($lastInfoPgto->detded)){

            		$lastInfoPgto->detded = array();

            	}

            	$aux->indTpDeducao = $auxOb[1];

            	$aux->vlrDeducao = $auxOb[2];

            	$aux->vlrDedSusp = $auxOb[3];

            	$aux->nrInscPrevComp = $auxOb[4];

            	$lastInfoPgto->detded[] = $aux;

            	$lastDetDed = $aux;

			} else if ($cabecario == 'BENEFPEN'){

				$aux = new stdClass();

				if (!isset($lastDetDed->benefpen)){

					$lastDetDed->benefpen = array();

				}

				$aux->nome = $auxOb[1];

				$aux->relDep = $auxOb[2];

				$aux->descrDep = $auxOb[3];

				$aux->cpf = $auxOb[4];

				$aux->dtNascto = $auxOb[5];

				$lastDetDed->benefpen[] = $aux;

				$lastBenefPen = $aux;

			} else if ($cabecario == 'RENDISENTO'){

				$aux = new stdClass();

				if (!isset($lastInfoPgto->rendisento)){

					$lastInfoPgto->rendisento = array();

				}

				$aux->tpIsencao = $auxOb[1];

				$aux->vlrIsento = $auxOb[2];

				$aux->descRendimento = $auxOb[3];

				$aux->dtLaudo = $auxOb[4];

				$lastInfoPgto->rendisento[] = $aux;

				$lastRendIsento = $aux;

			} else if ($cabecario == 'INFOPROCRET'){	

				$aux = new stdClass();

				if (!isset($lastInfoPgto->infoprocret)){

					$lastInfoPgto->infoprocret = array();

				}

				$aux->tpProcRet = $auxOb[1];

				$aux->nrProcRet = $auxOb[2];

				$aux->codSusp = $auxOb[3];

				$aux->vlrNRetido = $auxOb[4];

				$aux->vlrDep = $auxOb[5];

				$lastInfoPgto->infoprocret[] = $aux;

				$lastInfoProcRet = $aux;

			} else if ($cabecario == 'INFORRA')	{

				$aux = new stdClass();

				if (!isset($lastInfoPgto->inforra)){

					$lastInfoPgto->inforra = array();

				}

				$aux->tpProcRRA = $auxOb[1];

				$aux->nrProcRRA = $auxOb[2];

				$aux->indOrigRec = $auxOb[3];

				$aux->descRRA = $auxOb[4];

				$aux->qtdMesesRRA = $auxOb[5];

				$lastInfoPgto->inforra[] = $aux;

				$lastInfoRRA = $aux;

			} else if ($cabecario == 'DESPPROCJUDINRRA'){

				$aux = new stdClass();

				if (!isset($lastInfoRRA->despprocjudinrra)){

					$lastInfoRRA->despprocjudinrra = array();

				}

				$aux->vlrDespCustas = $auxOb[1];

				$aux->vlrDespAdvogados = $auxOb[2];

				$lastInfoRRA->despprocjudinrra[] = $aux;

				$lastDespProcJudinRRA = $aux;

			} else if ($cabecario == 'IDEADVDOINRRA'){

				$aux = new stdClass();

				if (!isset($lastDespProcJud->ideadvdoinrra)){

					$lastDespProcJud->ideadvdoinrra = array();

				}

				$aux->tpInscAdv = $auxOb[1];

				$aux->nrInscAdv = $auxOb[2];

				$aux->vlrAdv = $auxOb[3];

				$lastDespProcJud->ideadvdoinrra[] = $aux;

				$lastIdeAdvdoinRRA = $aux;

			} else if ($cabecario == 'ORIGEMRECINRRA'){

				$aux = new stdClass();

				if(!isset($lastInfoRRA->origemrecinrra)){

					$lastInfoRRA->origemrecinrra = array();

				}

				$aux->cnpjOrigRecurso = $auxOb[1];

				$lastInfoRRA->origemrecinrra[] = $aux;

			} else if ($cabecario == 'INFOPROCJUD'){

				$aux = new stdClass();

				if(!isset($lastInfoPgto->infoprocjud)){

					$lastInfoPgto->infoprocjud = array();

				}

				$aux->nrProc = $auxOb[1];

				$aux->indOrigRec = $auxOb[2];

				$aux->desc = $aux[3];

				$lastInfoPgto->infoprocjud[] = $aux;

				$lastInfoProcJud = $aux;

			} else if ($cabecario == 'DESPPROCJUDDESPROC') {

				$aux = new stdClass();

				if(!isset($lastInfoProcJud->despprocjuddesproc)){

					$lastInfoProcJud->despprocjuddesproc = array();

				}

				$aux->vlrDespCustas = $auxOb[1];

				$aux->vlrDespAdvogados = $auxOb[2];

				$lastInfoProcJud->despprocjuddesproc[] = $aux;

				$lastDespProcJuddesProc = $aux;

			} else if ($cabecario == 'IDEADVDESPROC'){

				$aux = new stdClass();

				if(!isset($lastDespProcJud->ideadvdesproc)){

					$lastDespProcJud->ideadvdesproc = array();

				}

				$aux->tpInscAdv = $auxOb[1];

				$aux->nrInscAdv = $auxOb[2];

				$aux->vlrAdv = $auxOb[3];

				$lastDespProcJud->ideadvdesproc[] = $aux;

				$lastIdeAdvdesProc = $aux;

			} else if ($cabecario == 'ORIGEMRECDESPROC'){

				$aux = new stdClass();

				if(!isset($lastInfoProcJud->origemrecdesproc)){

					$lastInfoProcJud->origemrecdesproc = array();

				}

				$aux->cnpjOrigRecurso = $auxOb[1];

				$lastInfoProcJud->origemrecdesproc[] = $aux;

			} else if ($cabecario == 'ENDEXT'){

				$aux = new stdClass();

				if(!isset($lastIdePgto->infopgtoext->endext)){

					$lastIdePgto->infopgtoext->endext = array();

				}

				$aux->dscLograd = $auxOb[1];

				$aux->nrLograd = $auxOb[2];

				$aux->complem = $auxOb[3];

				$aux->bairro = $auxOb[4];

				$aux->cidade = $auxOb[5];

				$aux->estado = $auxOb[6];

				$aux->codPostal = $auxOb[7];

				$aux->telef = $auxOb[8];

				$lastIdePgto->infopgtoext->endext[] = $aux;

			} else if ($cabecario == 'INFOFISCAL') {

				$aux = new stdClass();

				if(!isset($lastIdePgto->infopgtoext->infofiscal)){

					$lastIdePgto->infopgtoext->infofiscal = array();

				}

				$aux->indNIF = $auxOb[1];

				$aux->nifBenef = $auxOb[2];

				$aux->frmTribut = $auxOb[3];

				$lastIdePgto->infopgtoext->infofiscal[] = $aux;

			} else if ($cabecario == 'IDEOPSAUDE'){

				$aux = new stdClass();

				if(!isset($lastIdeBenef->ideopsaude)){

					$lastIdeBenef->ideopsaude = array();

				}

				$aux->nrInsc = $auxOb[1];

				$aux->regANS = $auxOb[2];

				$aux->vlrSaude = $auxOb[3];

				$lastIdeBenef->ideopsaude[] = $aux;

				$lastIdeOpSaude = $aux;

			} else if ($cabecario == 'INFOREEMB'){

				$aux = new stdClass();

				if(!isset($lastIdeOpSaude->inforeemb)){

					$lastIdeOpSaude->inforeemb = array();

				}

				$aux->tpInsc = $auxOb[1];

				$aux->nrInsc = $auxOb[2];

				$aux->vlrReemb = $auxOb[3];

				$aux->vlrReembAnt = $auxOb[4];

				$lastIdeOpSaude->inforeemb[] = $aux;

				$lastInfoReemb = $aux;

			} else if ($cabecario == 'INFODEPENDPL'){

				$aux = new stdClass();

				if(!isset($lastIdeOpSaude->infodependpl)){

					$lastIdeOpSaude->infodependpl = array();

				}

				$aux->cpf = $auxOb[1];

				$aux->dtNascto = $auxOb[2];

				$aux->nome = $auxOb[3];

				$aux->relDep = $auxOb[4];

				$aux->vlrSaude = $auxOb[5];

				$lastIdeOpSaude->infodependpl[] = $aux;

				$lastInfoDependPl = $aux;
				
			} else if ($cabecario == 'INFOREEMBDEP'){

				$aux = new stdClass();

				if(!isset($lastInfoDependPl->inforeembdep)){

					$lastInfoDependPl->inforeembdep = array();

				}

				$aux->tpInsc = $auxOb[1];

				$aux->nrInsc = $auxOb[2];

				$aux->vlrReemb = $auxOb[3];

				$aux->vlrReembAnt = $auxOb[4];

				$lastInfoDependPl->inforeembdep[] = $aux;

				$lastInfoReembDep = $aux;

			}

		}

		return $this->obParsed;
		    
	}
	
}
?>