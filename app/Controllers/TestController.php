<?php


namespace app\Controllers;


use lib\Base\Database\DB;
use lib\Base\Http\Request;
use lib\Base\Views\View;
use app\Models\Test;

class TestController
{
    public function index(Request $request)
    {
        $model = DB::query('select * from test')->execute(null, Test::class);
        return (new View('@view/Test.prelang.php'))->with(['model' => $model]);
    }
}