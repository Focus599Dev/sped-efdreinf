<?php 

namespace NFePHP\EFDReinf;

/**
 * Class efdReinf Parse post
 *
 * @category  API
 * @package   NFePHP\EFDReinf
 * @copyright FocusIt (c) 2017
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Marlon O. Barbosa <marlon.academi@gmail.com>
 * @link      https://github.com/Focus599Dev/sped-efdreinf for the canonical source repository
 */

use NFePHP\EFDReinf\Exception\ParseException;

class Parse{
 	
 	/**
     * Relationship between the name of the event and its respective class
     * @var array
     */
    private static $available = [
        'evtinfocontri' => Parses\EvtInfoContri::class,
        'evttabprocesso' => Parses\EvtTabProcesso::class,
        'evtservtom' => Parses\EvtServTom::class,
        'evtservprest' => Parses\EvtServPrest::class,
        'evtassocdesprec' => Parses\EvtAssocDespRec::class,
        'evtassocdesprep' => Parses\EvtAssocDespRep::class,
        'evtcomprod' => Parses\EvtComProd::class,
        'evtcprb' => Parses\EvtCPRB::class,
        'evtpgtosdivs' => Parses\EvtPgtosDivs::class,
        'evtreabreevper' => Parses\EvtReabreEvPer::class,
        'evtfechaevper' => Parses\EvtFechaEvPer::class,
        'evtespdesportivo' => Parses\EvtEspDesportivo::class,
        'evtretpf' => Parses\EvtRetPF::class,
        'evtretpj' => Parses\EvtRetPJ::class,
        'evtbenefnid' => Parses\EvtBenefNId::class,
        'evtreab' => Parses\EvtReab::class,
        'evtfech' => Parses\EvtFech::class,
        'evtexclusao' => Parses\EvtExclusao::class,
        'evttotal' => Parses\EvtTotal::class,
        'evtret' => Parses\EvtRet::class,
        'evttotalcontrib' => Parses\EvtTotalContrib::class,
        'evtretcons' =>Parses\EvtRetCons::class
    ];
    
    /**
     * Relationship between the code of the event and its respective name
     * @var array
     */
    private static $aliases = [
        'r1000' => 'evtinfocontri',
        'r1070' => 'evttabprocesso',
        'r2010' => 'evtservtom',
        'r2020' => 'evtservprest',
        'r2030' => 'evtassocdesprec',
        'r2040' => 'evtassocdesprep',
        'r2050' => 'evtcomprod',
        'r2060' => 'evtcprb',
        'r2070' => 'evtpgtosdivs',
        'r2098' => 'evteeabreevper',
        'r2099' => 'evtfecharvper',
        'r3010' => 'evtespdesportivo',
        'r4010' => 'evtretpf',
        'r4020' => 'evtretpj',
        'r4040' => 'evtbenefnid',
        'r4098' => 'evtreab',
        'r4099' => 'evtfech',
        'r9000' => 'evtexclusao',
        'r9001' => 'evttotal',
        'r9002' => 'evtret',
        'r9011' => 'evttotalcontrib',
        'r9012' => 'evtretcons'
    ];

    /**
     * Call classes to convert txt post in object
     * @param string $name
     * @param array $arguments [$txt]
     * @return object
     * @throws NFePHP\EFDReinf\Exception\ParseException
    */

    public static function __callStatic($name, $arguments){

    	$name = str_replace('-', '', strtolower($name));
        
        $realname = $name;
        
        if (substr($name, 0, 1) == 's') {
            if (!array_key_exists($name, self::$aliases)) {
                //este evento não foi localizado
                throw ParseException::wrongArgument(1000, $name);
            }
            $realname = self::$aliases[$name];
        }

        if (!array_key_exists($realname, self::$available)) {
            //este evento não foi localizado
            throw ParseException::wrongArgument(1000, $name);
        }
        
        $className = self::$available[$realname];
        
        return new $className($arguments[0]);

   	}

}

?>