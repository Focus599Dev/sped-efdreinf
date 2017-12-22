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

use stdClass;

class EvtInfoContri{
    private $txt;
    
    private $ob;

    private $obParsed;

    public function __construct($txt){
    	$this->txt = $txt;

    	$this->obParsed = new stdClass();

    	$this->ob = $this->convertTxtToArray($txt);
    }

    private function convertTxtToArray($txt){

    	if (strlen($txt) > 0) {
            //carrega a matriz com as linha do arquivo
            $aDados = explode("\n", $txt);
        }

        $rows = array();

        foreach ( $aDados as $data) {
        	$rows[] = explode('|',$data);
        }

        return $rows;
    }

    public function convert(){

    	$this->obParsed->config = new stdClass();

    	$this->obParsed->config->tpAmb = $this->ob[1][1];
    	
    	$this->obParsed->config->verProc = $this->ob[1][3];

    	$this->obParsed->config->eventoVersion = '1_02_00';
    	
    	$this->obParsed->config->serviceVersion = '1_02_00';
    	
    	$this->obParsed->config->empregador = new stdClass();
    	
    	$this->obParsed->config->empregador->tpInsc = $this->ob[1][4];

    	$this->obParsed->config->empregador->nrInsc = substr(preg_replace('/\D/', '', $this->ob[0][0]), 0, 8);
    	
    	$this->obParsed->config->empregador->nmRazao = $this->ob[1][19];

    	$this->obParsed->config->transmissor = $this->obParsed->config->empregador;
    	
    	$this->obParsed->inivalid = $this->ob[1][6];
    	
    	$this->obParsed->fimValid = $this->ob[1][7];
    	
    	$this->obParsed->modo = $this->ob[0][1];
    	
    	$this->obParsed->idEvento = $this->ob[0][3];

    	$this->obParsed->infocadastro = new stdClass();

    	$this->obParsed->infocadastro->classtrib = $this->ob[1][8];

    	$this->obParsed->infocadastro->indescrituracao = $this->ob[1][9];

    	$this->obParsed->infocadastro->inddesoneracao = $this->ob[1][10];
    	
    	$this->obParsed->infocadastro->indacordoisenmulta = $this->ob[1][11];

    	$this->obParsed->infocadastro->indsitpj = $this->ob[1][12];

    	$this->obParsed->infocadastro->contato = new stdClass();

		$this->obParsed->infocadastro->contato->nmctt = $this->ob[1][13];
		
		$this->obParsed->infocadastro->contato->cpfctt = $this->ob[1][14];

		$this->obParsed->infocadastro->contato->fonefixo = $this->ob[1][15];
		
		$this->obParsed->infocadastro->contato->fonecel = $this->ob[1][16];

		$this->obParsed->infocadastro->contato->email = $this->ob[1][17];

		$this->obParsed->infocadastro->softhouse = array();
		
		$this->obParsed->infocadastro->softhouse[0] = new stdClass();

		$this->obParsed->infocadastro->softhouse[0]->cnpjsofthouse =  preg_replace('/\D/', '', $this->ob[1][18]);
		
		$this->obParsed->infocadastro->softhouse[0]->nmrazao = $this->ob[1][19];

		$this->obParsed->infocadastro->softhouse[0]->nmcont = $this->ob[1][20];

		$this->obParsed->infocadastro->softhouse[0]->telefone = $this->ob[1][21];

		$this->obParsed->infocadastro->softhouse[0]->email = $this->ob[1][22];

		$this->obParsed->infocadastro->infoefr = new stdClass();

		$this->obParsed->infocadastro->infoefr->ideefr = $this->ob[1][23];

		$this->obParsed->infocadastro->infoefr->cnpjEFR = $this->ob[1][24];

		return $this->obParsed;
    }
}

?>