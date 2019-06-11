<?php

namespace NFePHP\EFDReinf\Parses;


/**
 *
 */


use NFePHP\EFDReinf\Parses\Parse;
use stdClass;

class EvtFech extends Parse{

	public function convert(){

		$this->obParsed->config = new stdClass();

		$this->obParsed->config->eventoVersion = $this->eventoVersion;

		$this->obParsed->config->serviceVersion = $this->serviceVersion;

		$this->obParsed->modo = $this->ob[0][1];

		$this->obParsed->idEvento = $this->ob[0][3];

		$this->obParsed->ideEvento = new stdClass();

		$this->obParsed->ideEvento->perApur = $this->ob[1][1];

		$this->obParsed->config->empregador = new stdClass();

		$this->obParsed->config->ideEvento->empregador->nmRazao = $this->ob[1][2];

		$this->obParsed->config->ideEvento->tpAmb = $this->ob[1][3];

		$this->obParsed->config->ideEvento->procEmi = $this->ob[1][4];

		$this->obParsed->config->ideEvento->verProc = $this->ob[1][5];

		$this->obParsed->ideContri = new stdClass();

		$this->obParsed->config->ideContri->empregador->tpInsc = $this->ob[1][6];

		$this->obParsed->config->ideContri->empregador->nrInsc = $this->ob[1][7];

		$this->obParsed->config->transmissor = $this->obParsed->config->empregador;

		$index = 2;

		for ($i = $index; $i < count($this->ob); $i++){

			$auxOb = $this->ob[$i];

            $cabecario = $auxOb[0];

            if ($cabecario == 'IDERESPINF'){

            	$aux = new stdClass();

            	$aux->nmResp =  $auxOb[1];

            	$aux->cpfResp =  $auxOb[2];

            	$aux->telefone =  $auxOb[3];

            	$aux->email =  $auxOb[4];

            	$this->obParsed->ideRespInf[] = $aux;

            } else if ($cabecario == 'INFOFECH'){

            	$aux = new stdClass();

            	$aux->evtRetPF =  $auxOb[1];

            	$aux->evtRetPJ =  $auxOb[2];

            	$aux->evtPgtosNId =  $auxOb[3];

            	$this->obParsed->infoFech[] = $aux;

            }

		}

		return $this->obParsed;

	}
}