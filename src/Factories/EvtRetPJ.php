<?php

/*
 *
 */

namespace NFePHP\EFDReinf\Factories;

/**
 *
 */

use NFePHP\EFDReinf\Common\Factory;
use NFePHP\EFDReinf\Common\FactoryInterface;
use NFePHP\EFDReinf\Common\FactoryId;
use NFePHP\Common\Certificate;
use stdClass;

class EvtRetPJ extends Factory implements FactoryInterface
{
	/**
     * Constructor
     * @param string $config
     * @param stdClass $std
     * @param Certificate $certificate
     * @param string $data
     */
	public function __construct($config,
     stdClass $std,
      Certificate $certificate = null,
       $data = '')
	{
		$params = new \stdClass();

		$params->evtName = 'evtRetPJ';

		$params->evtTag = 'evtRetPJ';

		$params->evtAlias = 'R-4020';

		parent::__construct($config, $std, $params, $certificate, $data);

	}

	/**
     * Node constructor
     */
	protected function toNode()
	{

		$ideContri = $this->node->getElementsByTagName('ideContri')->item(0);
        //o idEvento pode variar de evento para evento
        //então cada factory individualmente terá de construir o seu
        
        $ideEvento = $this->dom->createElement("ideEvento");

        $this->dom->addChild(
            $ideEvento,
            "indRetif",
            $this->std->indretif,
            true
        );

        $this->dom->addChild(
            $ideEvento,
            "nrRecibo",
            !empty($this->std->nrrecibo) ? $this->std->nrrecibo : null,
            false
        );

        $this->dom->addChild(
            $ideEvento,
            "perApur",
            $this->std->perapur,
            true
        );

        $this->dom->addChild(
            $ideEvento,
            "nmRazao",
            $this->std->nmrazao,
            true
        );

        $this->dom->addChild(
        	$ideEvento,
        	"tpAmb",
        	$this->tpamb,
        	true
        );

        $this->dom->addChild(
        	$ideEvento,
        	"procEmi",
        	$this->procemi,
        	true
        );

        $this->dom->addChild(
        	$ideEvento,
        	"verProc",
        	$this->verproc,
        	true
        );

        $this->node->insertBefore($ideEvento, $ideContri);

        //cria novo ideContri
        $ideContri = $this->dom->createElement("ideContri");

        $this->dom->addChild(
        	$ideContri,
        	"tpInsc",
        	$this->tpinsc,
        	true
        );

        $this->dom->addChild(
        	$ideContri,
        	"nrInsc",
        	$this->nrinsc,
        	true
        );

        $this->node->insertBefore($ideContri, $ideEstab);

        $ides = $this->std->ideEstab;

        $ideEstab = $this->dom->createElement("ideEstab");

        $this->dom->addChild(
        	$ideEstab,
        	"tpInscEstab",
        	$ides->tpinscestab,
        	true
        );

        $this->dom->addChild(
        	$ideEstab,
        	"nrInscEstab",
        	$ides->nrinscestab,
        	true
        );

        $this->node->insertBefore($ideEstab, $ideBenef);

        $ben = $ides->ideBenef;

        $ideBenef = $this->dom->createElement("ideBenef");

        $this->dom->addChild(
        	$ideBenef,
        	"cpfBenef",
        	!empty($ben->cpfbenef) ? $ben->cpfbenef : null,
        	false
        );

        $this->dom->addChild(
            $ideBenef,
            "nmBenef",
            !empty($ben->nmbenef) ? $ben->nmbenef : null,
            false
        );

        $this->dom->addChild(
        	$ideEstab,
        	"isenImun",
        	$ben->isenimun,
        	true
        );

        foreach ($ben->idepgto as $idep) {

        	$idePgto = $this->dom->createElement("idePgto");

        	$this->dom->addChild(
        		$idePgto,
        		"natRend",
        		$idep->natrend,
        		true
        	);

        	$this->dom->addChild(
        		$idePgto,
        		"paisResid",
        		$idep->paisresid,
        		true
        	);

        	$this->dom->addChild(
        		$idePgto,
        		"observ",
        		!empty($idep->observ) ? $idep->observ : null,
        		false
       	    );

       	    foreach ($idep->infopgto as $infop) {

       	    	$infoPgto = $this->dom->createElement("infoPgto");

       	    	$this->dom->addChild(
        			$infoPgto,
        			"dtFG",
        			$infop->dtfg,
        			true
        	    );

        	    $this->dom->addChild(
                    $infoPgto,
                    "vlrTotalPag",
                    number_format($infop->vlrtotalpag, 2, ',', ''),
                    true
                );

        	    $this->dom->addChild(
                    $infoPgto,
                    "vlrTotalCred",
                    number_format($infop->vlrtotalcred, 2, ',', ''),
                    true
                );

                if (!empty($infop->ir)) {

                	$inir = $infop->ir;

                	$IR = $this->dom->createElement("IR");

                	$this->dom->addChild(
                        $IR,
                        "vlrBaseIR",
                        number_format($inir->vlrbaseir, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $IR,
                        "vlrIR",
                        number_format($inir->vlrir, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $IR,
                        "vlrBaseNIR",
                        !empty($inir->vlrbasenir) ? number_format($inir->vlrbasenir, 2, ',', '') : null,
                        false
                    );

                    $this->dom->addChild(
                        $IR,
                        "vlrNIR",
                        !empty($inir->vlrnir) ? number_format($inir->vlrnir, 2, ',', '') : null,
                        false
                    );

                    $this->dom->addChild(
                        $IR,
                        "vlrDepIR",
                        !empty($inir->vlrdepir) ? number_format($inir->vlrdepir, 2, ',', '') : null,
                        false
                    );inir

                    $infoPgto->appendChild($IR);
                
                }

                if (!empty($infop->csll)) {   

                    $infcsll = $infop->csll;

                    $CSLL = $this->dom->createElement("CSLL");

                    $this->dom->addChild(
                        $CSLL,
                        "vlrBaseCSLL",
                        number_format($infcsll->vlrbasecsll, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $CSLL,
                        "vlrCSLL",
                        number_format($infcsll->vlrcsll, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $CSLL,
                        "vlrBaseNCSLL",
                        !empty($infcsll->vlrbasencsll) ? number_format($infcsll->vlrbasencsll, 2, ',', '') : null,
                        false
                    );

                    $this->dom->addChild(
                        $CSLL,
                        "vlrNCSLL",
                        !empty($infcsll->vlrncsll) ? number_format($infcsll->vlrncsll, 2, ',', '') : null,
                        false
                    );

                    $this->dom->addChild(
                        $CSLL,
                        "vlrDepCSLL",
                        !empty($infcsll->vlrdepcsll) ? number_format($infcsll->vlrdepcsll, 2, ',', '') : null,
                        false
                    );

                    $infoPgto->appendChild($CSLL);

                }

                if (!empty($infop->cofins)) {

                	$infoco = $infop->cofins;

                	$Cofins = $this->dom->createElement("Cofins");

                	$this->dom->addChild(
                        $Cofins,
                        "vlrBaseCofins",
                        number_format($infoco->vlrbasecofins, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $Cofins,
                        "vlrCofins",
                        number_format($infoco->vlrcofins, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $Cofins,
                        "vlrBaseNCofins",
                        !empty($infoco->vlrbasencofins) ? number_format($infoco->vlrbasencofins, 2, ',', '') : null,
                        false
                    );

                    $this->dom->addChild(
                        $Cofins,
                        "vlrNCofins",
                        !empty($infoco->vlrncofins) ? number_format($infoco->vlrncofins, 2, ',', '') : null,
                        false
                    );

                    $this->dom->addChild(
                        $Cofins,
                        "vlrDepCofins",
                        !empty($infoco->vlrdepcofins) ? number_format($infoco->vlrdepcofins, 2, ',', '') : null,
                        false
                    );

                    $infoPgto->appendChild($Cofins);

                }

                if (!empty($infop->pp)) {

                	$infopp = $infop->pp;

                	$PP = $this->dom->createElement("PP");

                	$this->dom->addChild(
                        $PP,
                        "vlrBasePP",
                        number_format($infopp->vlrbasepp, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $PP,
                        "vlrPP",
                        number_format($infopp->vlrpp, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $PP,
                        "vlrBaseNPP",
                        !empty($infopp->vlrbasenpp) ? number_format($infopp->vlrbasenpp, 2, ',', '') : null,
                        false
                    );

                    $this->dom->addChild(
                        $PP,
                        "vlrNPP",
                        !empty($infopp->vlrnpp) ? number_format($infopp->vlrnpp, 2, ',', '') : null,
                        false
                    );

                    $this->dom->addChild(
                        $PP,
                        "vlrDepPP",
                        !empty($infopp->vlrdeppp) ? number_format($infopp->vlrdeppp, 2, ',', '') : null,
                        false
                    );

                    $infoPgto->appendChild($PP);

                }

                if (!empty($infop->fci)) {

                	$infofci = $infop->fci;

                	$FCI = $this->dom->createElement("FCI");

                	$this->dom->addChild(
                        $FCI,
                        "perRefPagto",
                        $infofci->perrefpagto,
                        true
                    );

                    $infoPgto->appendChild($FCI);

                }

                if (!empty($infop->scp)) {

                	$infoscp = $infop->scp;

                	$SCP = $this->dom->createElement("SCP");

                	$this->dom->addChild(
                        $SCP,
                        "nrInscSCP",
                        $infoscp->nrinscscp,
                        true
                    );

                    $this->dom->addChild(
                        $SCP,
                        "percSCP",
                        $infoscp->percscp,
                        true
                    );

                    $infoPgto->appendChild($SCP);

                }

                if (!empty($infop->infoprocret)) {

                	foreach ($infop->infoprocret as $infoprocr) {

                		$infoProcRet = $this->dom->createElement("infoProcRet");

                		$this->dom->addChild(
                            $infoProcRet,
                            "tpProcRet",
                            $infoprocr->tpprocret,
                            true
                        );

                		$this->dom->addChild(
                            $infoProcRet,
                            "nrProcRet",
                            $infoprocr->nrprocret,
                            true
                        );

                        $this->dom->addChild(
                            $infoProcRet,
                            "codSusp",
                            !empty($infoprocr->codsusp) ? $infoprocr->codsusp : null,
                            false
                        );

                        $this->dom->addChild(
                            $infoProcRet,
                            "nIR",
                            !empty($infoprocr->nir) ? number_format($infoprocr->nir, 2, ',', '') : null,
                            false
                        );

                        $this->dom->addChild(
                            $infoProcRet,
                            "depIR",
                            !empty($infoprocr->depir) ? number_format($infoprocr->depir, 2, ',', '') : null,
                            false
                        );

                        $this->dom->addChild(
                            $infoProcRet,
                            "nCSLL",
                            !empty($infoprocr->ncsll) ? number_format($infoprocr->ncsll, 2, ',', '') : null,
                            false
                        );

                        $this->dom->addChild(
                            $infoProcRet,
                            "depCSLL",
                            !empty($infoprocr->depcsll) ? number_format($infoprocr->depcsll, 2, ',', '') : null,
                            false
                        );

                        $this->dom->addChild(
                            $infoProcRet,
                            "nCofins",
                            !empty($infoprocr->ncofins) ? number_format($infoprocr->ncofins, 2, ',', '') : null,
                            false
                        );

                        $this->dom->addChild(
                            $infoProcRet,
                            "depCofins",
                            !empty($infoprocr->depcofins) ? number_format($infoprocr->depcofins, 2, ',', '') : null,
                            false
                        );

                        $this->dom->addChild(
                            $infoProcRet,
                            "nPP",
                            !empty($infoprocr->npp) ? number_format($infoprocr->np, 2, ',', '') : null,
                            false
                        );

                        $this->dom->addChild(
                            $infoProcRet,
                            "depPP",
                            !empty($infoprocr->deppp) ? number_format($infoprocr->deppp, 2, ',', '') : null,
                            false
                        );

                        $infoPgto->appendChild($infoProcRet);

                	}

                }

                if (!empty($infop->infoprocjud)) {

                	$infoprocj = $infop->infoprocjud;

                	$infoProcJud = $this->dom->createElement("infoProcJud");

                	$this->dom->addChild(
                        $infoProcJud,
                        "nrProc",
                        $infoprocj->nrproc,
                        true
                    );

                	$this->dom->addChild(
                        $infoProcJud,
                        "indOrigemRecursos",
                        $infoprocj->indorigemrecursos,
                        true
                    );

                	$this->dom->addChild(
                        $infoProcJud,
                        "desc",
                        !empty($infoprocj->desc) ? $infoprocj->desc : null,
                        false
                    );

                    if ( !empty($infoprocj->despprocjud)) {

                    	$infodespprocj = $infoprocj->despprocjud;

                    	$despProcJud = $this->dom->createElement("despProcJud");

                    	$this->dom->addChild(
                            $despProcJud,
                            "vlrDespCustas",
                            number_format($infodespprocj->vlrdespcustas, 2, ',', ''),
                            true
                        );

                    	$this->dom->addChild(
                            $despProcJud,
                            "vlrDespAdvogados",
                            number_format($infodespprocj->vlrdespadvogados, 2, ',', ''),
                            true
                        );

                        if (!empty($infodespprocj->ideadv)) {

                        	foreach ($infodespprocj->ideadv as $infoadv) {

                        		$ideAdv = $this->dom->createElement("ideAdv");

                        		$this->dom->addChild(
                                    $ideAdv,
                                    "tpInscAdv",
                                    $infoadv->tpinscadv,
                                    true
                                );

                        		$this->dom->addChild(
                                    $ideAdv,
                                    "nrInscAdv",
                                    $infoadv->nrinscadv,
                                    true
                                );

                        		$this->dom->addChild(
                                    $ideAdv,
                                    "vlrAdv",
                                    number_format($infoadv->vlradv, 2, ',', ''),
                                    true
                                );

                                $despProcJud->appendChild($ideAdv);

                        	}

                        }

                        $infoProcJud->appendChild($despProcJud);

                    }

                    if (!empty($infoprocjud->origemrec)) {

                    	$infoorirec = $infoprocjud->origemrec;

                    	$origemrec = $this->dom->createElement("origemRec");

                    	$this->dom->addChild(
                            $origemRec,
                            "cnpjOrigRecurso",
                            $infoorirec->cnpjorigrecurso,
                            true
                        );

                        $infoProcJud->appendChild($origemRec);

                    }
                    
                    $infoPgto->appendChild($infoProcJud);

                }

                $idePgto->appendChild($infoPgto);

       	    }

       	    if (!empty($infop->infopgtoext)) {
       	    	
       	    	$infopext = $infop->infopgtoext;

       	        $infoPgtoExt = $this->dom->createElement("infoPgtoExt");

       	        $infoendext = $infopext->endext;

       	        $endExt = $this->dom->createElement("endExt");

       	        $this->dom->addChild(
                    $endExt,
                    "dscLograd",
                    $infoendext->dsclograd,
                    true
                );

                $this->dom->addChild(
                    $endExt,
                    "nrLograd",
                    !empty($infoendext->nrlograd) ? $infoendext->nrlograd : null,
                    false
                );

                $this->dom->addChild(
                    $endExt,
                    "complem",
                    !empty($infoendext->complem) ? $infoendext->complem : null,
                    false
                );

                $this->dom->addChild(
                    $endExt,
                    "bairro",
                    !empty($infoendext->bairro) ? $infoendext->bairro : null,
                    false
                );

                $this->dom->addChild(
                    $endExt,
                    "cidade",
                    !empty($infoendext->cidade) ? $infoendext->cidade : null,
                    false
                );

                $this->dom->addChild(
                    $endExt,
                    "estado",
                    !empty($infoendext->estado) ? $infoendext->estado : null,
                    false
                );

                $this->dom->addChild(
                    $endExt,
                    "codPostal",
                    !empty($infoendext->codpostal) ? $infoendext->codpostal : null,
                    false
                );

                $this->dom->addChild(
                    $endExt,
                    "telef",
                    !empty($infoendext->telef) ? $infoendext->telef : null,
                    false
                );

                $infisext = $infopext->infofiscal;

                $infoFiscal = $this->dom->createElement("infoFiscal");

                $this->dom->addChild(
                    $infoFiscal,
                    "indNIF",
                    $infisext->indnif,
                    true
                );

                $this->dom->addChild(
                    $infoFiscal,
                    "nifBenef",
                    !empty($infisext->nifbenef) ? $infisext->nifbenef : null,
                    false
                );

                $this->dom->addChild(
                    $infoFiscal,
                    "relFontPg",
                    $infisext->relfontpg,
                    true
                );

                $this->dom->addChild(
                   $infoFiscal,
                    "frmTribut",
                    $infisext->frmtribut,
                    true
                );

                $infoPgtoExt->appendChild($endExt);

                $infoPgtoExt->appendChild($infoFiscal);

                $infoPgto->appendChild($infoPgtoExt);

       	    }

       	    $ideBenef->appendChild($idePgto);
        
        }

        $ideEstab->appendChild($ideBenef);

        $this->node->appendChild($ideBenef);

        $this->reinf->appendChild($this->node);

        $this->sign($this->evtTag);

	}

}

?>