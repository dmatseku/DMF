<?php


namespace   lib\Base\Routing;
use         lib\Base\Http\Request;
use lib\Base\Support\Config;
use lib\Base\Support\Session;

class   Router
{
    /**
     * @var array get routes
     */
    private static array    $getActions = [];
    /**
     * @var array post routes
     */
    private static array    $postActions = [];

    /**
     * @var Router singleton object
     */
    private static ?Router  $instance = null;

    /**
     * Router constructor. Init routes
     */
    private function        __construct()
    {
        require_once Session::get('DIR', '').'app/routes.php';
    }

    private function        __clone() { }
    public function         __wakeup()
    {
        throw new \RuntimeException("Cannot unserialize a singleton.", 500);
    }

    /**
     * Get instance
     *
     * @return Router
     */
    public static function  getInstance(): Router
    {
        if (!self::$instance) {
            self::$instance = new Router;
        }

        return self::$instance;
    }

    /**
     * Check route syntax
     * @param string $route
     */
    public static function  checkRoute(string $route)
    {
        if (!preg_match('/^(\w+\/)*(\w+)?$/', $route)) {
            throw new \RuntimeException("Invalid router syntax", 500);
        }
    }

    /**
     * make controller->action from string and check existing
     *
     * @param string $action
     *
     * @return array
     */
    public static function  formatAction(string $action): array
    {
        $matches = null;

        if (!preg_match('/^((\w+\\\\)*\w+)@(\w+)$/', $action, $matches)) {
            throw new \RuntimeException('Invalid action syntax', 500);
        }

        $controller = 'app\\Controllers\\'.$matches[1];
        if (!class_exists($controller) || !method_exists($controller, $matches[3])) {
            $controller = 'lib\\Base\\Controllers\\'.$matches[1];

            if (!class_exists($controller) || !method_exists($controller, $matches[3])) {
                throw new \RuntimeException('Action "' . $matches[0] . '" doesn\'t exist', 500);
            }
        }

        //Controller and action
        return [$controller, $matches[3]];
    }

    /**
     * create GET route
     *
     * @param string $route
     * @param string $action
     */
    public static function  get(string $route, string $action)
    {
        $route = trim($route, "\ \t\n\r\0\x0B/");
        $action = trim($action);

        self::checkRoute($route);
        self::$getActions[$route] = self::formatAction($action);
    }

    /**
     * create POST route
     *
     * @param string $route
     * @param string $action
     */
    public static function  post(string $route, string $action)
    {
        $route = trim($route, "\ \t\n\r\0\x0B/");
        $action = trim($action);

        self::checkRoute($route);
        self::$postActions[$route] = self::formatAction($action);
    }

    /**
     * get action by route
     *
     * @return array|null
     */
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

    /**
     * get response by route
     *
     * @return mixed
     */
    public function         getResponse()
    {
        if ($controller_info = $this->find()) {
            $controller = new $controller_info['params'][0]();
            $controller_func = $controller_info['params'][1];

            return $controller->$controller_func($controller_info['request']);
        }
        throw new \RuntimeException('Page not found', 404);
    }

    /**
     * get responce by action string
     *
     * @param string $action
     * @return mixed
     */
    public function         getResponseByAction(string $action)
    {
        $formattedAction = self::formatAction($action);
        $request = new Request('Action', $action);

        $controller = new $formattedAction[0]();
        $controller_func = $formattedAction[1];

        return $controller->$controller_func($request);
    }

    /**
     * get home route
     *
     * @return mixed|null
     */
    public static function  home()
    {
        return Config::get('app', 'home', '');
    }
}