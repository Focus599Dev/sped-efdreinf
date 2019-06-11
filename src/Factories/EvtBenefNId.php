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

class EvtBenefNId extends Factory implements FactoryInterface
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

		$params->evtName = 'evtBenefNId';

		$params->evtTag = 'evtBenefNId';

		$params->evtAlias = 'R-4040';
        
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

        foreach ($ides->idenat as $inat) {
        	
        	$ideNat = $this->dom->createElement("ideNat");

        	$this->dom->addChild(
                $ideNat,
                "natRendim",
                $inat->natrendim,
                true
            );

            foreach ($inat->infopgto as $infop) {
            	
            	$infoPgto = $this->dom->createElement("infoPgto");

            	$this->dom->addChild(
                    $infoPgto,
                    "dtFG",
                    $infop->dtfg,
                    true
                );

                $this->dom->addChild(
                    $infoPgto,
                    "vlrLiq",
                    number_format($infop->vlrliq, 2, ',', ''), 
                    true
                );

                $this->dom->addChild(
                    $infoPgto,
                    "vlrReaj",
                    number_format($infop->vlreaj, 2, ',', ''), 
                    true
                );

                $this->dom->addChild(
                    $infoPgto,
                    "vlrIR",
                    number_format($infop->vlrir, 2, ',', ''), 
                    true
                );

                $this->dom->addChild(
                    $infoPgto,
                    "descr",
                    $infop->descr,
                    true
                );

                $ideNat->appendChild($infoPgto);

            }

            $ideEstab->appendChild($ideNat);

        }

        $this->node->appendChild($ideEstab);

        $this->reinf->appendChild($this->node);

        $this->sign($this->evtTag);
    }

}

?>