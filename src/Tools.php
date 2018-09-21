<?php

namespace NFePHP\EFDReinf;

/**
 * Classe Tools, performs communication with the EFDReinf webservice
 *
 * @category  API
 * @package   NFePHP\EFDReinf\Tools
 * @copyright Copyright (c) 2017
 * @license   https://www.gnu.org/licenses/lgpl-3.0.txt LGPLv3
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt GPLv3
 * @license   https://opensource.org/licenses/mit-license.php MIT
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-esocial for the canonical source repository
 */
use NFePHP\Common\Certificate;
use NFePHP\Common\Validator;
use NFePHP\EFDReinf\Common\Tools as ToolsBase;
use NFePHP\EFDReinf\Common\FactoryInterface;
use NFePHP\EFDReinf\Common\Soap\SoapCurl;
use NFePHP\EFDReinf\Common\Soap\SoapInterface;
use NFePHP\EFDReinf\Exception\ProcessException;

class Tools extends ToolsBase
{
    public $lastRequest;
    public $lastResponse;
    
    /**
     * @var NFePHP\Common\Soap\SoapInterface
     */
    protected $soap;
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
        '3' => 'https://preprodefdreinf.receita.fazenda.gov.br/WsREINF/RecepcaoLoteReinf.svc'
    ];

    /**
     *
     * @var array
     */
    protected $uriconsulta = [
        '1' => 'https://reinf.receita.fazenda.gov.br/WsREINF/ConsultasReinf.svc',
        '2' => 'https://preprodefdreinf.receita.fazenda.gov.br/WsREINF/ConsultasReinf.svc',
        '3' => 'https://preprodefdreinf.receita.fazenda.gov.br/WsREINF/ConsultasReinf.svc'
    ];

    /**
     * @var string
     */
    protected $action;
    protected $method;
    protected $parameters;

    public function __construct($config, Certificate $certificate = null)
    {
        parent::__construct($config, $certificate);
    }
    
    /**
     * SOAP communication dependency injection
     * @param SoapInterface $soap
     */
    public function loadSoapClass(SoapInterface $soap)
    {
        $this->soap = $soap;
    }
    
    /**
     * Event batch query
     * @param string $recibofechamento
     * @return string
     */
    public function consultar($recibofechamento)
    {
        if (empty($recibofechamento)) {
            return '';
        }
        $this->method = "ConsultaInformacoesConsolidadas";
        $this->action = "http://sped.fazenda.gov.br/ConsultasReinf/".$this->method;
        $request = "<sped:tipoInscricaoContribuinte>$this->tpInsc</sped:tipoInscricaoContribuinte>";
        $request .= "<sped:numeroInscricaoContribuinte>$this->nrInsc</sped:numeroInscricaoContribuinte>";
        $request .= "<sped:numeroProtocoloFechamento>$recibofechamento</sped:numeroProtocoloFechamento>";
        $body = "<sped:ConsultaInformacoesConsolidadas>"
            . $request
            . "</sped:ConsultaInformacoesConsolidadas>";
        
        $this->lastResponse = $this->sendRequest($body);
        return $this->lastResponse;
    }
    
    /**
     * Send batch of events
     * @param array $eventos
     * @return string
     */
    public function envioLoteEventos($eventos = [])
    {
        if (empty($eventos)) {
            return '';
        }
        $xml = "";
        $nEvt = count($eventos);
        
        if ($nEvt > 100) {
            throw ProcessException::wrongArgument(2000, $nEvt);
        }
      
        $this->method = "ReceberLoteEventos";
        
        $this->action = "http://sped.fazenda.gov.br/RecepcaoLoteReinf/ReceberLoteEventos";

        $xml = "";

        $request = '';

        foreach ($eventos as $evento) {
            
            if (!is_a($evento, '\NFePHP\EFDReinf\Common\FactoryInterface')) {
                throw ProcessException::wrongArgument(2002, '');
            }

            $this->checkCertificate($evento);

            $xml .= '<evento id="' . $evento->getId() . '">';

                $xml .= $evento->toXML();

            $xml .= '</evento>';

        }

         $request = '<Reinf xmlns="http://www.reinf.esocial.gov.br/schemas/envioLoteEventos/v' . $this->serviceVersion . '">'
            . '<loteEventos>'
            . $xml
            . '</loteEventos>'
            . '</Reinf>';
        
        $body = '<sped:ReceberLoteEventos>'
            . '<sped:loteEventos>'
            .       $request
            . '</sped:loteEventos>'
            . '</sped:ReceberLoteEventos>';

        $this->lastResponse = $this->sendRequest($body);

        return $this->lastResponse;
    }
    
    /**
     * Send request to webservice
     * @param string $request
     * @return string
     */
    protected function sendRequest($request)
    {
        if (empty($this->soap)) {
            $this->soap = new SoapCurl($this->certificate);
        }
        $envelope = '<?xml version="1.0" encoding="utf-8"?>' . chr(10) . '<soapenv:Envelope ';
        
        $attr = array();
        
        foreach ($this->soapnamespaces as $key => $xmlns) {
            $attr[] = "$key=\"$xmlns\"";
        }

        $envelope .= implode(' ', $attr);

        $envelope .= ">"
            . "<soapenv:Header></soapenv:Header>"
            . "<soapenv:Body>"
            . $request
            . "</soapenv:Body>"
            . "</soapenv:Envelope>";
        
        $msgSize = strlen($envelope);

        $parameters = [
            "Content-Type: text/xml;charset=UTF-8",
            "SOAPAction: \"$this->action\"",
            "Content-length: $msgSize"
        ];

        if ($this->method == 'ReceberLoteEventos') {
            $url = $this->uri[$this->tpAmb];
        } else {
            $url = $this->uriconsulta[$this->tpAmb];
        }

        $this->lastRequest = $envelope;

        return (string) $this->soap->send(
            $this->method,
            $url,
            $this->action,
            $envelope,
            $parameters
        );
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


    public function readReturn ($xml, $tagMain = 'ReceberLoteEventosResult'){

        $xml = substr($xml, strpos($xml, "<" . $tagMain));
                                        
        $xml = substr($xml, 0, strpos($xml, '</' . $tagMain . '>') + strlen('</' . $tagMain . '>'));
            
        $xml = simplexml_load_string($xml);

        return $xml;
    }
}
