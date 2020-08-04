<?php


namespace   lib\Base\Support;


class   Session
{
    private function        __construct()
    {
        //..
    }

    /**
     * init session
     */
    public static function  start()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    /**
     * destroy session
     */
    public static function  abort()
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_abort();
        }
    }

    /**
     * put static value
     *
     * @param mixed $key
     * @param mixed $value
     */
    public static function  put($key, $value)
    {
        $_SESSION[$key] = ['value' => $value, 'remove' => false];
    }

    /**
     * put disposable value
     *
     * @param mixed $key
     * @param mixed $value
     */
    public static function  flash($key, $value)
    {
        $_SESSION[$key] = ['value' => $value, 'remove' => true];
    }

    /**
     * get and remove value if it disposable
     *
     * @param mixed $key
     * @param mixed $default
     *
     * @return mixed
     */
    public static function  get($key, $default = null)
    {
        if (isset($_SESSION[$key])) {
            $value = $_SESSION[$key]['value'];

            if ($_SESSION[$key]['remove']) {
                unset($_SESSION[$key]);
            }
            return $value;
        }
        return $default;
    }

    /**
     * get and don't remove value
     *
     * @param mixed $key
     * @param mixed $default
     *
     * @return mixed
     */
    public static function  keep($key, $default = null)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key]['value'];
        }
        return $default;
    }

    /**
     * check is value exist and not null
     *
     * @param $key
     *
     * @return bool
     */
    public static function  has($key): bool
    {
        return isset($_SESSION[$key]) && !empty($_SESSION[$key]['value']);
    }

    /**
     * check is value exist
     *
     * @param $key
     *
     * @return bool
     */
    public static function  exists($key): bool
    {
        return isset($_SESSION[$key]);
    }
}