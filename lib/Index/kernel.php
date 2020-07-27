<?php

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

function    debug($error) {
    echo '<pre>';
    var_dump($error);
    echo '</pre>';
    exit;
}

//ob_start();
//require '../app/Views/Test.prelang.php';
//$str = ob_get_clean();
//
//preg_match_all('/(@(?!end)(\w*))\s*\(\s*((?:(?!\))[\s\S])*)\s*\)\s+((?:(?!@end)[\s\S])*)\s*(@end(\w*))/', $str, $matches, PREG_SET_ORDER);
//echo $str."\n\n";
//debug($matches);

try {
    $router = Router::getInstance();
    $router->getResponse()->run();
    Session::flash('previousRoute', trim(preg_replace('/\/index\.php|\?.*/', '', $_SERVER['REQUEST_URI']), '/'));
} catch (\Exception $e) {
    $code = $e->getCode();

    if ($code === 404 || $code === 403) {
        (new ErrorRedirect('ErrorController@err'.$code))->with([
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

