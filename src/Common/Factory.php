<?php

namespace NFePHP\EFDReinf\Common;

use DateTime;
use DOMDocument;
use DOMElement;
use JsonSchema\Validator as JsonValid;
use NFePHP\Common\Certificate;
use NFePHP\Common\DOMImproved as Dom;
use NFePHP\Common\Signer;
use NFePHP\Common\Strings;
use NFePHP\Common\Validator;
use NFePHP\EFDReinf\Exception\EventsException;
use stdClass;

abstract class Factory
{
    /**
     * @var int
     */
    public $tpInsc;
    /**
     * @var string
     */
    public $nrInsc;
    /**
     * @var string
     */
    public $nmRazao;
    /**
     * @var DateTime
     */
    public $date;
    /**
     * @var int
     */
    public $tpAmb = 3;
    /**
     * @var int
     */
    public $procEmi = 1;
    /**
     * @var string
     */
    public $verProc = '';
    /**
     * @var string
     */
    public $layout = '';
    /**
     * @var string
     */
    public $layoutStr = '';
    /**
     * @var string
     */
    public $schema = '';
    /**
     * @var string
     */
    public $jsonschema = '';
    /**
     * @var string
     */
    public $evtid = '';
    /**
     * @var string
     */
    protected $xmlns = "http://www.reinf.esocial.gov.br/schemas/";
    /**
     * @var string
     */
    protected $xsi = "http://www.w3.org/2001/XMLSchema-instance";
    /**
     * @var Dom
     */
    protected $dom;
    /**
     * @var stdClass
     */
    protected $std;
    /**
     * @var string
     */
    protected $xml;
    /**
     * @var DOMNode
     */
    protected $reinf;
    /**
     * @var DOMNode
     */
    protected $main;
    /**
     * @var DOMElement
     */
    protected $node;
    /**
     * @var array
     */
    protected $parameters = [];
    /**
     * @var string
     */
    protected $evtName = '';
    /**
     * @var string
     */
    protected $evtAlias = '';
    /**
     * @var Certificate
     */
    protected $certificate;

    protected $enviaLotVersion;

    /**
     * Constructor
     *
     * @param string      $config
     * @param stdClass    $std
     * @param Certificate $certificate
     * @param string      $date
     */
    public function __construct(
        $config,
        stdClass $std,
        Certificate $certificate = null,
        $date = ''
    ) {
        $stdConf = $config;

        $this->date = new DateTime();

        if (!empty($date)) {
            $this->date = new DateTime($date);
        }
        $this->enviaLotVersion = $stdConf->serviceVersion;
        $this->tpAmb = $stdConf->tpAmb;
        $this->verProc = $stdConf->verProc;
        $this->layout = $stdConf->eventoVersion;
        $this->tpInsc = $stdConf->empregador->tpInsc;
        $this->nrInsc = $stdConf->empregador->nrInsc;
        $this->nmRazao = $stdConf->empregador->nmRazao;
        $this->evtid = $std->idEvento;

        $this->layoutStr = $this->strLayoutVer($this->layout);
        $this->certificate = $certificate;
        if (empty($std) || !is_object($std)) {
            throw EventsException::wrongArgument(1003, '');
        }
        $this->jsonschema = realpath(
            __DIR__
            . "/../../jsonSchemes/$this->layoutStr/"
            . $this->evtName
            . ".schema"
        );
        $this->schema = realpath(
            __DIR__
            . "/../../schemes/$this->layoutStr/"
            . $this->evtName
            . "-" . $this->layoutStr
            . ".xsd"
        );
        //convert all data fields to lower case
        $this->std = $this->propertiesToLower($std);
        //validate input data with schema
        $this->validInputData($this->std);
        //Adding forgotten or unnecessary fields.
        //This is done for standardization purposes.
        //Fields with no value will not be included by the builder.
        //$this->std = $this->standardizeProperties($this->std);
        $this->init();
    }

    /**
     * Stringfy layout number
     *
     * @param type $layout
     *
     * @return string
     */
    protected function strLayoutVer($layout)
    {
        $fils = explode('.', $layout);
        $str = 'v';
        foreach ($fils as $fil) {
            $str .= str_pad($fil, 2, '0', STR_PAD_LEFT) . '_';
        }
        return substr($str, 0, -1);
    }

    /**
     * Change properties names of stdClass to lower case
     *
     * @param stdClass $data
     *
     * @return stdClass
     */
    protected static function propertiesToLower(stdClass $data)
    {
        $properties = get_object_vars($data);
        $clone = new stdClass();
        foreach ($properties as $key => $value) {
            if ($value instanceof stdClass) {
                $value = self::propertiesToLower($value);
            }
            $nk = strtolower($key);
            $clone->{$nk} = $value;
        }
        return $clone;
    }

