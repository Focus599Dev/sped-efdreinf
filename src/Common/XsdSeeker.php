<?php

namespace NFePHP\EFDReinf\Common;

class XsdSeeker
{
    public static $list = [
        'EnvioLoteEventos' => ['version' => '', 'name' => ''],
        'RetornoEnvioLoteEventos' => ['version' => '', 'name' => ''],
        'RetornoEvento' => ['version' => '', 'name' => ''],
        'RetornoLoteEventos' => ['version' => '', 'name' => ''],
        'RetornoProcessamentoLote' => ['version' => '', 'name' => '']
    ];
    
    public static function seek($path)
    {
        $arr = scandir($path);
        foreach ($arr as $filename) {
            if ($filename == '.' || $filename == '..') {
                continue;
            }
            foreach (self::$list as $key => $content) {
                $len = strlen($key);
                $chave = substr($filename, 0, $len);
                $version = self::getVersion($filename);
                if ($chave == $key) {
                    self::$list[$key] = ['version' => $version, 'name' => $filename];
                    break;
                }
            }
        }
        return self::$list;
    }
    
    public static function getVersion($filename)
    {
        $p = explode('-', $filename);
        $v = explode('.', $p[1]);
        return $v[0];
    }
}
