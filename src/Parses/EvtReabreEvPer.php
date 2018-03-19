<?php 

namespace NFePHP\EFDReinf\Parses;

/**
 * Class EFD-Reinf EvtInfoContri Event R-1000 constructor
 *
 * @category  API
 * @package   NFePHP\EFDReinf
 * @copyright FocusIt (c) 2017
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Marlon O. Barboda <marlon.academi@gmail.com>
 * @link      https://github.com/Focus599Dev/sped-efdreinf for the canonical source repository
 */

use NFePHP\EFDReinf\Parses\Parse;
use stdClass;

class EvtReabreEvPer extends Parse {
  
    public function convert(){

    	$this->obParsed->config = new stdClass();

    	$this->obParsed->config->tpAmb = $this->ob[1][1];
    	
    	$this->obParsed->config->verProc = $this->ob[1][3];

    	$this->obParsed->config->eventoVersion = $this->eventoVersion;
        
        $this->obParsed->config->serviceVersion = $this->serviceVersion;
    	
    	$this->obParsed->config->empregador = new stdClass();
    	
    	$this->obParsed->config->empregador->tpInsc = $this->ob[1][4];

    	$this->obParsed->config->empregador->nrInsc = substr(preg_replace('/\D/', '', $this->ob[0][0]), 0, 8);

    	$this->obParsed->config->transmissor = $this->obParsed->config->empregador;
    	
    	$this->obParsed->modo = $this->ob[0][1];
    	
    	$this->obParsed->idEvento = $this->ob[0][3];

        $this->obParsed->config->empregador->nmRazao = $this->ob[1][6];

        $this->obParsed->perapur = $this->ob[1][7];

		return $this->obParsed;
    }
}

?>