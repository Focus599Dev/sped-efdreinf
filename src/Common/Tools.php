<?php

namespace NFePHP\EFDReinf\Common;

/**
 * Class Common\Tools, basic structures
 *
 * @category  API
 * @package   NFePHP\EFDReinf
 * @copyright NFePHP Copyright (c) 2017
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-efdreinf for the canonical source repository
 */

use DateTime;
use stdClass;
use NFePHP\Common\Certificate;
use NFePHP\EFDReinf\Common\XsdSeeker;
use NFePHP\EFDReinf\Common\Restful\Rest;
use NFePHP\EFDReinf\Common\Soap\SoapCurl;
use NFePHP\EFDReinf\Common\Soap\SoapInterface;
use NFePHP\EFDReinf\Exception\ProcessException;
use NFePHP\EFDReinf\Common\Restful\RestInterface;

class Tools
{   

    public $lastRequest;
    
    public $lastResponse;
    
    /**
     * @var string
     */
    protected $path;
    /**
     * @var DateTime
     */
    protected $date;
    /**
     * @var int
     */
    protected $tpInsc;
    /**
     * @var string
     */
    protected $nrInsc;
    /**
     * @var string
     */
    protected $nmRazao;
    /**
     * @var int
     */
    protected $tpAmb;
    /**
     * @var string
     */
    protected $verProc;
    /**
     * @var string
     */
    protected $eventoVersion;
    /**
     * @var string
     */
    protected $serviceVersion;
    /**
     * @var string
     */
    protected $layoutStr;
    /**
     * @var string
     */
    protected $serviceStr;
    /**
     * @var array
     */
    protected $serviceXsd = [];
    /**
     * @var Certificate
     */
    protected $certificate;
    /**
     * @var int
     */
    protected $transmissortpInsc;
    /**
     * @var string
     */
    protected $transmissornrInsc;

     /**
     * @var string
     */
    protected $doc;

     /**
     * @var NFePHP\Common\Soap\SoapInterface
     */
    public $soap;

     /**
     * @var RestInterface
     */
    public $restclass;

    /**
     * @var string
     */
    public $namespace = 'http://sped.fazenda.gov.br/';

    protected $soapnamespaces = [
        'xmlns:soapenv' => "http://schemas.xmlsoap.org/soap/envelope/",
        'xmlns:sped' => "http://sped.fazenda.gov.br/",
    ];
    protected $objHeader;
    protected $xmlns;
    
    /**
     * @var array
     */
    protected $uri = [
        '1' => 'https://reinf.receita.fazenda.gov.br/WsREINF/RecepcaoLoteReinf.svc',
        '2' => 'https://preprodefdreinf.receita.fazenda.gov.br/WsREINF/RecepcaoLoteReinf.svc',
    ];

    /**
     *
     * @var array
     */
    protected $uriconsulta = [
        '1' => 'https://reinf.receita.fazenda.gov.br/WsReinfConsultas/ConsultasReinf.svc',
        '2' => 'https://preprodefdreinf.receita.fazenda.gov.br/WsReinfConsultas/ConsultasReinf.svc',
    ];

     /**
     * @var string[]
     */
    protected $urlloteassincrono = [
        '1' => 'https://reinf.receita.economia.gov.br/recepcao/lotes',
        '2' => 'https://pre-reinf.receita.economia.gov.br/recepcao/lotes',
    ];

    /**
     * @var string[]
     */
    protected $urlconsultaassincrono = [
        '1' => 'https://reinf.receita.economia.gov.br/consulta/lotes',
        '2' => 'https://pre-reinf.receita.economia.gov.br/consulta/lotes'
    ];

    /**
     * @var string[]
     */
    protected $urlconsultaeventoassincrono = [
        '1' => 'https://reinf.receita.economia.gov.br/consulta/reciboevento',
        '2' => 'https://pre-reinf.receita.economia.gov.br/consulta/reciboevento'
    ];

