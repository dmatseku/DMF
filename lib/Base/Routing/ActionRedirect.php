<?php


namespace   lib\Base\Routing;

use         lib\Base\Http\Response;
use         lib\Base\Support\Session;


class   ActionRedirect extends Response
{
    protected string    $redirectAction;

    /**
     * make responce from other action
     */
    public function         run()
    {
        Session::flash('redirectInput', $this->args);
        Router::getInstance()->getResponseByAction($this->redirectAction)->run();
    }

    /**
     * ActionRedirect constructor.
     *
     * @param string $action
     */
    public function         __construct(string $action)
    {
        $this->redirectAction = $action;
    }

}