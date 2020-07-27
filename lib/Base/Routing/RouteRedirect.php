<?php


namespace   lib\Base\Routing;

use         lib\Base\Http\Response;
use         lib\Base\Support\Session;


class   RouteRedirect extends Response
{
    private $redirectPath;

    public function         run()
    {
        Session::flash('redirectInput', $this->args);
        header_remove();
        header('Location: '.$this->redirectPath);
        exit;
    }

    public function         __construct($route)
    {
        $this->redirectPath = 'http://'.$_SERVER['HTTP_HOST'].'/'.$route;
    }

    public static function  back()
    {
        return new RouteRedirect(Session::get('previousRoute', Router::home()));
    }
}