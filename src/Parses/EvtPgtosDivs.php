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
        
        $this->obParsed->codpgto = $this->ob[1][9];

        $this->obParsed->tpinscbenef = $this->ob[1][10];

        $this->obParsed->nrinscbenef = $this->ob[1][11];

        $this->obParsed->nmrazaobenef = $this->ob[1][12];

        $this->std->ideestab = array();

        $index = 2;

        $lastIdeeStab = null;

        $lastPgtopf = null;
        
        $lastPgtopj = null;

        $lastInforra = null;

        $lastInfoProcJud = null;
        
        $lastInfoProcJudPJ = null;

        for ($i = $index; $i < count($this->ob); $i++){
            
            $auxOb = $this->ob[$i];

            $cabecario = $auxOb[0];

            if ($cabecario == 'INFORESIDEXT'){

                $this->obParsed->inforesidext  = new stdClass();

                $this->obParsed->inforesidext->paisresid = $auxOb[1];
                
                $this->obParsed->inforesidext->dsclograd = $auxOb[2];

                $this->obParsed->inforesidext->nrlograd = $auxOb[3];

                $this->obParsed->inforesidext->complem = $auxOb[4];
                
                $this->obParsed->inforesidext->bairro = $auxOb[5];
                
                $this->obParsed->inforesidext->cidade = $auxOb[6];

                $this->obParsed->inforesidext->codpostal = $auxOb[7];

                $this->obParsed->inforesidext = $aux;

            } else if ($cabecario == 'INFOFISCALEXT'){

                if(!$this->obParsed->inforesidext){
                    $this->obParsed->inforesidext = new stdClass();
                }

                $this->obParsed->inforesidext->indnif = $auxOb[1];
                
                $this->obParsed->inforesidext->nifbenef = $auxOb[2];

                $this->obParsed->inforesidext->relfontepagad = $auxOb[3];

            } else if ($cabecario == 'INFOMOLESTIA'){

                $this->obParsed->infomolestia = new stdClass();

                $this->obParsed->infomolestia->dtlaudo = $auxOb[1];

            } else if ($cabecario == 'INFOPGTO'){

                $aux = new stdClass();

                $aux->tpinsc =  $auxOb[1];
                
                $aux->nrinsc =  $auxOb[2];

                $this->obParsed->ideestab[] = $aux;

                $lastIdeeStab =  $aux;

            }  else if ($cabecario == 'PGTOPF'){
                
                $aux = new stdClass();

                if (!isset($lastIdeeStab->pgtopf)){
                    
                    $lastIdeeStab->pgtopf = array();

                }

                $aux->dtpgto = $auxOb[1];

                $aux->indsuspexig = $auxOb[2];

                $aux->inddecterceiro = $auxOb[3];

                $aux->vlrrendtributavel = $auxOb[4];

                $aux->vlrirrf = $auxOb[5];
                
                $lastIdeeStab->pgtopf[] = $aux;

                $lastPgtopf = $aux;

            } else if ($cabecario == 'DETDEDUCAO'){
                
                $aux = new stdClass();
                
                if(!isset($lastPgtopf->detdeducao)){

                    $lastPgtopf->detdeducao = array();

                }

                $aux->indtpdeducao = $auxOb[1];

                $aux->vlrdeducao = $auxOb[2];

                $lastPgtopf->detdeducao[] = $aux;

            } else if ($cabecario == 'RENDISENTO'){
                
                $aux = new stdClass();
                
                if(!isset($lastPgtopf->rendisento)){

                    $lastPgtopf->rendisento = array();

                }

                $aux->tpisencao = $auxOb[1];

                $aux->vlrisento = $auxOb[2];
                
                $aux->descrendimento = $auxOb[3];

                $lastPgtopf->rendisento[] = $aux;

            } else if ($cabecario == 'DETCOMPET'){
                
                $aux = new stdClass();
                
                if(!isset($lastPgtopf->detcompet)){

                    $lastPgtopf->detcompet = array();

                }

                $aux->indperreferencia = $auxOb[1];

                $aux->perrefpagto = $auxOb[2];
                
                $aux->vlrrendtributavel = $auxOb[3];

                $lastPgtopf->detcompet[] = $aux;

            } else if ($cabecario == 'COMPJUD'){
                
                $aux = new stdClass();
                
                if(!isset($lastPgtopf->compjud)){

                    $lastPgtopf->compjud = array();

                }

                $aux->vlrcompqnocalend = $auxOb[1];

                $aux->vlrcompanoant = $auxOb[2];

                $lastPgtopf->compjud[] = $aux;
                
            } else if ($cabecario == 'INFORRA'){
                
                $aux = new stdClass();
                
                if(!isset($lastPgtopf->inforra)){

                    $lastPgtopf->inforra = array();

                }

                $aux->tpprocrra = $auxOb[1];

                $aux->nrprocrra = $auxOb[2];
                
                $aux->codsusp = $auxOb[3];

                $aux->natrra = $auxOb[4];

                $aux->qtdmesesrra = $auxOb[5];

                $lastPgtopf->inforra[] = $aux;
                
                $lastInforra = $aux;
            }  else if ($cabecario == 'DESPPROCJUD'){
                
                $aux = new stdClass();
                
                if(!isset($lastInforra->despprocjud)){

                   $lastInforra->despprocjud = new stdClass();

                }

                $aux->vlrdespcustas = $auxOb[1];

                $aux->vlrdespadvogados = $auxOb[2];

                $lastInforra->despprocjud = $aux;

            } else if ($cabecario == 'IDEADVOGADOINRRA'){
                
                $aux = new stdClass();
                
                if(!isset($lastInforra->despprocjud->ideadvogado)){

                   $lastInforra->despprocjud->ideadvogado = array();

                }

                $aux->tpinscadvogado = $auxOb[1];

                $aux->nrinscadvogado = $auxOb[2];
                
                $aux->vlradvogado = $auxOb[3];

                $lastInforra->despprocjud->ideadvogado[] = $aux;

            }  else if ($cabecario == 'INFOPROCJUD'){
                
                $aux = new stdClass();
                
                if(!isset($lastPgtopf->infoprocjud)){

                    $lastPgtopf->infoprocjud = array();

                }

                $aux->nrprocjud = $auxOb[1];

                $aux->codsusp = $auxOb[2];
                
                $aux->indorigemrecursos = $auxOb[3];

                $lastPgtopf->infoprocjud[] = $aux;

                $lastInfoProcJud = $aux;

            } else if ($cabecario == 'DESPPROCJUDINFOPROC'){

                $aux = new stdClass();

                if (!isset($lastInfoProcJud->despprocjud)){
                    
                    $lastInfoProcJud->despprocjud = array();

                }

                $aux->vlrDespCustas = $auxOb[1];
                
                $aux->vlrDespAdvogados = $auxOb[2];

                $lastInfoProcJud->despprocjud[] = $aux;

            } else if ($cabecario == 'IDEADVOGADOPROCJUD'){

                $aux = new stdClass();

                if (!isset($lastInfoProcJud->despprocjud->ideadvogado)){
                    
                    $lastInfoProcJud->despprocjud->ideadvogado = array();

                }

                $aux->tpinscadvogado = $auxOb[1];
                
                $aux->nrinscadvogado = $auxOb[2];

                $aux->vlradvogado = $auxOb[3];

                $lastInfoProcJud->despprocjud->ideadvogado[] = $aux;

            }  else if ($cabecario == 'ORIGEMRECURSOS'){

                if (!isset($lastInfoProcJud->origemrecursos)){
                    
                    $lastInfoProcJud->origemrecursos = new stdClass();

                }

                $lastInfoProcJud->origemrecursos->cnpjorigemrecursos = $auxOb[1];
                
            } else if ($cabecario == 'DEPJUDICIAL'){
                
                if(!isset($lastPgtopf->depjudicial)){

                    $lastPgtopf->depjudicial = new stdClass();

                }

                $lastPgtopf->depjudicial->vlrdepjudicial = $auxOb[1];
  
            } else if ($cabecario == 'PGTOPJ'){

                $aux = new stdClass();

                if (!isset($lastIdeeStab->pgtopj)){
                    
                    $lastIdeeStab->pgtopj = array();

                }

                $aux->dtpagto = $auxOb[1];

                $aux->vlrrendtributavel = $auxOb[2];

                $aux->vlrret = $auxOb[3];
                
                $lastIdeeStab->pgtopj[] = $aux;

                $lastPgtopj = $aux;

            } else if ($cabecario == 'INFOPROCJUDPJ'){

                $aux = new stdClass();

                if (!isset($lastPgtopj->infoprocjud)){
                    
                    $lastPgtopj->infoprocjud = array();

                }

                $aux->nrprocjud = $auxOb[1];
                
                $aux->codsusp = $auxOb[2];

                $aux->indorigemrecursos = $auxOb[3];
                
                $aux->despprocjud = new stdClass();

                $aux->despprocjud->vlrdespcustas = $auxOb[4];

                $aux->despprocjud->vlrdespadvogados = $auxOb[5];

                $lastPgtopj->infoprocjud[] = $aux;

                $lastInfoProcJudPJ = $aux;

            } else if ($cabecario == 'IDEADVOGADOPJ'){

                $aux = new stdClass();

                if (!isset($lastInfoProcJudPJ->despprocjud->ideadvogado)){
                    $lastInfoProcJudPJ->despprocjud->ideadvogado = array();
                }

                $aux->tpinscadvogado = $auxOb[1];
                
                $aux->nrinscadvogado = $auxOb[2];

                $aux->vlradvogado = $auxOb[2];

                $lastInfoProcJudPJ->despprocjud->ideadvogado[] = $aux;
                
            }  else if ($cabecario == 'ORIGEMRECURSOSPJ'){

                $aux = new stdClass();

                if (!isset($lastPgtopj->origemrecursos)){
                    
                    $lastPgtopj->origemrecursos = new stdClass();

                }

                $lastPgtopj->origemrecursos->cnpjorigemrecursos = $auxOb[1];

            } else if ($cabecario == 'PGTORESIDEXT'){

                if (!isset($lastIdeeStab->pgtoresidext)){
                    
                    $lastIdeeStab->pgtoresidext = new stdClass();

                }

                $lastIdeeStab->pgtoresidext->dtpagto = $auxOb[1];

                $lastIdeeStab->pgtoresidext->tprendimento = $auxOb[2];

                $lastIdeeStab->pgtoresidext->formatributacao = $auxOb[3];

                $lastIdeeStab->pgtoresidext->vlrpgtovlrpgto = $auxOb[4];

                $lastIdeeStab->pgtoresidext->vlrret = $auxOb[5];

            }

        }

		return $this->obParsed;
    }
}

?>