    /**
     * @var string
     */
    protected $action;
    protected $method;
    protected $parameters;

     /**
     * @var string
     */
    protected $xsdassincrono;

     /**
     * @var array
     */
    protected $eventGroup = [
        1 => 'EVENTOS INICIAIS',
        2 => 'EVENTOS NÃO PERIÓDICOS',
        3 => 'EVENTOS PERIÓDICOS',
    ];
    
    /**
     * @var array
     */
    protected $grupos = [
        1 => [ //EVENTOS INICIAIS grupo [1]
            'R-1000',
            'R-1050',
            'R-1070'
        ],
        2 => [ //EVENTOS NÃO PERIÓDICOS grupo [2]
            'R-3010',
            'R-9000'
        ],
        3 => [ //EVENTOS PERIÓDICOS grupo [3]
            'R-2010',
            'R-2020',
            'R-2030',
            'R-2040',
            'R-2050',
            'R-2055',
            'R-2060',
            'R-2070',
            'R-2098',
            'R-4010',
            'R-4020',
            'R-4040',
            'R-4080'
        ],
        4 => [ //EVENTOS FINAIS grupo [4]
            'R-2099',
            'R-4099'
        ]
    ];

    /**
     * Constructor
     * @param string $config
     * @param Certificate $certificate
     */
    public function __construct(
        $config,
        Certificate $certificate
    ) {
        //set properties from config
        $stdConf = json_decode($config);
        $this->tpAmb = $stdConf->tpAmb;
        $this->verProc = $stdConf->verProc;
        $this->eventoVersion = $stdConf->eventoVersion;
        $this->serviceVersion = $stdConf->serviceVersion;
        $this->date = new DateTime();
        $this->tpInsc = $stdConf->empregador->tpInsc;
        $this->nrInsc = $stdConf->empregador->nrInsc;
        $this->nmRazao = $stdConf->empregador->nmRazao;
        $this->transmissortpInsc = $stdConf->transmissor->tpInsc;
        $this->transmissornrInsc = $stdConf->transmissor->nrInsc;
        $this->certificate = $certificate;
        $this->doc = $this->nrInsc;

        $this->path = realpath(
            __DIR__ . '/../../'
        ).'/';
        

        $this->serviceXsd = XsdSeeker::seek(

        $this->path . "schemes/comunicacao/v" . $this->serviceVersion . "/"

        );
    }

     /**
     * SOAP communication dependency injection
     * @param SoapInterface $soap
     */
    public function loadSoapClass(SoapInterface $soap)
    {
        $this->soap = $soap;
    }

    public function loadRestClass(RestInterface $rest)
    {
        $this->restclass = $rest;
    }

    /**
     * Send request message to webservice
     * @param array $parameters
     * @param string $request
     * @return string
    */
    protected function sendRequest($request, array $parameters = [])
    {
        $this->checkSoap();

        $this->makeHeader();

        if ($this->method == 'ReceberLoteEventos') {
            $url = $this->uri[$this->tpAmb];
        } else {
            $url = $this->uriconsulta[$this->tpAmb];
        }

        $this->lastRequest = $request;

        return (string) $this->soap->send(
            $url,
            $this->method,
            $this->action,
            1,
            $parameters,
            $this->soapnamespaces,
            $request,
            $this->objHeader
        );
    }

    protected function sendApi(string $method, string $url, string $content)
    {
        if (empty($this->restclass)) {
            $this->restclass = new Rest($this->certificate);
        }
        return $this->restclass->sendApi($method, $url, $content);
    }

    private function makeHeader(){

        $header = new \stdClass();

        $header->data = array();
        
        $header->emptyHeader = true;

        $header->name = null;

        $header->namespace = null;

        $this->objHeader = $header;
    }


