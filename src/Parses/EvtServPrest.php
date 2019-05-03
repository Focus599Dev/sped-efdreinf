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

class EvtServPrest extends Parse {
  
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

        $this->obParsed->indretif = $this->ob[1][7];

        $this->obParsed->nrrecibo = $this->ob[1][0];

        $this->obParsed->perapur = $this->ob[1][8];

        $this->obParsed->tpinscestabprest = $this->ob[1][9];

        $this->obParsed->nrinscestabprest = $this->ob[1][10];
        
        $this->obParsed->tpinsctomador = $this->ob[1][11];
        
        $this->obParsed->nrinsctomador = $this->ob[1][12];

        $this->obParsed->indobra = $this->ob[1][13];

        $this->obParsed->vlrtotalbruto = $this->ob[1][14];

        $this->obParsed->vlrtotalbaseret = $this->ob[1][15];

        $this->obParsed->vlrtotalretprinc = $this->ob[1][16];

        $this->obParsed->vlrtotalretadic = $this->ob[1][17];

        $this->obParsed->vlrtotalnretprinc = $this->ob[1][18];
        
        $this->obParsed->vlrtotalnretadic = $this->ob[1][19];

        $index = 2;

        $this->obParsed->nfs = array();
        
        $this->obParsed->infoprocretpr = array();
        
        $this->obParsed->infoprocretad = array();

        $lastNFS = null;

        for ($i = $index; $i < count($this->ob); $i++){
            
            $auxOb = $this->ob[$i];

            $cabecario = $auxOb[0];

            if ($cabecario == 'NFS'){

                $aux = new stdClass();

                $aux->serie = $auxOb[1];
                
                $aux->numdocto = $auxOb[2];

                $aux->dtemissaonf = $auxOb[3];

                $aux->vlrbruto = $auxOb[4];
                
                $aux->obs = $auxOb[5];

                $this->obParsed->nfs[] = $aux;

                $lastNFS =  $aux;

            } else if ($cabecario == 'TPSERVICE'){

                $aux = new stdClass();

                if (!isset($lastNFS->infotpserv)){
                    $lastNFS->infotpserv = array();
                }

                $aux->tpservico = $auxOb[1];

                $aux->vlrbaseret = $auxOb[2];
                
                $aux->vlrretencao = $auxOb[3];

                $aux->vlrretsub = $auxOb[4];
                
                $aux->vlrnretprinc = $auxOb[5];
                
                $aux->vlrservicos15 = $auxOb[6];

                $aux->vlrservicos20 = $auxOb[7];

                $aux->vlrservicos25 = $auxOb[8];

                $aux->vlradicional = $auxOb[9];
                
                $aux->vlrnretadic = $auxOb[10];

                $lastNFS->infotpserv[] = $aux;

            } else if ($cabecario == 'PROCRET'){

                $aux = new stdClass();

                $aux->tpprocretprinc = $auxOb[1];
                
                $aux->nrprocretprinc = $auxOb[2];

                $aux->codsuspprinc = $auxOb[3];

                $aux->valorprinc = $auxOb[4];

                $this->obParsed->infoprocretpr[] = $aux;

            } else if ($cabecario == 'PROCRETADIC'){

                $aux = new stdClass();

                $aux->tpprocretadic = $auxOb[1];
                
                $aux->nrprocretadic = $auxOb[2];

                $aux->codsuspadic = $auxOb[3];

                $aux->valoradic = $auxOb[4];

                $this->obParsed->infoprocretad[] = $aux;
            }

        }

		return $this->obParsed;
    }
}

?>