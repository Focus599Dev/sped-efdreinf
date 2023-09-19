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

		$lastInfoPgtoDetDed = null;

		$lastinfoprocret = null;

		$this->obParsed->infoPgto = array();

		for ($i = $index; $i < count($this->ob); $i++){

			$auxOb = $this->ob[$i];

			$cabecario = $auxOb[0];

			if ($cabecario == 'IDEBENEF'){

				$aux = new stdClass();

				if (!isset($this->obParsed->idebenef)){

					$this->obParsed->idebenef = array();

				}

				$aux->cnpjBenef = $auxOb[1];

				$aux->nmBenef = $auxOb[2];

				$aux->ideEvtAdic = $auxOb[3];

				$this->obParsed->idebenef = $aux;

				$lastIdeBenef = $aux;

			} else if ($cabecario == 'IDEDEP'){

				$aux = new stdClass();

				if (!isset($this->obParsed->idedep)){

					$this->obParsed->idedep = array();

				}

				$aux->cpfDep = $auxOb[1];

				$aux->relDep = $auxOb[2];

				$aux->descrDep = $auxOb[3];

				$this->obParsed->idedep[] = $aux;

			} else if ($cabecario == 'IDEPGTO'){

				$aux = new stdClass();

				$aux = new stdClass();

				if (!isset($this->obParsed->idepgto)){

					$this->obParsed->idepgto = array();

				}

				$aux->natRend = $auxOb[1];

				$aux->observ = $auxOb[2];

				$this->obParsed->idepgto[] = $aux;

				$lastIdePgto = $aux;

			} else if ($cabecario == 'INFOPGTO'){

				$aux = new stdClass();

				if (!isset($lastIdePgto->infopgto)){

					$lastIdePgto->infopgto = array();

				}

				$aux->dtFG = $auxOb[1];

				$aux->compFP = $auxOb[2];

				$aux->indDecTerc = $auxOb[3];

				$aux->vlrRendBruto = $auxOb[4];

				$aux->vlrRendTrib = $auxOb[5];

				$aux->vlrIR = $auxOb[6];

				$aux->indRRA = $auxOb[7];

				$aux->indFciScp = $auxOb[8];
				
				$aux->nrInscFciScp = $auxOb[9];

				$aux->percSCP = $auxOb[10];

				$aux->indJud = $auxOb[11];

				$aux->paisResidExt = $auxOb[12];

				$aux->dtEscrCont = $auxOb[13];

				$aux->observ = $auxOb[14];


				$lastIdePgto->infopgto[] = $aux;

				$lastInfoPgto = $aux;

			} else if ($cabecario == 'DETDED'){

				$aux = new stdClass();

				if (!isset($lastInfoPgto->detded)){

					$lastInfoPgto->detded = array();

				}

				$aux->indTpDeducao = $auxOb[1];

				$aux->vlrDeducao = $auxOb[2];

				$aux->infoEntid = $auxOb[3];

				$aux->nrInscPrevComp = $auxOb[4];

				$aux->vlrPatrocFunp = $auxOb[5];

				$lastInfoPgto->detded[] = $aux;

				$lastInfoPgtoDetDed = $aux;
			
			} else if ($cabecario == 'BENEFPEN'){

				$aux = new stdClass();

				if (!isset($lastInfoPgtoDetDed->benefPen)){

					$lastInfoPgtoDetDed->benefPen = array();

				}

				$aux->cpfDep = $auxOb[1];

				$aux->vlrDepen = $auxOb[2];

				$lastInfoPgtoDetDed->benefPen[] = $aux;

			
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
			
			} else if ($cabecario == 'INFOPROCRET'){

				$aux = new stdClass();

				if (!isset($lastInfoPgto->infoprocret)){

					$lastInfoPgto->infoprocret = array();

				}

				$aux->tpProcRet = $auxOb[1];

				$aux->nrProcRet = $auxOb[2];

				$aux->codSusp = $auxOb[3];

				$aux->vlrNRetido = $auxOb[4];

				$aux->vlrDepJud = $auxOb[5];

				$aux->vlrCmpAnoCal = $auxOb[6];

				$aux->vlrCmpAnoAnt = $auxOb[7];

				$aux->vlrRendSusp = $auxOb[8];

				$lastInfoPgto->infoprocret[] = $aux;

				$lastinfoprocret = $aux;
			
			} else if ($cabecario == 'DEDSUSP'){

				$aux = new stdClass();

				if (!isset($lastinfoprocret->dedSusp)){

					$lastinfoprocret->dedSusp = array();

				}

				$aux->indTpDeducao = $auxOb[1];

				$aux->vlrDedSusp = $auxOb[2];

				$lastinfoprocret->dedSusp[] = $aux;

				$lastinfoproretSuspBenefPen = $aux;
				
			}  else if ($cabecario == 'BENEFPEN'){

				$aux = new stdClass();

				if (!isset($lastinfoproretSuspBenefPen->benefPen)){

					$lastinfoproretSuspBenefPen->benefPen = array();

				}

				$aux->indTpDeducao = $auxOb[1];

				$aux->vlrDedSusp = $auxOb[2];

				$lastinfoproretSuspBenefPen->benefPen[] = $aux;

				
			}  else if ($cabecario == 'INFORRA'){

				$aux = new stdClass();

				if (!isset($lastInfoPgto->infoRRA)){

					$lastInfoPgto->infoRRA = array();

				}

				$aux->tpProcRRA = $auxOb[1];

				$aux->nrProcRRA = $auxOb[2];

				$aux->indOrigRec = $auxOb[3];

				$aux->descRRA = $auxOb[4];

				$aux->qtdMesesRRA = $auxOb[5];

				$aux->cnpjOrigRecurso = $auxOb[6];

				if ($auxOb[7] || $auxOb[8]){
					
					$aux->despprocjud = new stdClass();

					$aux->despprocjud->vlrDespCustas = $auxOb[7];

					$aux->despprocjud->vlrDespAdvogados = $auxOb[8];

					$lastDespprocjud = $aux->despprocjud;

				}
				
				$lastInfoPgto->infoRRA[] = $aux;
			
			}  else if ($cabecario == 'IDEADVRRA'){

				$aux = new stdClass();

				if (!isset($lastDespprocjud->ideadv)){

					$lastDespprocjud->ideadv = array();

				}

				$aux->tpInscAdv = $auxOb[1];

				$aux->nrInscAdv = $auxOb[2];

				$aux->vlrAdv = $auxOb[3];
			
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

			}  else if ($cabecario == 'IDEADVJUD'){

				$aux = new stdClass();

				if (!isset($lastInfoProcJud->ideAdv)){

					$lastInfoProcJud->ideAdv = array();

				}

				$aux->tpInscAdv = $auxOb[1];

				$aux->nrInscAdv = $auxOb[2];

				$aux->vlrAdv = $auxOb[3];

				$lastInfoProcJud->ideAdv = $aux;

			} else if ($cabecario == 'INFOPGTOEXT'){

				$aux = new stdClass();

				if(!isset($lastIdePgto->infoPgto->infoPgtoExt)){

					$lastIdePgto->infoPgto->infoPgtoExt = new stdClass();

				}

				$aux->indNIF = $auxOb[1];

				$aux->nifBenef = $auxOb[2];

				$aux->relFontPg = $auxOb[3];

				$aux->frmTribut = $auxOb[4];

				if ($$auxOb[5] ||$auxOb[6] || $auxOb[7] || $auxOb[8] || $auxOb[9] || $auxOb[10]){
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

			}

		}

		return $this->obParsed;
		    
	}
	
}
?>