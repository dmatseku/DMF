<?php


namespace   lib\Base\Routing;
use         lib\Base\Http\Request;
use lib\Base\Support\Config;
use lib\Base\Support\Session;

class   Router
{
    protected static    $getActions = [];
    protected static    $postActions = [];

    private static      $instance = null;

    protected function      __construct() {
        require_once Session::get('DIR', '').'app/routes.php';
    }

    protected function      __clone() { }

    public function         __wakeup()
    {
        throw new \RuntimeException("Cannot unserialize a singleton.", 500);
    }

    public static function  getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Router;
        }

        return self::$instance;
    }

    public static function  checkRoute($route)
    {
        if (!preg_match('/^(\w+\/)*(\w+)?$/', $route)) {
            throw new \RuntimeException("Invalid router syntax", 500);
        }
    }

    public static function  formatAction($action)
    {
        $matches = null;

        if (!preg_match('/^((\w+\\\\)*\w+)@(\w+)$/', $action, $matches)) {
            throw new \RuntimeException('Invalid action syntax', 500);
        }

        $controller = 'app\\Controllers\\'.$matches[1];
        if (!class_exists($controller) || !method_exists($controller, $matches[3])) {
            $controller = 'lib\\Base\\Controllers\\'.$matches[1];

            if (!class_exists($controller) || !method_exists($controller, $matches[3])) {
                throw new \RuntimeException('Action "' . $matches[0] . '" doesn\'t exist', 404);
            }
        }

        //Controller and action
        return [$controller, $matches[3]];
    }

    public static function  get($route, $action)
    {
        $route = trim($route, "\ \t\n\r\0\x0B/");
        $action = trim($action);

        self::checkRoute($route);
        self::$getActions[$route] = self::formatAction($action);
    }

    public static function  post($route, $action)
    {
        $route = trim($route, "\ \t\n\r\0\x0B/");
        $action = trim($action);

        self::checkRoute($route);
        self::$postActions[$route] = self::formatAction($action);
    }

    private function        find()
    {
        $url = trim(preg_replace('/\/index\.php|\?.*/', '', $_SERVER['REQUEST_URI']), '/');
        $action_array = strtolower($_SERVER['REQUEST_METHOD']).'Actions';

        if (property_exists(self::class, $action_array) && isset(self::$$action_array[$url])) {
            return [
                'params' => self::$$action_array[$url],
                'request' => new Request($_SERVER['REQUEST_METHOD'], $url)
            ];
        }
        return null;
    }

    public function         getResponse()
    {
        if ($controller_info = $this->find()) {
            $controller = new $controller_info['params'][0]();
            $controller_func = $controller_info['params'][1];

            return $controller->$controller_func($controller_info['request']);
        }
        throw new \RuntimeException('Page not found', 404);
    }

    public function         getResponseByAction($action)
    {
        $formattedAction = self::formatAction($action);
        $request = new Request('Action', $action);

        $controller = new $formattedAction[0]();
        $controller_func = $formattedAction[1];

        return $controller->$controller_func($request);
    }

    public static function  home()
    {
        return Config::get('app', 'home', '');
    }
}