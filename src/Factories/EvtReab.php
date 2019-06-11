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

class EvtReab extends Factory implements FactoryInterface
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

		$params->evtName = 'EvtReab';

		$params->evtTag = 'EvtReab';

		$params->evtAlias = 'R-4098';
        
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

        $this->reinf->appendChild($this->node);

        $this->sign($this->evtTag);

    }

}

?>