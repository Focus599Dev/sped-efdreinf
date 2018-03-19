<?php 

namespace NFePHP\EFDReinf\Parses;

/**
 * Class EFD-Reinf EvtTabProcesso Event R-1070 constructor
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

class EvtTabProcesso extends Parse{

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
    	
    	$this->obParsed->inivalid = $this->ob[1][6];
    	
    	$this->obParsed->fimValid = $this->ob[1][7];
    	
    	$this->obParsed->modo = $this->ob[0][1];

        $this->obParsed->idEvento = $this->ob[0][3];

        $this->obParsed->tpproc = intval($this->ob[1][8]);
    	
        $this->obParsed->nrproc = $this->ob[1][9];

        $this->obParsed->infosusp = array();

        if ($this->obParsed->modo == 'EXCLUSAO'){
            
            $this->obParsed->config->empregador->nmRazao = $this->ob[1][10];            

        } else {

            $this->obParsed->config->empregador->nmRazao = $this->ob[1][18];

            $this->obParsed->indautoria = intval($this->ob[1][10]);

            $this->obParsed->infosusp[0] = new stdClass();

            $this->obParsed->infosusp[0]->codsusp = $this->ob[1][11];

            $this->obParsed->infosusp[0]->indsusp = $this->ob[1][12];

            $this->obParsed->infosusp[0]->dtdecisao = $this->ob[1][13];

            $this->obParsed->infosusp[0]->inddeposito = $this->ob[1][14];
            
            $this->obParsed->dadosprocjud  = new stdClass();

            $this->obParsed->dadosprocjud->ufvara  = $this->ob[1][15];

            $this->obParsed->dadosprocjud->codmunic  = $this->ob[1][16];

            $this->obParsed->dadosprocjud->idvara  = $this->ob[1][17];

            if (isset($this->ob[1][19]) && $this->ob[1][19] == 'NOVA_VALIDADE'){

                $this->obParsed->novavalidade  = new stdClass();
                
                $this->obParsed->novavalidade->inivalid  = $this->ob[1][20];
                
                $this->obParsed->novavalidade->fimvalid  = $this->ob[1][21];

            }

        }

		return $this->obParsed;
    }
}

?>