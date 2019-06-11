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

class EvtTotalContrib extends Factory implements FactoryInterface
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
        
        $params->evtName = 'evtTotalContrib';
        
        $params->evtTag = 'evtTotalContrib';
        
        $params->evtAlias = 'R-9011';

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
        	"perApur",
        	$this->std->perapur,
        	true
        );

        $this->node->insert($ideEvento,$ideContri);

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

        $this->node->insertBefore($infoRecEv, $infoTotalContrib);

        if(!empty($this->std->infototalcontrib)){

        	$infoevtcon = $this->std->infototalcontrib;

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

            if(!empty($infoevtcon->$RTom)) {

            	foreach ($infoevtcon->$RTom as $infortom) {

            		$RTom = $this->dom->createElement("RTom");

            		$this->dom->addChild(
                        $RTom,
                        "cnpjPrestador",
                        $infortom->cnpjprestador,
                        true
                    );

                    $this->dom->addChild(
                        $RTom,
                        "cno",
                        !empty($infortom->cno) ? $infortom->cno : null,
                        false
                    );

                    $this->dom->addChild(
                        $RTom,
                        "vlrTotalBaseRet",
                        $infortom->vlrtotalbaseret,
                        true
                    );

                    if(!empty($infortom->infoCRTom)) {

                    	foreach ($infortom->infoCRTom as $infocrtom) {

                    		$infoCRTom = $this->dom->createElement("infoCRTom");

                    		$this->dom->addChild(
                                $infoCRTom,
                                "CRTom",
                                $infocrtom->crtom,
                                true
                            );

                            $this->dom->addChild(
                                $infoCRTom,
                                "vlrCRTom",
                                empty($infocrtom->vlrcrtom) ? number_format($infocrtom->vlrcrtom, 2, ',', '') : null,
                                false
                            );

                            $this->dom->addChild(
                                $infoCRTom,
                                "vlrCRTomSusp",
                                empty($infocrtom->vlrcrtomsusp) ? number_format($infocrtom->vlrcrtomsusp, 2, ',', '') : null,
                                false
                            );

                            $RTom->appendChild($infoCRTom);

                    	}

                    }
            	    
            	    $infoTotalContrib->appendChild($RTom);

            	}

            }

            if (!empty($infoevtcon->rprest)) {

            	foreach ($infoevtcon->rprest as $infototalrprest) {

            		$RPrest = $this->dom->createElement("RPrest");

            		$this->dom->addChild(
                        $RPrest,
                        "tpInscTomador",
                        $infototalrprest->tpinsctomador,
                        true
                    );

            		$this->dom->addChild(
                        $RPrest,
                        "nrInscTomador",
                        $infototalrprest->nrinsctomador,
                        true
                    );

                    $this->dom->addChild(
                        $RPrest,
                        "vlrTotalBaseRet",
                        number_format($infototalrprest->vlrtotalbaseret, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $RPrest,
                        "vlrTotalRetPrinc",
                        number_format($infototalrprest->vlrtotalretprinc, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $RPrest,
                        "vlrTotalRetAdic",
                        !empty($infototalrprest->vlrtotalretadic) ? number_format($infototalrprest->vlrtotalretadic, 2, ',', '') : null,
                        false
                    );

                    $this->dom->addChild(
                        $RPrest,
                        "vlrTotalNRetPrinc",
                        !empty($infototalrprest->vlrtotalnretprinc) ? number_format($infototalrprest->vlrtotalnretprinc, 2, ',', '') : null,
                        false
                    );

                    $this->dom->addChild(
                        $RPrest,
                        "vlrTotalNRetAdic",
                        !empty($infototalrprest->vlrtotalnretadic) ? number_format($infototalrprest->vlrtotalnretadic, 2, ',', '') : null,
                        false
                    );

                    $infoTotalContrib->appendChild("RPrest");

            	}
            }

            if (!empty($infoevtcon->rrecrepad)) {

            	foreach ($infoevtcon->rrecrepad as $inforrecrpad) {

            		$RRecRepAD = $this->dom->createElement("RRecRepAD");

            		$this->dom->addChild(
                        $RRecRepAD,
                        "CRRecRepAD",
                        $inforrecrpad->CRRecRepAD,
                        true
                    );

                    $this->dom->addChild(
                        $RRecRepAD,
                        "vlrCRRecRepAD",
                        number_format($inforrecrpad->vlrCRRecRepAD, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $RRecRepAD,
                        "vlrCRRecRepADSusp",
                        !empty($inforrecrpad->vlrcrrecrepadsusp) ? number_format($inforrecrpad->vlrcrrecrepadsusp, 2, ',', '') : null,
                        false
                    );

                    $infoTotalContrib->appendChild($RRecRepAD);
            	}

            }

            if (!empty($infoevtcon->rcoml)) {

            	foreach ($infoevtcon->rcoml as $inforcoml) {

            		$RComl = $this->dom->createElement("RComl");

            		$this->dom->addChild(
                        $RComl,
                        "CRComl",
                        $inforcoml->crcoml,
                        true
                    );

                    $this->dom->addChild(
                        $RComl,
                        "vlrCRComl",
                        number_format($inforcoml->vlrcrcoml, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $RComl,
                        "vlrCRComlSusp",
                        !empty($inforcoml->vlrcrcomlsusp) ? number_format($inforcoml->vlrcrcomlsusp, 2, ',', '') : null,
                        false
                    );

                    $infoTotalContrib->appendChild($RComl);

            	}

            }

            if (!empty($infoevtcon->RCPRB)) {

            	foreach ($infoevtcon->RCPRB as $inforcprb) {

            		$RCPRB = $this->dom->createElement("RCPRB");

            		$this->dom->addChild(
                        $RCPRB,
                        "CRCPRB",
                        $inforcprb->CRCPRB,
                        true
                    );

                    $this->dom->addChild(
                        $RCPRB,
                        "vlrCRCPRB",
                        number_format($inforcprb->vlrCRCPRB, 2, ',', ''),
                        true
                    );

                    $this->dom->addChild(
                        $RCPRB,
                        "vlrCRCPRBSusp",
                        !empty($inforcprb->vlrCRCPRBSusp) ? number_format($inforcprb->vlrCRCPRBSusp, 2, ',', '') : null,
                        false
                    );

                    $infoTotalContrib->appendChild($RCPRB);
            	}

            }

            $this->node->appendChild($infoTotalContrib);

        }

        $this->reinf->appendChild($this->node);

        $this->sign($this->evtTag);
        
    }

}

?>