<?php


namespace   lib\Base\Routing;

use         lib\Base\Http\Response;
use         lib\Base\Support\Session;


class   RouteRedirect extends Response
{
    /**
     * @var string Path to redirect
     */
    private string  $redirectPath;

    /**
     * execute redirect
     */
    public function         run()
    {
        Session::flash('redirectInput', $this->args);
        header_remove();
        header('Location: '.$this->redirectPath);
        exit;
    }

    /**
     * RouteRedirect constructor.
     *
     * @param string $route
     */
    public function         __construct(string $route)
    {
        $this->redirectPath = 'http://'.$_SERVER['HTTP_HOST'].'/'.$route;
    }

    /**
     * redirect to last route
     *
     * @return RouteRedirect
     */
    public static function  back(): RouteRedirect
    {
        return new RouteRedirect(Session::get('previousRoute', Router::home()));
    }
}