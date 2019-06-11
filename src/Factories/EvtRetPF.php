<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NFePHP\EFDReinf\Factories;

/**
 * Class EFD-Reinf EvtPgtosDivs Event R-2070 constructor
 *
 * @category  API
 * @package   NFePHP\EFDReinf
 * @copyright NFePHP Copyright (c) 2017
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-efdreinf for the canonical source repository
 */

use NFePHP\EFDReinf\Common\Factory;
use NFePHP\EFDReinf\Common\FactoryInterface;
use NFePHP\EFDReinf\Common\FactoryId;
use NFePHP\Common\Certificate;
use stdClass;

class EvtRetPF extends Factory implements FactoryInterface
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

		$params->evtName = 'evtRetPF';

		$params->evtTag = 'evtRetPF';

		$params->evtAlias = 'R-4010';

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

        if($this->std->indretif == 1){
            $this->dom->addChild(
                $ideEvento,
                "nrRecibo",
                !empty($this->std->nrrecibo) ? $this->std->nrrecibo : null,
                true
            );
        }

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

        $ides = $this->std->ideestab;

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

        $ben = $ides->idebenef;

        $ideBenef = $this->dom->createElement("ideBenef");

        $this->dom->addChild(
        	$ideBenef,
        	"cpfBenef",
        	!empty($ben->cpfbenef) ? $ben->cpfbenef : null,
            false
        );

        if($ben->cpfBenef != true){

            $this->dom->addChild(
                $ideBenef,
                "nmBenef",
                $ben->nmbenef,
                true
            );
        }

        foreach ($this->std->idepgto as $idep) {

            $idepgto = $this->dom->createElement("idePgto");

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
            	$idep->observ,
            	true
            );

            foreach ($idep->infopgto as $ppf) {

                $infoPgto = $this->dom->createElement("infoPgto");

                $this->dom->addChild(
                    $infoPgto,
                    "dtFG",
                    $ppf->dtfg,
                    true
                );

                $this->dom->addChild(
                    $infoPgto,
                    "indDecTerc",
                    $ppf->inddecterc,
                    true
                );

                $this->dom->addChild(
                    $infoPgto,
                    "vlrRendBruto",
                    number_format($ppf->vlrrendbruto, 2, ',', ''), 
                    true
                );

                $this->dom->addChild(
                    $infoPgto,
                    "vlrRendTrib",
                    !empty($ppf->vlrrendtrib) ? number_format($ppf->vlrrendtrib, 2, ',', '') : null, false
                );

                $this->dom->addChild(
                    $infoPgto,
                    "vlrIR",
                    !empty($ppf->vlrir) ? number_format($ppf->vlrir, 2, ',', '') : null, false
                );

                $this->dom->addChild(
                    $infoPgto,
                    "vlrRendSusp",
                    !empty($ppf->vlrrendrusp) ? number_format($ppf->vlrrendsusp, 2, ',', '') : null, false
                );

                $this->dom->addChild(
                    $infoPgto,
                    "vlrNIR",
                    !empty($ppf->vlrnir) ? number_format($ppf->vlrnir, 2, ',', '') : null, false
                );

                $this->dom->addChild(
                    $infoPgto,
                    "vlrDeposito",
                    !empty($ppf->vlrdeposito) ? number_format($ppf->vlrdeposito, 2, ',', '') : null, false
                );

                $this->dom->addChild(
                    $infoPgto,
                    "vlrCompAnoCalend",
                    !empty($ppf->vlrcompanocalend) ? number_format($ppf->vlrcompanocalend, 2, ',', '') : null, false
                );

                $this->dom->addChild(
                    $infoPgto,
                    "vlrCompAnoAnt",
                    !empty($ppf->vlrcompanoant) ? number_format($ppf->vlrcompanoant, 2, ',', '') : null, false
                );

        
                if (!empty($ppf->fci)) {

                    $stdfci = $ppf->fci;
            
                    $FCI = $this->dom->createElement("FCI");

                    $this->dom->addChild(
                        $FCI,
                       "nrInscFCI",
                        $stdfci->nrinscfci,
                        true
                    );

                    $infoPgto->appendChild($FCI);
            
                }

                if(!empty($ppf->scp)) {

                	$stdscp = $ppf->scp;

                 	$SCP = $this->dom->createElement("SCP");

                    $this->dom->addChild(

                        $SCP,
                        "nrInscSCP",
                        $stdscp->nrinscscp,
                        true
                    );

                    $this->dom->addChild(
                        $SCP,
                        "percSCP",
                        $stdscp->percscp,
                        true
                    );

                    $infoPgto->appendChild($SCP);
                }

                if(!empty($ppf->detded)) {


                    foreach ($ppf->detded as $dd) {

                        $detDed = $this->dom->createElement("detDed");

                        $this->dom->addChild(
                            $detDed,
                            "indTpDeducao",
                            $dd->indtpdeducao,
                            true
                        );

                        $this->dom->addChild(
                            $detDed,
                            "vlrDeducao",
                            number_format($dd->vlrdeducao, 2, ',', ''),
                            true
                        );

                        $this->dom->addChild(
                            $detDed,
                            "vlrDedSusp",
                            !empty($dd->vlrdedsusp) ? number_format($dd->vlrdedsusp, 2, ',', '') : null,
                            false
                        );

                        $this->dom->addChild(
                            $detDed,
                            "nrInscPrevComp",
                            !empty($dd->nrInscprevComp) ? number_format($dd->nrinscprevcomp, 2, ',', '') : null,
                            false
                        );

                        if (!empty($dd->benefpen)) {

                            foreach ($dd->benefpen as $benp) {

                                $benefPen = $this->dom->createElement("benefPen");

                                $this->dom->addChild(
                                    $benefPen,
                                    "cpf",
                                    !empty($benp->cpf) ? $benp->cpf : null,
                                    false
                                );

                                $this->dom->addChild(
                                    $benefPen,
                                    "dtNascto",
                                    !empty($benp->dtnascto) ? $benp->dtnascto : null,
                                    false

                                );

                                $this->dom->addChild(
                                    $benefPen,
                                    "nome",
                                    $benp->nome,
                                    true
                                );

                                $this->dom->addChild(
                                    $benefPen,
                                    "relDep",
                                    $benp->reldep,
                                    true
                                );

                                $this->dom->addChild(
                                    $benefPen,
                                    "descrDep",
                                    !empty($benp->descrdep) ? $benp->descrdep : null,
                                    false
                                );
                                
                                $detDed->appendChild($benefPen);

                            }
                            
                        }
                        
                        $infoPgto->appendChild($detDed);

                    }  

                }

                if(!empty($ppf->rendisento)) {

                    foreach ($ppf->rendisento as $rendi){

                        $rendIsento = $this->dom->createElement("rendIsento");

                        $this->dom->addChild(
                            $rendIsento,
                            "tpIsencao",
                            $rendi->tpisencao,
                            true
                        );

                        $this->dom->addChild(
                            $rendIsento,
                            "vlrIsento",
                            $rendi->vlrisento,
                            true
                        );

                        $this->dom->addChild(
                            $rendIsento,
                            "descRendimento",
                            !empty($rendi->descrendimento) ? $rendi->descrendimento : null,
                            false
                        );

                        $this->dom->addChild(
                            $rendIsento,
                            "dtLaudo",
                            !empty($rendi->dtlaudo) ? $rendi->dtlaudo : null,
                            false
                        );
                        
                        $infoPgto->appendChild($rendIsento);

                    }

                }

                if(!empty($ppf->infoprocpet)) {

                    foreach ($ppf->infoprocret as $infoprocr) {

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
                            "vlrNRetido",
                            !empty($infoprocr->vlrnretido) ? number_format($infoprocr->vlrnretido, 2, ',', '') : null,
                            false
                        );

                        $this->dom->addChild(
                            $infoProcRet,
                            "vlrDep",
                            !empty($infoprocr->vlrdep) ? number_format($infoprocr->vlrdep, 2, ',', '') : null,
                            false
                        );
                        
                        $infoPgto->appendChild($infoProcRet);

                    }
                
                }

                if (!empty($ppf->inforra)) {
                    
                    $infoRRA = $this->dom->createElement("infoRRA");

                    $rra = $ppf->inforra;

                    $this->dom->addChild(
                        $infoRRA,
                        "tpProcRRA",
                        $rra->tpProcrra,
                        true
                    );

                    $this->dom->addChild(
                        $infoRRA,
                        "nrProcRRA",
                        !empty($rra->nrProcrra) ? $rra->nrProcrra : null,
                        false
                    );

                    $this->dom->addChild(
                        $infoRRA,
                        "indOrigRec",
                        $rra->indorigrec,
                        true
                    );

                    $this->dom->addChild(
                        $infoRRA,
                        "descRRA",
                        $rra->descrra,
                        true
                    );

                    $this->dom->addChild(
                        $infoRRA,
                        "qtdMesesRRA",
                        $rra->qtdmesesrra,
                        true
                    );

                    if (!empty($rra->despprocjud)) {

                        $despProcJud = $this->dom->createElement("despProcJud");

                        $desp = $rra->despprocjud;

                        $this->dom->addChild(
                            $despProcJud,
                            "vlrDespCustas",
                            $desp->vlrdespcustas,
                            true
                        );

                        $this->dom->addChild(
                            $despProcJud,
                            "vlrDespAdvogados",
                            $desp->vlrdespadvogados,
                            true
                        );


                        if (!empty($desp->ideadv)) {

                            foreach ($desp->ideadv as $idead) {

                                $ideAdv = $this->dom->createElement("ideAdv");

                                $this->dom->addChild(
                                    $ideAdv,
                                    "tpInscAdv",
                                    $idead->tpinscadv,
                                    true
                                );

                                $this->dom->addChild(
                                    $ideAdv,
                                    "nrInscAdv",
                                    $idead->nrinscadv,
                                    true
                                );

                                $this->dom->addChild(
                                    $ideAdv,
                                    "vlrAdv",
                                    $idead->vlradv,
                                    true
                                );
                                
                                $despProcJud->appendChild($ideAdv);

                            }
                            
                        }
                        
                        $infoRRA->appendChild($despProcJud);

                    }

                    if (!empty($rra->origemrec)) {

                        $origemRec = $this->dom->createElement("origemRec");

                        $orirec = $rra->origemrec;

                        $this->dom->addChild(
                            $origemRec,
                            "cnpjOrigRecurso",
                            $orirec->cnpjorigrecurso,
                            true
                        );

                        $infoRRA->appendChild($origemRec);
                    }
                    
                    $infoPgto->appendChild($infoRRA);

                }

                if (!empty($ppf->infoprocjud)) {

                    $infoProcJud = $this->dom->createElement("infoProcJud");

                    $infopjud = $ppf->infoprocjud;

                    $this->dom->addChild(
                        $infoProcJud,
                        "nrProc",
                        $infopjud->nrproc,
                        true
                    );

                    $this->dom->addChild(
                        $infoProcJud,
                        "indOrigRec",
                        $infopjud->indorigrec,
                        true
                    );

                    $this->dom->addChild(
                        $infoProcJud,
                        "desc",
                        !empty($infopjud->desc) ? $infopjud->desc : null,
                        false
                    );

                    if (!empty($infoprocjud->despprocjud)) {

                        $despProcJudinfo = $this->dom->createElement("despProcJud");

                        $despprocjudin = $infopjud->despprocjud;

                        $this->dom->addChild(
                            $despProcJudinfo,
                            "vlrDespCustas",
                            $despprocjudin->vlrdespcustas,
                            true
                        );

                        $this->dom->addChild(
                            $despProcJudinfo,
                            "vlrDespAdvogados",
                            $despprocjudin->vlrdespadvogados,
                            true
                        );

                        if (!empty($despprocjudin->ideadv)) {

                            foreach ($despprocjudin->ideadv as $dpi) {

                                $ideAdvinfo = $this->dom->createElement("ideAdv");

                                $this->dom->addChild(
                                    $ideAdvinfo,
                                    "tpInscAdv",
                                    $ideadvin->tpinscadv,
                                    true
                                );

                                $this->dom->addChild(
                                    $ideAdvinfo,
                                    "nrInscAdv",
                                    $ideadvin->nrinscadv,
                                    true
                                );

                                $this->dom->addChild(
                                    $ideAdvinfo,
                                    "vlrAdv",
                                    $ideadvin->vlradv,
                                    true
                                );
                                
                                $despProcJudin->appendChild($ideAdvinfo);

                            }
                            
                        }
                        
                        $infoProcJud->appendChild($despProcJudinfo);

                    }

                    if (!empty($infopjud->origemrec)) {

                        $origemrecin = $infopjud->origemrec;

                        $origemRec = $this->dom->createElement("origemRec");

                        $this->dom->addChild(
                            $origemRec,
                            "cnpjOrigRecurso",
                            $origemrecin->cnpjorigrecurso,
                            true
                        );

                        $infoProcJud->appendChild($origemRec);

                    }
                    
                    $infoPgto->appendChild($infoProcJud);

                }
                
                $idePgto->appendChild($infoPgto);

            }

            if (!empty($ideP->infopgtoext)) {

                $infopext = $idep->infopgtoext;

                $infoPgtoExt = $this->dom->createElement("infoPgtoExt");

                $iendext = $infopext->endext;

                $endExt = $this->dom->createElement("endExt");

                $this->dom->addChild(
                    $endExt,
                    "dscLograd",
                    $iendext->dsclograd,
                    true
                );

                $this->dom->addChild(
                    $endExt,
                    "nrLograd",
                    !empty($iendext->nrlograd) ? $iendext->nrlograd : null,
                    false
                );

                $this->dom->addChild(
                    $endExt,
                    "complem",
                    !empty($iendext->complem) ? $iendext->complem : null,
                    false
                );

                $this->dom->addChild(
                    $endExt,
                    "bairro",
                    !empty($iendext->bairro) ? $iendext->bairro : null,
                    false
                );

                $this->dom->addChild(
                    $endExt,
                    "cidade",
                    !empty($iendext->cidade) ? $iendext->cidade : null,
                    false
                );

                $this->dom->addChild(
                    $endExt,
                    "estado",
                    !empty($iendext->estado) ? $iendext->estado : null,
                    false
                );

                $this->dom->addChild(
                    $endExt,
                    "codPostal",
                    !empty($iendext->codPostal) ? $iendext->codPostal : null,
                    false
                );

                $this->dom->addChild(
                    $endExt,
                    "telef",
                    !empty($iendext->telef) ? $iendext->telef : null,
                    false
                );


                $ifiscal = $infopext->endext;

                $infoFiscal = $this->dom->createElement("infoFiscal");

                $this->dom->addChild(
                    $infoFiscal,
                    "indNIF",
                    $ifiscal->indnif,
                    true
                );

                $this->dom->addChild(
                    $infoFiscal,
                    "nifBenef",
                    !empty($ifiscal->nifbenef) ? $ifiscal->nifbenef : null,
                    false
                );

                $this->dom->addChild(
                    $infoFiscal,
                    "frmTribut",
                    $ifiscal->frmtribut,
                    true
                );
                
                $infoPgtoExt->appendChild($endExt);

                $infoPgtoExt->appendChild($infoFiscal);

                $idePgto->appendChild($infoPgtoExt);
            }

            $ideBenef->appendChild($idePgto);

        }

        if(!empty($ben->ideopsaude)) {


            foreach ($ben->ideopsaude as $ops) {

                $ideOpSaude = $this->dom->createElement("ideOpSaude");

                $this->dom->addChild(
                    $ideOpSaude,
                    "nrInsc",
                    $ops->nrinsc,
                    true
                );

                $this->dom->addChild(
                    $ideOpSaude,
                    "regANS",
                    !empty($ops->regans) ? $ops->regans : null,
                    false
                );

                $this->dom->addChild(
                   $ideOpSaude,
                    "vlrSaude",
                    number_format($ops->vlrsaude, 2, ',', ''),
                    true
                );

                if(!empty($ops->inforeemb)) {

                    foreach ($ops->infoReemb as $reemb) {

                        $infoReemb = $this->dom->createElement("infoReemb");

                        $this->dom->addChild(
                            $infoReemb,
                            "tpInsc",
                            $reemb->tpinsc,
                            true
                        );

                        $this->dom->addChild(
                            $infoReemb,
                            "nrInsc",
                            $reemb->nrinsc,
                            true
                        );

                        $this->dom->addChild(
                            $infoReemb,
                            "vlrReemb",
                            number_format($reemb->vlrreemb, 2, ',', ''),
                            true
                        );

                        $this->dom->addChild(
                            $infoReemb,
                            "vlrSaude",
                            !empty($reemb->vlrsaude) ? number_format($reemb->vlrsaude, 2, ',', '') : null,
                            false
                        );
                        
                        $ideOpSaude->appendChild($infoReemb);

                    }
                    
                }

                if(!empty($ideops->infodependpl)) {

                    foreach ($ideops->infodependpl as $infodpl) {

                        $infoDependPl = $this->dom->createElement("infoDependPl");

                        $this->dom->addChild(
                            $infoDependPl,
                            "cpf",
                            !empty($infodpl->cpf) ? $infodpl->cpf : null,
                            false
                        );

                        $this->dom->addChild(
                            $infoDependPl,
                            "dtNascto",
                            !empty($infodpl->dtnascto) ? $infodpl->dtnascto : null,
                            false
                        );

                        $this->dom->addChild(
                            $infoDependPl,
                            "nome",
                            $infodpl->nome,
                            true
                        );

                        $this->dom->addChild(
                            $infoDependPl,
                            "relDep",
                            $infodpl->relDep,
                            true
                        );

                        $this->dom->addChild(
                            $infoDependPl,
                            "vlrSaude",
                            number_format($infodpl->vlrsaude, 2, ',', ''),
                            true
                        );

                        if(!empty($infodpl->inforeembdep)) {

                            foreach ($infodpl->inforeembdep as $reembdep) {

                                $infoReembDep = $this->dom->createElement("infoReembDep");

                                $this->dom->addChild(
                                    $infoReembDep,
                                    "tpInsc",
                                    $reembdep->tpinsc,
                                    true
                                );

                                $this->dom->addChild(
                                    $infoReembDep,
                                    "nrInsc",
                                    $reembdep->nrinsc,
                                    true
                                );

                                $this->dom->addChild(
                                    $infoReembDep,
                                    "vlrReemb",
                                    number_format($reembdep->vlrreemb, 2, ',', ''),
                                    true
                                );

                                $this->dom->addChild(
                                    $infoReembDep,
                                    "vlrReembAnt",
                                    !empty($reembdep->vlrreembant) ? number_format($reembdep->vlrreembant, 2, ',', '') : null,
                                    false
                                );
                                
                                $infoDependPl->appendChild($infoReembDep);

                            }

                        }
                        
                        $ideOpSaude->appendChild($infoDependPl);

                    }
                    
                }
            
                $ideBenef->appendChild($ideOpSaude);

            }
            
        }

        $ideEstab->appendChild($ideBenef);

        $this->node->appendChild($ideBenef);

        $this->reinf->appendChild($this->node);

        $this->sign($this->evtTag);

	}

}

?>