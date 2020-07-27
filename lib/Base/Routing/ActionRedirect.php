<?php


namespace   lib\Base\Routing;

use         lib\Base\Http\Response;
use         lib\Base\Support\Session;


class   ActionRedirect extends Response
{
    protected   $redirectAction;

    public function         run()
    {
        Session::flash('redirectInput', $this->args);
        Router::getInstance()->getResponseByAction($this->redirectAction)->run();
    }

    public function         __construct($action)
    {
        $this->redirectAction = $action;
    }

}