<?php


namespace   lib\Base\Controllers;


use lib\Base\Http\Request;
use lib\Base\Support\Config;
use lib\Base\Views\View;

class   ErrorController
{
    /**
     * 40x error presentation
     *
     * @param Request $request
     *
     * @return View
     */
    public function err40x(Request $request)
    {
        return (new View('@libView/Errors/Error40x.php'))
            ->with($request->all());
    }

    /**
     * 500 error presentation
     *
     * @param Request $request
     *
     * @return View
     */
    public function err500(Request $request)
    {
        if (Config::get('app', 'devmode', false)) {
            return (new View('@libView/Errors/Error500.php'))
                ->with($request->all());
        }
        echo "hello<br>";
        return (new View('@libView/Errors/Error500.php'))
            ->with([
                'error' => 'Internal server error',
                'code' => 500
            ]);
    }
}