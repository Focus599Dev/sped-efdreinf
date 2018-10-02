<?php 

namespace NFePHP\EFDReinf\Parses;


/**
 * Class EFD-Reinf EvtCPRB Event R-1060 constructor
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

class EvtCPRB extends Parse{

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
    	
        $this->obParsed->config->empregador->nmRazao = $this->ob[1][6];

        $this->obParsed->indretif = $this->ob[1][7];

        $this->obParsed->perapur = $this->ob[1][8];
    	
    	$this->obParsed->modo = $this->ob[0][1];
    	
    	$this->obParsed->idEvento = $this->ob[0][3];

        $this->obParsed->tpinscestab = $this->ob[1][9];

        $this->obParsed->nrinscestab = $this->ob[1][10];

        $this->obParsed->vlrrecbrutatotal = $this->ob[1][11];

        $this->obParsed->vlrcpapurtotal = $this->ob[1][12];

        $this->obParsed->vlrcprbsusptotal = $this->ob[1][13];

        $this->obParsed->tipocod = array();

        $index = 2;

        $lastTipoCod = null;

        for ($i = $index; $i < count($this->ob); $i++){

            $auxOb = $this->ob[$i];

            $cabecario = $auxOb[0];

            if ($cabecario == 'TIPOCOD'){
                
                $aux = new stdClass();

                $aux->codativecon = $auxOb[1];

                $aux->vlrrecbrutaativ = $auxOb[2];

                $aux->vlrexcrecbruta = $auxOb[3];
                
                $aux->vlradicrecbruta = $auxOb[4];

                $aux->vlrbccprb = $auxOb[5];

                $aux->vlrcprbapur = $auxOb[6];

                $this->obParsed->tipocod[] = $aux;

                $lastTipoCod = $aux;

            } else if ($cabecario == 'TIPOAJUSTE'){

                $aux = new stdClass();

                if (!isset($lastTipoCod->tipoajuste)){
                    $lastTipoCod->tipoajuste = array();
                }

                $aux->tpajuste = $auxOb[1];
                
                $aux->codajuste = $auxOb[2];
                
                $aux->vlrajuste = $auxOb[3];

                $aux->descajuste = $auxOb[4];
                
                $aux->dtajuste = $auxOb[5];

                $lastTipoCod->tipoajuste[] = $aux;

            }  else if ($cabecario == 'INFOPROC'){

                $aux = new stdClass();

                if (!isset($lastTipoCod->infoproc)){
                    $lastTipoCod->infoproc = array();
                }

                $aux->tpproc = $auxOb[1];
                
                $aux->nrproc = $auxOb[2];

                $aux->codsusp = $auxOb[3];

                $aux->vlrcprbsusp = $auxOb[4];

                $lastTipoCod->infoproc[] = $aux;

            }
        }

		return $this->obParsed;
    }
}

?>