    /**
     * Validation json data from json Schema
     *
     * @param stdClass $data
     *
     * @return boolean
     * @throws \RuntimeException
     */
    protected function validInputData($data)
    {
        if (!is_file($this->jsonschema)) {
            return true;
        }
        $validator = new JsonValid();
        $validator->check($data, (object)['$ref' => 'file://' . $this->jsonschema]);
        if (!$validator->isValid()) {
            $msg = "";
            foreach ($validator->getErrors() as $error) {
                $msg .= sprintf("[%s] %s\n", $error['property'], $error['message']);
            }
            throw EventsException::wrongArgument(1004, $msg);
        }
        return true;
    }

    /**
     * Initialize DOM
     */
    protected function init()
    {
        if (empty($this->dom)) {
            $this->dom = new Dom('1.0', 'UTF-8');
            $this->dom->preserveWhiteSpace = false;
            $this->dom->formatOutput = false;

            // SAP esta mandando ID
            $this->evtid = FactoryId::build(
                $this->tpInsc,
                $this->nrInsc,
                $this->date
            );

            $this->main = '<Reinf xmlns="http://www.reinf.esocial.gov.br/schemas/envioLoteEventos/v' . $this->enviaLotVersion . '">' 
                . '<loteEventos>'
                . '<evento id="' . $this->evtid . '">'
                . '%s'
                . '</evento>'
                . '</loteEventos>'
                . '</Reinf>';

            $xml = '<Reinf xmlns="' . $this->xmlns . $this->evtName . '/' .$this->layoutStr . '">'
                . "</Reinf>";
            
            $this->dom->loadXML($xml);

            $this->reinf = $this->dom->getElementsByTagName('Reinf')->item(0);

            $this->node = $this->dom->createElement($this->evtTag);
            
            $att = $this->dom->createAttribute('id');
            
            $att->value = $this->evtid;
            
            $this->node->appendChild($att);
            
            $ideContri = $this->dom->createElement("ideContri");
            
            $this->dom->addChild(
                $ideContri,
                "tpInsc",
                $this->tpInsc,
                true
            );
            
            $this->dom->addChild(
                $ideContri,
                "nrInsc",
                $this->nrInsc,
                true
            );

            $this->node->appendChild($ideContri);
        }
    }

    public function alias()
    {
        return $this->evtAlias;
    }

    public function getCertificate()
    {
        return $this->certificate;
    }

    public function setCertificate(Certificate $certificate)
    {
        $this->certificate = $certificate;
    }

    /**
     * Return xml of event
     *
     * @return string
     */
    public function toXML()
    {
        if (empty($this->xml)) {
            $this->toNode();
        }

        $aux = $this->clearXml($this->xml);

        return str_replace('%s', $aux, $this->main);
    }

    abstract protected function toNode();

    /**
     * Remove XML declaration from XML string
     * @param string $xml
     * @return string
     */
    protected function clearXml($xml)
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        
        $this->formatOutput = false;
        
        $this->preserveWhiteSpace = false;

        $dom->loadXML($xml);

        return $dom->saveXML($dom->documentElement);
    }

    /**
     * Convert xml of event to array
     * @return array
     */
    public function toArray()
    {
        return json_decode($this->toJson(), true);
    }

    /**
     * Convert xml to json string
     * @return string
     */
    public function toJson()
    {
        if (empty($this->xml)) {
            $this->toNode();
        }
        //a assinatura só faz sentido no XML, os demais formatos
        //não devem conter dados da assinatura
        $xml = Signer::removeSignature($this->xml);
        $dom = new \DOMDocument();
        $dom->loadXML($xml);
        $sxml = simplexml_load_string($dom->saveXML());
        return str_replace(
            '@attributes',
            'attributes',
            json_encode($sxml, JSON_PRETTY_PRINT)
        );
    }

    /**
     * Convert xml to stdClass
     * @return stdClass
     */
    public function toStd()
    {
        return json_decode($this->toJson());
    }

    /**
     * Adjust missing properties form original data according schema
     * @param \stdClass $data
     * @return \stdClass
     */
    public function standardizeProperties(stdClass $data)
    {
        if (!is_file($this->jsonschema)) {
            return $data;
        }
        $jsonSchemaObj = json_decode(file_get_contents($this->jsonschema));
        $sc = new ParamsStandardize($jsonSchemaObj);
        return $sc->stdData($data);
    }

    /**
     * Sign and validate XML with XSD, can throw Exception
     */
    protected function sign()
    {
        $xml = $this->dom->saveXML($this->reinf);
        $xml = Strings::clearXmlString($xml);

        if (!empty($this->certificate)) {
            $xml = Signer::sign(
                $this->certificate,
                $xml,
                $this->evtTag,
                'id',
                OPENSSL_ALGO_SHA256,
                [true, false, null, null]
            );
            //validation by XSD schema throw Exception if dont pass
            // Validator::isValid($xml, $this->schema);
        }
        $this->xml = $xml;
    }
}
