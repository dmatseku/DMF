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
        return (new View('@view/Test.prelang.php'))->with(['var' => 'hello']);
    }
}