    /**
     * Verify the availability of a digital certificate.
     * If available, place it where it is needed
     * @param FactoryInterface $evento
     * @throws RuntimeException
     */
    protected function checkCertificate(FactoryInterface $evento)
    {
        if (empty($this->certificate)) {
            //try to get certificate from event
            $certificate = $evento->getCertificate();
            if (empty($certificate)) {
                //oops no certificate avaiable
                throw ProcessException::wrongArgument(2001, '');
            }
            $this->certificate = $certificate;
        } else {
            $certificate = $evento->getCertificate();
            if (empty($certificate)) {
                $evento->setCertificate($this->certificate);
            }
        }
    }


    public function readReturn ($xml, $tagMain = 'retornoLoteEventosAssincrono'){

        $xml = substr($xml, strpos($xml, "<" . $tagMain));
                                        
        $xml = substr($xml, 0, strpos($xml, '</' . $tagMain . '>') + strlen('</' . $tagMain . '>'));
            
        $xml = simplexml_load_string($xml);

        return $xml;
    }

    public function checkSoap(){
        if (empty($this->soap)) {
            $this->soap = new SoapCurl($this->certificate);
        }
    }

    /**
     * Valid input parameters
     * @param array $properties
     * @param stdClass $std
     * @return void
     * @throws \Exception
     */
    protected function validInputParameters(array $properties, stdClass $std)
    {
        foreach ($properties as $key => $rules) {
            $r = json_decode(json_encode($rules));
            if ($r->required) {
                if (!isset($std->$key)) {
                    throw new \Exception("$key não foi passado como parâmetro e é obrigatório.");
                }
                $value = $std->$key;
                if ($r->type === 'integer') {
                    if ($value < $r->min || $value > $r->max) {
                        throw new \Exception("$key contêm um valor invalido [$value].");
                    }
                }
                if ($r->type === 'string') {
                    if (!preg_match("/{$r->regex}/", $value)) {
                        throw new \Exception("$key contêm um valor invalido [$value].");
                    }
                }
            }
        }
    }

    /**
     * Converte as chaves de um array para lowercase
     * @param array $array
     * @return array
     */
    protected static function arrayKeysToLowerRecursive(array $array): array
    {
        return array_map(
            static function ($item) {
                if (is_array($item)) {
                    $item = self::arrayKeysToLowerRecursive($item);
                }
                return $item;
            },
            self::keyFilter($array)
        );
    }

    /**
     * Remove espaços extras das chaves de um array
     * @param $array
     * @return array
     */
    protected static function keyFilter($array)
    {
        $new = [];
        foreach ($array as $key => $value) {
            $key = preg_replace('/(?:\s\s+)/', ' ', $key);
            $key = strtolower(trim($key)); //converte para caixa baixa
            $new[$key] = $value;
        }
        return $new;
    }

    /**
     * Valida os dados passados para as consultas assincronas
     * @param array $required
     * @param stdClass $std
     * @return array
     */
    protected static function validateConsultData(array $required, stdClass $std): array
    {
        $errors = [];
        $status = true;
        foreach ($required as $rec => $regex) {
            $value = trim($std->$rec);
            if (empty($value)) {
                $errors[] = "O campo {$rec}, deve ser informado.";
                $status = false;
            }
            if (!preg_match_all($regex, $value, $matchs)) {
                $errors[] = "O valor {$value} é um conteúdo incorreto para o campo {$rec}.";
                $status = false;
            }
        }
        return ['status' => $status, 'errors' => $errors];
    }

     /**
     * Converte para lower case todas as propriedades do stdClass
     * @param stdClass $std
     * @return stdClass
     */
    protected static function propertiesToLower(stdClass $std): stdClass
    {
        $array = json_decode(json_encode($std), true);
        $lkarray = self::arrayKeysToLowerRecursive($array);
        if (empty($lkarray)) {
            throw new \RuntimeException("Deve ser passado pelo menos um campo no com valor "
                . "diferente de null ou vazio.");
        }
        return (object) $lkarray;
    }
}
