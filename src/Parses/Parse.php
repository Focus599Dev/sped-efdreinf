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

class Parse{
    protected $txt;
    
    protected $ob;

    protected $obParsed;

    protected $eventoVersion;

    protected $serviceVersion;

    public function __construct($txt){

    	$this->txt = $txt;

    	$this->obParsed = new stdClass();

    	$this->ob = $this->convertTxtToArray($txt);

        $this->eventoVersion = '2_00_00';

        $this->serviceVersion = '2_00_00';
    }

    protected function convertTxtToArray($txt){

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

    public function getTxtArray(){
        return $this->ob;
    }
}

?>