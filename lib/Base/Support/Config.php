<?php


namespace lib\Base\Support;


class   Config
{
    private static function getValue($keys, $array, $default)
    {
        foreach ($keys as $oneKey) {
            if (!isset($array[$oneKey])) {
                return $default;
            }
            $array = $array[$oneKey];
        }
        return $array;
    }

    public static function  get($file, $key = null, $default = null)
    {
        $file = Session::get('DIR', '').'config/'.$file.'.php';

        if (file_exists($file) && is_file($file)) {
            if ($key !== null) {
                return self::getValue(explode('/', $key), require $file, $default);
            }
            return require $file;
        }

        return $default;
    }
}