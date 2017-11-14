<?php
namespace NFePHP\EFDReinf\Exception;

/**
 * @category   NFePHP
 * @package    NFePHP\EFDReinf\Exception
 * @copyright  Copyright (c) 2008-2017
 * @license    http://www.gnu.org/licenses/lesser.html LGPL v3
 * @author     Roberto L. Machado <linux.rlm at gmail dot com>
 * @link       http://github.com/nfephp-org/sped-common for the canonical source repository
 */

class EventsException extends \InvalidArgumentException implements ExceptionInterface
{
    public static $list = [
        1000 => "Este evento [{{msg}}] não foi encontrado.",
        1001 => "Não foi passado o config.",
        1002 => "Não foram passados os dados do evento.",
        1003 => "Você deve passar os parâmetros de configuração num stdClass.",
        1004 => "JSON does not validate. Violations:\n{{msg}}",
        1005 => ""
    ];
    
    public static function wrongArgument($code, $msg = '')
    {
        $msg = self::replaceMsg(self::$list[$code], $msg);
        return new static($msg);
    }
    
    private static function replaceMsg($input, $msg)
    {
        return str_replace('{{msg}}', $msg, $input);
    }
}
