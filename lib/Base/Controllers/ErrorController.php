<?php


namespace   lib\Base\Controllers;


use lib\Base\Http\Request;
use lib\Base\Support\Config;
use lib\Base\Views\View;

class   ErrorController
{
    /**
     * 404 error presentation
     *
     * @param Request $request
     *
     * @return View
     */
    public function err404(Request $request)
    {
        if (Config::get('app', 'devmode', false)) {
            return (new View('@libView/Errors/Error404'))
                ->with($request->all());
        }
        return (new View('@libView/Errors/Error404'))
            ->with([
                'error' => 'Page not found',
                'code' => 404
            ]);
    }

    /**
     * 403 error presentation
     *
     * @param Request $request
     *
     * @return View
     */
    public function err403(Request $request)
    {
        if (Config::get('app', 'devmode', false)) {
            return (new View('@libView/Errors/Error403'))
                ->with($request->all());
        }
        return (new View('@libView/Errors/Error403'))
            ->with([
                'error' => 'Forbidden',
                'code' => 403
            ]);
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
            return (new View('@libView/Errors/Error500'))
                ->with($request->all());
        }
        return (new View('@libView/Errors/Error500'))
            ->with([
                'error' => 'Internal server error',
                'code' => 500
            ]);
    }
}