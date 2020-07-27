<?php

use lib\Base\Routing\Router;

Router::get('', 'TestController@index');
Router::get('ind1', 'TestController@index1');