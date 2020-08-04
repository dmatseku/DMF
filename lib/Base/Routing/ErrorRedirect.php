<?php


namespace lib\Base\Routing;


use lib\Base\Http\Request;
use lib\Base\Support\Session;

class ErrorRedirect extends ActionRedirect
{
    /**
     * @return mixed|void
     */
    public function         run()
    {
        Session::flash('redirectInput', $this->args);

        $formattedAction = Router::formatAction($this->redirectAction);
        $request = new Request('Action', $this->redirectAction);

        $controller = new $formattedAction[0]();
        $controller_func = $formattedAction[1];

        return $controller->$controller_func($request)->run();
    }
}