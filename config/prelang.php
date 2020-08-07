<?php

use lib\Base\Support\Session;

return [
    'spaces' => [
        'app\\Prelang',
        'lib\\Base\\Prelang'
    ],
    'viewDir' => [
       'view' => Session::get('DIR', '').'app/Views',
       'libView' => Session::get('DIR', '').'lib/Base/Views',
    ],
    'handlers' => [
        'Base' => [
            'OperatorElse',
        ],
        'BaseCut' => [
            'Inc',
            'OperatorElseif',
        ],
        'BaseFull' => [
            'Code',
        ],
        'BaseFullParam' => [
            'Define',
            'Error',
            'In',
            'OperatorIf',
            'OperatorForeach',
            'OperatorFor',
            'OperatorWhile',
        ],
        'Out' => [
            'Special',
            'Simple',
        ],
    ],
    'before' => [
        'BaseCut' => ['Inc'],
        'BaseFullParam' => ['Define'],
    ],
    'after' => [
        'BaseFullParam' => ['In'],
    ],
    'finish' => [
        'BaseFull' => ['Code'],
        'BaseFullParam' => [
            'Error',
            'OperatorIf',
            'OperatorForeach',
            'OperatorFor',
            'OperatorWhile',
        ],
        'BaseCut' => ['OperatorElseif'],
        'Base' => ['OperatorElse'],
        'Out' => ['Special', 'Simple'],
    ],
];
