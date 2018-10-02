<?php 

namespace NFePHP\EFDReinf\Parses;


/**
 * Class EFD-Reinf EvtAssocDespRep Event R-2040 constructor
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

class EvtAssocDespRep extends Parse{

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

        $this->obParsed->nrrecibo = $this->ob[1][0];

        $this->obParsed->indretif = $this->ob[1][7];

        $this->obParsed->perapur = $this->ob[1][8];
        
        $this->obParsed->modo = $this->ob[0][1];
        
        $this->obParsed->idEvento = $this->ob[0][3];

        $this->obParsed->tpinscestab = $this->ob[1][9];

        $this->obParsed->nrinscestab = $this->ob[1][10];

        $this->obParsed->recursosrep = array();

        $index = 2;

        $lastRecursoResp = null;

        for ($i = $index; $i < count($this->ob); $i++){

            $auxOb = $this->ob[$i];

            $cabecario = $auxOb[0];

            if ($cabecario == 'RECURSOREP'){
                
                $aux = new stdClass();

                $aux->cnpjassocdesp = $auxOb[1];

                $aux->vlrtotalrep = $auxOb[2];
                
                $aux->vlrtotalret = $auxOb[3];
                
                $aux->vlrtotalnret = $auxOb[4];

                $this->obParsed->recursosrep[] = $aux;

                $lastRecursoResp = $aux;

            } else if ($cabecario == 'INFORECURSO'){

                $aux = new stdClass();

                if (!isset($lastRecursoResp->inforecurso)){
                    $lastRecursoResp->inforecurso = array();
                }

                $aux->tprepasse = $auxOb[1];
                
                $aux->descrecurso = $auxOb[2];
                
                $aux->vlrbruto = $auxOb[3];

                $aux->vlrretapur = $auxOb[4];

                $lastRecursoResp->inforecurso[] = $aux;

            }  else if ($cabecario == 'INFOPROC'){

                $aux = new stdClass();

                if (!isset($lastRecursoResp->infoproc)){
                    $lastRecursoResp->infoproc = array();
                }

                $aux->tpproc = $auxOb[1];
                
                $aux->nrproc = $auxOb[2];

                $aux->codsusp = $auxOb[3];

                $aux->vlrnret = $auxOb[4];

                $lastRecursoResp->infoproc[] = $aux;

            }
        }

        return $this->obParsed;
    }
}

?>