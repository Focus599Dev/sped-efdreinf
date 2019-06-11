<?php

namespace NFePHP\EFDReinf\Factories;

/**
*
*/

use NFePHP\EFDReinf\Common\Factory;
use NFePHP\EFDReinf\Common\FactoryInterface;
use NFePHP\EFDReinf\Common\FactoryId;
use NFePHP\Common\Certificate;
use stdClass;

class EvtRetCons extends Factory implements FactoryInterface
{

	/**
     * Constructor
     * @param string $config
     * @param stdClass $std
     * @param Certificate $certificate
     * @param string $data
     */
    public function __construct(
        $config,
        stdClass $std,
        Certificate $certificate = null,
        $data = ''
    ) {
        $params = new \stdClass();
        $params->evtName = 'evtRetCons';
        $params->evtTag = 'evtRetCons';
        $params->evtAlias = 'R-9012';
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
            "nmRazao",
            $this->std->nmrazao,
            true
        );

        $this->dom->addChild(
            $ideEvento,
            "perApur",
            $this->std->perapur,
            true
        );

        $this->node->insertBefore($ideEvento, $ideContri);

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

        $this->node->insertBefore($ideContri, $ideRecRetorno);
        $ideRecRetorno = $this->dom->createElement("ideRecRetorno");

        $ideStatus = $this->dom->createElement("ideStatus");

        $infoista = $ideRecRetorno->ideStatus;

        $this->dom->addChild(
            $ideStatus,
            "cdRetorno",
            $infoista->cdretorno,
            true
        );

        $this->dom->addChild(
            $ideStatus,
            "descretorno",
            $infoista->descretorno,
            true
        );

