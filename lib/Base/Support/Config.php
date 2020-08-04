<?php


namespace lib\Base\Support;


class   Config
{
    /**
     * get value from multi-level array
     *
     * @param array $keys
     * @param array $array
     * @param mixed $default
     * @return mixed
     */
    private static function getValue(array $keys, array $array, $default)
    {
        foreach ($keys as $oneKey) {
            if (!isset($array[$oneKey])) {
                return $default;
            }
            $array = $array[$oneKey];
        }
        return $array;
    }

    /**
     * get value from config file
     *
     * @param string $file
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function  get(string $file, string $key = null, $default = null)
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