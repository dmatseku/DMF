<?php

use lib\Base\Http\Response;
use lib\Base\Routing\ErrorRedirect;
use lib\Base\Routing\Router;
use lib\Base\Support\Config;
use lib\Base\Support\Session;

spl_autoload_register(function($class) {
    $class = '../'.str_replace('\\', '/', $class).'.php';

    if (file_exists($class)) {
        require_once $class;
    }
});

Session::start();
Session::put('DIR', realpath('').'/../');

if (Config::get('app', 'devmode', false)) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

date_default_timezone_set(Config::get('app', 'timezone', 'UTC'));

function    debug($error) {
    echo '<pre>';
    var_dump($error);
    echo '</pre>';
}

try {
    $router = Router::getInstance();
    $response = $router->getResponse();
    if (!($response instanceof Response)) {
        throw new \RuntimeException('Invalid controller\'s response');
    }
    $response->run();

    Session::flash('previousRoute', trim(preg_replace('/\/index\.php|\?.*/', '', $_SERVER['REQUEST_URI']), '/'));
} catch (\Exception $e) {
    $code = $e->getCode();

    if ($code >= 400 || $code < 500) {
        (new ErrorRedirect('ErrorController@err40x'))->with([
            'error' => $e->getMessage(),
            'code' => $code,
            'trace' => $e->getTrace()
        ])->run();
    } else {
        (new ErrorRedirect('ErrorController@err500'))->with([
            'error' => $e->getMessage(),
            'code' => $code,
            'trace' => $e->getTrace()
        ])->run();
    }
}

