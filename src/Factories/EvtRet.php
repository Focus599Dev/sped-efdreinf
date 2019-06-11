<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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

class EvtRet extends Factory implements FactoryInterface
{
	/**
	*
	*/

	public function __construct(
        $config,
        stdClass $std,
        Certificate $certificate = null,
        $data = ''
    ) {
		$params = new \stdClass();
        
        $params->evtName = 'evtRet';
        
        $params->evtTag = 'evtRet';
        
        $params->evtAlias = 'R-9002';

        parent::__construct($config, $std, $params, $certificate, $data);
    }

    /**
     * Node Constructor
     */

    protected function toNode()
    {
    	$ideContri = $this->node->getElementsByTagName('ideContri')->item(0);
    	//o idEvento pode variar de evento para evento
        //então cada factory individualmente terá de construir o seu
        $ideEvento = $this->dom->createElement("ideEvento");

        $this->dom->addChild(
        	$ideEvento,
        	"nmRazao",
        	$this->std->nmrazao,
        	true
        );

        $this->dom->addChild(
        	$ideEvento,
        	"perRef",
        	$this->std->perref,
        	true
        );

        $this->node->insertBefore($ideEvento,$ideContri);

        $ideContri = $this->dom->createElement("ideContri");

        $this->dom->addChild(
            $ideContri,
            "tpInsc",
            $this->std->tpinsc,
            true
        );

        $this->dom->addChild(
            $ideContri,
            "nrInsc",
            $this->std->nrinsc,
            true
        );

        $this->node->insertBefore($ideContri, $ideRecRetorno);

        $ideRecRetorno = $this->dom->createElement(">ideRecRetorno");

        $ideStatus = $this->dom->createElement("ideStatus");

        $this->dom->addChild(
        	$ideStatus,
        	"cdRetorno",
        	$this->std->cdretorno,
        	true
        );

        $this->dom->addChild(
        	$ideStatus,
        	"descRetorno",
        	$this->std->descretorno,
        	true
        );

        if (!empty($this->std->regocorrs)) {

        	foreach ($this->std->regocorrs as $r) {

        		$regOcorrs = $this->dom->createElement("regOcorrs");

        		$this->dom->addChild(
        			$regocorrs,
        			"tpOcorr",
        			$r->tpocorr,
        			true
        		);

        		$this->dom->addChild(
        			$regocorrs,
        			"localErroAviso",
        			$r->localerroaviso,
        			true
        		);

        		$this->dom->addChild(
        			$regocorrs,
        			"codResp",
        			$r->codresp,
        			true
        		);

        		$this->dom->addChild(
        			$regocorrs,
        			"dscResp",
        			$r->dscresp,
        			true
        		);

        		$ideStatus->appendChild($regOcorrs);

        	}

        }

        $ideRecRetorno->appendChild($ideStatus);

        $this->node->appendChild($ideRecRetorno);

        $infoRecEv = $this->dom->createElement("infoRecEv");

        $this->dom->addChild(
            $infoRecEv,
            "nrProtEntr",
            $this->std->nrprotentr,
            true
        );
        
        $this->dom->addChild(
            $infoRecEv,
            "dhProcess",
            $this->std->dhprocess,
            true
        );

        $this->dom->addChild(
            $infoRecEv,
            "tpEv",
            $this->std->tpev,
            true
        );

        $this->dom->addChild(
            $infoRecEv,
            "idEv",
            $this->std->idev,
            true
        );

        $this->dom->addChild(
            $infoRecEv, 
            "hash",
            $this->std->hash,
            true
        );

        $this->node->appendChild($infoRecEv);

        if (!empty($this->std->infototal)) {

        	$infot = $this->std->infototal;

        	$infoTotal = $this->dom->createElement("infoTotal");

        	$this->dom->addChild(
                $infoTotal,
                "nrRecArqBase",
                !empty($this->std->nrrecarqbase) ? $this->std->nrrecarqbase : null,
                false
            );

            $ideEstab = $this->dom->createElement("ideEstab");

            $idstab = $infot->ideestab;

            $this->dom->addChild(
                $ideEstab,
                "tpInsc",
                $idstab->tpinsc,
                true
            );

            $this->dom->addChild(
                $ideEstab,
                "nrInsc",
                $idstab->nrinsc,
                true
            );

            if (!empty($idstab->totapurmen)) {

            	foreach ($idstab->totapurmen as $infototamen) {

            		$totApurMen = $this->dom->createElement("totApurMen");

            		$this->dom->addChild(
                        $totApurMen,
                        "CRMen",
                        $infototamen->crmen,
                        true
                    );
                    
                    $this->dom->addChild(
                        $totApurMen,
                        "vlrBaseCRMen",
                        number_format($infototamen->vlrbasecrmen, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $totApurMen,
                        "vlrCRMen",
                        number_format($infototamen->vlrcrmen, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $totApurMen,
                        "vlrBaseCRMenSusp",
                        !empty($infototamen->vlrbasecrmensusp) ? number_format($infototamen->vlrbasecrmensusp, 2, ',', '') : null,
                        false
                    );

                    $this->dom->addChild(
                        $totApurMen,
                        "vlrCRMenSusp",
                        !empty($infototamen->vlrcrmensusp) ? number_format($infototamen->vlrcrmensusp, 2, ',', '') : null,
                        false
                    );
                    
                    $ideEstab->appendChild($totApurMen);
            	}
            }

            if (!empty($idstab->totapurqui)) {	

            	foreach ($idstab->totapurqui as $infototaqui) {

            		$totApurQui = $this->dom->createElement("totApurQui");

            		$this->dom->addChild(
                        $totApurQui,
                        "perApurQui",
                        $infototaqui->perapurqui,
                        true
                    );
                    
                    $this->dom->addChild(
                        $totApurQui,
                        "CRQui",
                        $infototaqui->crqui,
                        true
                    );

                    $this->dom->addChild(
                        $totApurQui,
                        "vlrBaseCRQui",
                        number_format($infototaqui->vlrbasecrqui, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $totApurQui,
                        "vlrCRQui",
                        number_format($infototaqui->vlrcrqui, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $totApurQui,
                        "vlrBaseCRQuiSusp",
                        !empty($infototaqui->vlrbasecrquisusp) ? number_format($infototaqui->vlrbasecrquisusp, 2, ',', '') : null,
                        false
                    );

                    $this->dom->addChild(
                        $totApurQui,
                        "vlrCRQuiSusp",
                        !empty($infototaqui->vlrcrquisusp) ? number_format($infototaqui->vlrcrquisusp, 2, ',', '') : null,
                        false
                    );

                    $ideEstab->appendChild($totApurQui);

            	}
            }

            if (!empty($idstab->totapurdec)) {	

            	foreach ($idstab->totapurdec as $infototadec) {

            		$totApurDec = $this->dom->createElement("totApurDec");

            		$this->dom->addChild(
                        $totApurDec,
                        "perApurDec",
                        $infototadec->perapurdec,
                        true
                    );
                    
                    $this->dom->addChild(
                        $totApurDec,
                        "CRDec",
                        $infototadec->crdec,
                        true
                    );

                    $this->dom->addChild(
                        $totApurDec,
                        "vlrBaseCRDec",
                        number_format($infototadec->vlrbasecrdec, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $totApurDec,
                        "vlrCRDec",
                        number_format($infototadec->vlrcrdec, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $totApurDec,
                        "vlrBaseCRDecSusp",
                        !empty($infototadec->vlrbasecrdecsusp) ? number_format($infototadec->vlrbasecrdecsusp, 2, ',', '') : null,
                        false
                    );

                    $this->dom->addChild(
                        $totApurDec,
                        "vlrCRDecSusp",
                        !empty($infototadec->vlrcrdecsusp) ? number_format($infototadec->vlrcrdecsusp, 2, ',', '') : null,
                        false
                    );

                    $ideEstab->appendChild($totApurDec);

            	}
            }

            if (!empty($idstab->totapursem)) {	

            	foreach ($idstab->totapursem as $infototasem) {

            		$totApurSem = $this->dom->createElement("totApurSem");

            		$this->dom->addChild(
                        $totApurSem,
                        "perApurSem",
                        $infototasem->perapursem,
                        true
                    );
                    
                    $this->dom->addChild(
                        $totApurSem,
                        "CRSem",
                        $infototasem->crsem,
                        true
                    );

                    $this->dom->addChild(
                        $totApurSem,
                        "vlrBaseCRSem",
                        number_format($infototasem->vlrbasecrsem, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $totApurSem,
                        "vlrCRSem",
                        number_format($infototasem->vlrcrsem, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $totApurSem,
                        "vlrBaseCRSemSusp",
                        !empty($infototasem->vlrbasecrsemsusp) ? number_format($infototasem->vlrbasecrsemsusp, 2, ',', '') : null,
                        false
                    );

                    $this->dom->addChild(
                        $totApurSem,
                        "vlrCRSemSusp",
                        !empty($infototasem->vlrcrsemsusp) ? number_format($infototasem->vlrcrsemsusp, 2, ',', '') : null,
                        false
                    );

                    $ideEstab->appendChild($totApurSem);

            	}
            }

            if (!empty($idstab->totapurdia)) {	

            	foreach ($idstab->totapurdia as $infototadia) {

            		$totApurDia = $this->dom->createElement("totApurDia");

            		$this->dom->addChild(
                        $totApurDia,
                        "perApurDia",
                        $infototadia->perapurdia,
                        true
                    );
                    
                    $this->dom->addChild(
                        $totApurDia,
                        "CRDia",
                        $infototadia->crdia,
                        true
                    );

                    $this->dom->addChild(
                        $totApurDia,
                        "vlrBaseCRDia",
                        number_format($infototadia->vlrbasecrdia, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $totApurDia,
                        "vlrCRDia",
                        number_format($infototadia->vlrcrdia, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $totApurDia,
                        "vlrBaseCRDiaSusp",
                        !empty($infototadia->vlrbasecrdiasusp) ? number_format($infototadia->vlrbasecrdiasusp, 2, ',', '') : null,
                        false
                    );

                    $this->dom->addChild(
                        $totApurDia,
                        "vlrCRDiaSusp",
                        !empty($infototadia->vlrcrdiasusp) ? number_format($infototadia->vlrcrdiasusp, 2, ',', '') : null,
                        false
                    );

                    $ideEstab->appendChild($totApurSem);

            	}

            }
           
            $this->node->appendChild($infoTotal);

        }

        $this->reinf->appendChild($this->node);

        $this->sign($this->evtTag);

    }

}

?>