<?php 

namespace NFePHP\EFDReinf\Factories;

use NFePHP\Common\Signer;
use NFePHP\Common\Strings;
use NFePHP\Common\Validator;
use NFePHP\Common\Certificate;
use NFePHP\EFDReinf\Common\FactoryInterface;
use DOMDocument;
use DOMElement;

class EvtGeneric implements FactoryInterface{

	private $xml;

	private $certificate;

	private $evtTag;

	private $schema;

	private $id;

	private $aliasSchema = array(

		'evtInfoContri' => 'evtInfoContribuinte',
        'evtTabProcesso' => 'evtTabProcesso',
        'evtServTom' => 'evtTomadorServicos',
        'evtServPrest' => 'evtPrestadorServicos',
        'evtAssocDespRec' => 'evtRecursoRecebidoAssociacao',
        'evtAssocDespRep' => 'evtRecursoRepassadoAssociacao',
        'evtComProd' => 'evtInfoProdRural',
        'evtCPRB' => 'evtInfoCPRB',
        'evtPgtosDivs' => 'evtPagsDivs',
        'evtReabreEvPer' => 'evtReabreEvPer',
        'evtFechaEvPer' => 'evtFechamento',
        'evtEspDesportivo' => 'evtEspDesportivo',
        // 'evtTotal' => 'evtTotal',
        'evtExclusao' => 'evtExclusao'

	);

	public function __construct(
		$xml,
		Certificate $certificate = null,
		$evtTag,
		$layoutVersion,
		$eventVersion,
		$id
	){

		$this->xml = $xml;

		$this->certificate = $certificate;

		$this->evtTag = $evtTag;

		$this->id = $id;

		$layoutStr = $this->strLayoutVer($eventVersion);

		$evtName = $this->aliasSchema[$evtTag];

		$this->schema = realpath(
            __DIR__
            . "/../../schemes/$layoutStr/"
            . $evtName
            . "-" . $layoutStr
            . ".xsd"
        );

	}

	public function getXML(){
		return $xml;
	}

	public function toXML(){

		$this->sign($this->evtTag);

        $aux = $this->clearXml($this->xml);

        return $aux;

	}

	protected function sign($tagsigned = ''){
        $xml = $this->xml;
        
        $xml = Strings::clearXmlString($xml);

        if (!empty($this->certificate)) {
            $xml = Signer::sign(
                $this->certificate,
                $xml,
                $tagsigned,
                'id',
                OPENSSL_ALGO_SHA256,
                [true, false, null, null]
            );

            //validation by XSD schema throw Exception if dont pass
            if ($this->schema) {
                Validator::isValid($xml, $this->schema);
            }
        }

        $this->xml = $xml;
    }

    protected function clearXml($xml){
        $dom = new DOMDocument('1.0', 'UTF-8');
        
        $this->formatOutput = false;
        
        $this->preserveWhiteSpace = false;

        $dom->loadXML($xml);

        return $dom->saveXML($dom->documentElement);
    }

    protected function strLayoutVer($layout){
        $fils = explode('.', $layout);
        $str = 'v';
        foreach ($fils as $fil) {
            $str .= str_pad($fil, 2, '0', STR_PAD_LEFT) . '_';
        }
        return substr($str, 0, -1);
    }

    public function alias(){

    }
    
    public function toJson(){

    }
    
    public function toStd(){

    }
    
    public function toArray(){

    }
    
    public function getId(){
    	return $this->id;
    }
    
    public function getCertificate(){
    	return $this->certificate;
    }
    
    public function setCertificate(Certificate $certificate){
    	$this->certificate = $certificate;
    }

}

?>