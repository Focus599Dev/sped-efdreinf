<?php 

namespace NFePHP\EFDReinf\Factories;

/**
* Class EFD-Reinf EvtTotal Event R-9001 constructor
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

class EvtTotal extends Factory implements FactoryInterface
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
        $params->evtName = 'evtTotal';
        $params->evtTag = 'evtTotal';
        $params->evtAlias = 'R-9001';
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
        $this->node->insert($ideEvento, $ideContri);

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

        $this->node->insert($ideContri, $ideRecRetorno);

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

        $inforev = $this->std->inforecev;

        $infoRecEv = $this->dom->createElement("infoRecEv");
        
        $this->dom->addChild(
            $infoRecEv,
            "nrProtEntr",
            $inforev->nrprotentr,
            true
        );

        $this->dom->addChild(
            $infoRecEv,
            "dhProcess",
            $inforev->dhprocess,
            true
        );

        $this->dom->addChild(
            $infoRecEv,
            "tpEv",
            $inforev->tpev,
            true
        );

        $this->dom->addChild(
            $infoRecEv,
            "idEv",
            $inforev->idev,
            true
        );

        $this->dom->addChild(
            $infoRecEv,
            "hash",
            $inforev->hash,
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

            if (!empty($idstab->RTom)) {
            	
            	$rt = $idstab->RTom;
                
            	$RTom = $this->dom->createElement("RTom");
            	
            	$this->dom->addChild(
            		$RTom,
            		"cnpjPrestador",
            		$rt->cnpjprestador,
            		true
            	);

            	$this->dom->addChild(
            		$RTom,
            		"cno",
            		!empty($rt->cno) ? $rt->cno : null,
            		false
            	);

            	$this->dom->addChild(
            		$RTom,
            		"vlrTotalBaseRet",
            		$rt->vlrtotalbaseret,
            		true
            	);

            	if (!empty($rt->infoCRTom)) {

            		foreach ($rt->infoCRTom as $infocrt) {
            			$infoCRTom = $this->dom->createElement("infoCRTom");

            			$this->dom->addChild(
            				$infoCRTom,
            				"CRTom",
            				$infocrt->crtom,
            				true           				
            			);

            			$this->dom->addChild(
            				$infoCRTom,
            				"vlrCRTom",
            				!empty($infocrt->vlrcrtom) ? number_format($infocrt->vlrcrtom, 2, ',', '') : null,
            				false
            			);

            			$this->dom->addChild(
            				$infoCRTom,
            				"vlrCRTomSusp",
            				!empty($infocrt->vlrcrtomsusp) ? number_format($infocrt->vlrcrtomsusp, 2, ',', '') : null,
            				false
            			)
            		}

            	}

            	$ideEstab->appendChild($RTom);

            }

            if (!empty($infot->rprest)) {

            	$rpres = $infot->rprest;

            	$RPrest = $this->dom->createElement("RPrest");

            	$this->dom->addChild(
            		$RPrest,
            		"tpInscTomador",
            		$rpres->tpinsctomador,
            		true

            	);

            	$this->dom->addChild(
            		$RPrest,
            		"nrInscTomador",
            		$rpres->nrinsctomador,
            		true
            	);

            	$this->dom->addChild(
            		$RPrest,
            		"vlrTotalBaseRet",
            		number_format($rpres->vlrtotalbaseret, 2, ',', ''),
            		true
            	);

            	$this->dom->addChild(
            		$RPrest,
            		"vlrTotalRetPrinc",
            		number_format($rpres->vlrtotalretprinc, 2, ',', ''),
            		true
            	);

            	$this->dom->addChild(
            		$RPrest,
            		"vlrTotalRetAdic",
            		!empty($rpres->vlrtotalretadic) ? number_format($rpres->vlrtotalretadic, 2, ',', '') : null,
            		false
            	);

            	$this->dom->addChild(
            		$RPrest,
            		"vlrTotalNRetPrinc",
            		!empty($rpres->vlrtotalnretprinc) ? number_format($rpres->vlrtotalnretprinc, 2, ',', '') : null,
            		false
            	);

            	$this->dom->addChild(
            		$RPrest,
            		"vlrTotalNRetAdic",
            		!empty($rpres->vlrtotalnretadic) ? number_format($rpres->vlrtotalnretadic, 2, ',', '') : null,
            		false
            	);

            	$ideEstab->appendChild($RPrest);

            }

            if (!empty($infot->rrecrepad)) {

            	foreach ($infot->rrecrepad as $inforrecrep) {
            		
            		$RRecRepAD = $this->dom->createElement("RRecRepAD");

            		$this->dom->addChild(
            			$RRecRepAD,
            			"cnpjAssocDesp",
            			$inforrecrep->cnpjassocdesp,
            			true
            		);

            		$this->dom->addChild(
            	    	$RRecRepAD,
            	    	"vlrTotalRep",
            	    	number_format($inforrecrep->vlrtotalrep, 2, ',', ''),
            	    	true
            	    );

            	    $this->dom->addChild(
            			$RRecRepAD,
            			"CRRecRepAD",
            			$inforrecrep->crrecrepad,
            			true
            		);

            		$this->dom->addChild(
            	    	$RRecRepAD,
            	    	"vlrCRRecRepAD",
            	    	number_format($inforrecrep->vlrcrrecrepad, 2, ',', ''),
            	    	true
            	    );

            	    $this->dom->addChild(
            	    	$RRecRepAD,
            	    	"vlrCRRecRepADSusp",
            	    	!empty($inforrecrep->vlrcrrecrepadsusp) ? number_format($inforrecrep->vlrcrrecrepadsusp, 2, ',', '') : null,
            	    	false
            	    );

            	    $ideEstab->appendChild($RRecRepAD);

            	}

            }

            if (!empty($infot->rcoml)) {

            	foreach ($infot->rcoml as $inforcoml) {

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
            			!empty($inforcoml->vlrcrcomlsusp) ? $inforcoml->vlrcrcomlsusp : null,
            			false
            		);

            		$ideEstab->appendChild($RComl);

            	}

            }

            if (!empty($infot->rcprb)) {

            	foreach ($infot->rcprb as $inforcp) {

            		$RCPRB = $this->dom->createElement("RCPRB");

            		$this->dom->addChild(
            			$RCPRB,
            			"CRCPRB",
            			$inforcp->crcprb,
            			true
            		);

            		$this->dom->addChild(
            			$RCPRB,
            			"vlrCRCPRB",
            			!empty($inforcp->vlrcrcprb) ? number_format($inforcp->vlrcrcprb, 2, ',', '') : null,
            			false
            		);

            		$this->dom->addChild(
            			$RCPRB,
            			"vlrCRCPRBSusp",
            			!empty($inforcp->vlrcrcprbsusp) ? number_format($inforcp->vlrcrcprbsusp, 2, ',', '') : null,
            			false
            		);

            		$ideEstab->appendChild($RCPRB);

            	}

            }

            if (!empty($infot->RRecEspetDesp)) {

            	$inforreced = $infot->RRecEspetDesp;

            	$RRecEspetDesp = $this->dom->createElement("RRecEspetDesp");

            	$this->dom->addChild(
            		$RRecEspetDesp,
            		"CRRecEspetDesp",
            		$inforreced->crrecespetdesp,
            		true
            	);

            	$this->dom->addChild(
            		$RRecEspetDesp,
            		"vlrReceitaTotal",
            		number_format($inforreced->vlrreceitatotal, 2, ',', ''),
            		true
            	);

            	$this->dom->addChild(
            		$RRecEspetDesp,
            		"vlrCRRecEspetDesp",
            		number_format($inforreced->vlrcrrecespetdesp, 2, ',', ''),
            		true
            	);

            	$this->dom->addChild(
            		$RRecEspetDesp,
            		"vlrCRRecEspetDespSusp",
            		!empty($inforreced->vlrcrrecespetdespsusp) ? number_format($inforreced->vlrcrrecespetdespsusp, 2, ',', '') : null,
            		false
            	);

            	$ideEstab->appendChild($RCPRB);
            	
            }

            $infoTotal->appendChild($ideEstab);

            $this->node->appendChild($infoTotal);


        }

}

?>