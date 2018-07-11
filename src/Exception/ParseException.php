<?php
namespace NFePHP\EFDReinf\Exception;

/**
 * @category   NFePHP
 * @package    NFePHP\EFDReinf\Exception
 * @copyright  FocusIt (c) 2008-2017
 * @license    http://www.gnu.org/licenses/lesser.html LGPL v3
 * @author     Marlon O.Barbosa <marlon.academi@gmail.com>
 * @link       https://github.com/Focus599Dev/sped-efdreinf for the canonical source repository
 */

class ParseException extends \InvalidArgumentException implements ExceptionInterface
{
    public static $list = [
        1000 => "Este evento [{{msg}}] não foi encontrado."
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
