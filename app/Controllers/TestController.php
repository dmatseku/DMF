<?php


namespace app\Controllers;


use lib\Base\Http\Request;
use lib\Base\Routing\RouteRedirect;
use lib\Base\Validation\Validator;
use lib\Base\Views\View;

class TestController
{
    public function index(Request $request)
    {
        return (new View('@view/Test'))->with(['var' => 'hello'])->withInput($request->all())->withErrors($request->all());
    }

    public function index1(Request $request)
    {
        $validator = new Validator([
            'var' => 'string|min:3|max:5'
        ]);
        $validator->validate($request->all());
        return RouteRedirect::back()->withInput($request->all())->withErrors($validator->getErrorMessages());
    }
}