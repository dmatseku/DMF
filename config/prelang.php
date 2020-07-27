<?php

use lib\Base\Support\Session;

return [
    'appSpace' => 'app\\Prelang',
    'selfSpace' => 'lib\\Base\\Prelang',
    'viewDir' => Session::get('DIR', '').'app/Views',
    'handlers' => [
        'BaseCut' => [
            'InsertVariable',
            'Inc',
        ],
        'BaseFull' => [
            'Code',
        ],
        'BaseFullParam' => [
            'In',
        ],
        'Out' => [
            'Special',
            'Simple',
        ],
    ],
    'before' => [
        'BaseCut' => ['Inc', 'InsertVariable'],
        'Out' => ['Special', 'Simple'],
    ],
    'after' => [
        'BaseFullParam' => ['In'],
    ],
    'finish' => [
        'BaseFull' => ['Code'],
    ],
];