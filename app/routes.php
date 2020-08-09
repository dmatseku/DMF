<?php

use lib\Base\Routing\Router;

Router::get('', 'TestController@index');
Router::post('h', 'TestController@index1');