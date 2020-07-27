<?php


namespace   lib\Base\Support;


class   Session
{
    private function        __construct()
    {
        //..
    }

    public static function  start()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function  abort()
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_abort();
        }
    }

    public static function  put($name, $value)
    {
        $_SESSION[$name] = ['value' => $value, 'remove' => false];
    }

    public static function  flash($name, $value)
    {
        $_SESSION[$name] = ['value' => $value, 'remove' => true];
    }

    public static function  get($name, $default = null)
    {
        if (isset($_SESSION[$name])) {
            $value = $_SESSION[$name]['value'];

            if ($_SESSION[$name]['remove']) {
                unset($_SESSION[$name]);
            }
            return $value;
        }
        return $default;
    }

    public static function  keep($name, $default = null)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name]['value'];
        }
        return $default;
    }

    public static function  has($name)
    {
        return isset($_SESSION[$name]) && !empty($_SESSION[$name]['value']);
    }

    public static function  exists($name)
    {
        return isset($_SESSION[$name]);
    }
}