<?php

use lib\Base\Support\Session;

return [
    'Spaces' => [
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