        if (!empty($infoista->regocorrs)) {

        	foreach ($infoista->regocorrs as $r) {

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

        $this->node->insertBefore($ideRecRetorno, $infoRecEv);

        $infoREv = $this->std->infoRecEv;

        $infoTotal = $this->dom->createElement("infoRecEv");

        $this->dom->addChild(
            $infoRecEv,
            "nrProtEntr",
            $infoREv->nrprotentr,
            true
        );

        $this->dom->addChild(
            $infoRecEv,
            "dhProcess",
            $infoREv->dhprocess,
            true
        );

        $this->dom->addChild(
            $infoRecEv,
            "tpEv",
            $infoREv->tpev,
            true
        );

        $this->dom->addChild(
            $infoRecEv,
            "idEv",
            $infoREv->idev,
            true
        );

        $this->dom->addChild(
            $infoRecEv,
            "hash",
            $infoREv->hash,
            true
        );

        if (!empty($infoREv->infototalcontrib)) {

        	$infoevtcon = $infoREv->infototalcontrib;

        	$infoTotalContrib = $this->dom->createElement("infoTotalContrib");

        	$this->dom->addChild(
                $infoTotalContrib,
                "nrRecArqBase",
                !empty($infoevtcon->nrrecarqbase) ? $infoevtcon->nrrecarqbase : null,
                false
            );

            $this->dom->addChild(
                $infoTotalContrib,
                "indExistInfo",
                $infoevtcon->indexistinfo,
                true
            );

            if (!empty($infoevtcon->totapurmen)) {

            	foreach ($infoevtcon->totapurmen as $infototapmen) {

            		$totApurMen = $this->dom->createElement("totApurMen");

            		$this->dom->addChild(
                        $totApurMen,
                        "CRMen",
                        $infototapmen->crmen,
                        true
                    );

                    $this->dom->addChild(
                        $totApurMen,
                        "vlrBaseCRMen",
                        number_format($infototapmen->vlrbasecrmen, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $totApurMen,
                        "vlrCRMen",
                        number_format($infototapmen->vlrcrmen, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $totApurMen,
                        "vlrBaseCRMenSusp",
                        !empty($infototapmen->vlrbasecrmensusp) ? number_format($infototapmen->vlrbasecrmensusp, 2, ',', '') : null,
                        false
                    );

                    $this->dom->addChild(
                        $totApurMen,
                        "vlrCRMenSusp",
                        !empty($infototapmen->vlrcrmensusp) ? number_format($infototapmen->vlrcrmensusp, 2, ',', '') : null,
                        false
                    );

                    $infoTotalContrib->appendChild($totApurMen);

            	}

            }

            if (!empty($infoevtcon->totapurqui)) {

            	foreach ($infoevtcon->totapurqui as $infototapqui) {

            		$totApurQui = $this->dom->createElement("totApurQui");

            		$this->dom->addChild(
                        $totApurQui,
                        "perApurQui",
                        $infototapqui->perapurqui,
                        true
                    );

            		$this->dom->addChild(
                        $totApurQui,
                        "CRQui",
                        $infototapqui->crqui,
                        true
                    );

                    $this->dom->addChild(
                        $totApurQui,
                        "vlrBaseCRQui",
                        number_format($infototapqui->vlrbasecrqui, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $totApurQui,
                        "vlrCRQui",
                        number_format($infototapqui->vlrcrqui, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $totApurQui,
                        "vlrBaseCRQuiSusp",
                        !empty($infototapqui->vlrbasecrquisusp) ? number_format($infototapqui->vlrbasecrquisusp, 2, ',', '') : null,
                        false
                    );

                    $this->dom->addChild(
                        $totApurQui,
                        "vlrCRQuiSusp",
                        !empty($infototapqui->vlrcrquisusp) ? number_format($infototapqui->vlrcrquisusp, 2, ',', '') : null,
                        false
                    );

                    $infoTotalContrib->appendChild($totApurQui);

            	}

            }

            if (!empty($infoevtcon->totapurdec)) {

            	foreach ($infoevtcon->totapurdec as $infototapdec) {

            		$totApurDec = $this->dom->createElement("totApurDec");

            		$this->dom->addChild(
                        $totApurDec,
                        "perApurDec",
                        $infototapdec->perapurdec,
                        true
                    );

            		$this->dom->addChild(
                        $totApurDec,
                        "CRDec",
                        $infototapdec->crdec,
                        true
                    );

                    $this->dom->addChild(
                        $totApurDec,
                        "vlrBaseCRDec",
                        number_format($infototapdec->vlrbasecrdec, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $totApurDec,
                        "vlrCRDec",
                        number_format($infototapdec->vlrcrdec, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $totApurDec,
                        "vlrBaseCRDecSusp",
                        !empty($infototapdec->vlrbasecrdecsusp) ? number_format($infototapdec->vlrbasecrdecsusp, 2, ',', '') : null,
                        false
                    );

                    $this->dom->addChild(
                        $totApurDec,
                        "vlrCRDecSusp",
                        !empty($infototapdec->vlrcrdecsusp) ? number_format($infototapdec->vlrcrdecsusp, 2, ',', '') : null,
                        false
                    );

                    $infoTotalContrib->appendChild($totApurQui);

            	}

            }

            if (!empty($infoevtcon->totapursem)) {

            	foreach ($infoevtcon->totapursem as $infototapsem) {

            		$totApurSem = $this->dom->createElement("totApurSem");

            		$this->dom->addChild(
                        $totApurSem,
                        "perApurSem",
                        $infototapsem->perapursem,
                        true
                    );

            		$this->dom->addChild(
                        $totApurSem,
                        "CRSem",
                        $infototapsem->crsem,
                        true
                    );

                    $this->dom->addChild(
                        $totApurSem,
                        "vlrBaseCRSem",
                        number_format($infototapsem->vlrbasecrsem, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $totApurSem,
                        "vlrCRSem",
                        number_format($infototapsem->vlrCRSem, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $totApurSem,
                        "vlrBaseCRSemSusp",
                        !empty($infototapsem->vlrbasecrsemsusp) ? number_format($infototapsem->vlrbasecrsemsusp, 2, ',', '') : null,
                        false
                    );

                    $this->dom->addChild(
                        $totApurSem,
                        "vlrCRSemSusp",
                        !empty($infototapsem->vlrcrsemsusp) ? number_format($infototapsem->vlrcrsemsusp, 2, ',', '') : null,
                        false
                    );

                    $infoTotalContrib->appendChild($totApurSem);

            	}

            }

            if (!empty($infoevtcon->totapurdia)) {

            	foreach ($infoevtcon->totapurdia as $infototapdia) {

            		$totApurDia = $this->dom->createElement("totApurDia");

            		$this->dom->addChild(
                        $totApurDia,
                        "perApurDia",
                        $infototapdia->perapurdia,
                        true
                    );

            		$this->dom->addChild(
                        $totApurDia,
                        "CRDia",
                        $infototapdia->crdia,
                        true
                    );

                    $this->dom->addChild(
                        $totApurDia,
                        "vlrBaseCRDia",
                        number_format($infototapdia->vlrbasecrdia, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $totApurDia,
                        "vlrCRDia",
                        number_format($infototapdia->vlrcrdia, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $totApurDia,
                        "vlrBaseCRDiaSusp",
                        !empty($infototapdia->vlrbasecrdiasusp) ? number_format($infototapdia->vlrbasecrdiasusp, 2, ',', '') : null,
                        false
                    );

                    $this->dom->addChild(
                        $totApurDia,
                        "vlrCRDiaSusp",
                        !empty($infototapdia->vlrcrdiasusp) ? number_format($infototapdia->vlrcrdiasusp, 2, ',', '') : null,
                        false
                    );

                    $infoTotalContrib->appendChild($totApurDia);
            	
            	}

            }

            $this->node->appendChild($infoTotalContrib);
        }

        $this->reinf->appendChild($this->node);

        $this->sign($this->evtTag);

    }

}
?>