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
        'Base',
        'BaseCut',
        'BaseFull',
        'BaseFullParam',
        'Out',
    ],
    'macros' => [
        'Define' => ['BaseFullParam'],
        'Inc' => ['BaseCut'],
        'In' => ['BaseFullParam'],
        'Code' => ['BaseFull'],
        'OperatorIf' => ['BaseFullParam'],
        'OperatorElse' => ['Base'],
        'OperatorElseif' => ['BaseCut'],
        'OperatorWhile' => ['BaseFullParam'],
        'OperatorFor' => ['BaseFullParam'],
        'OperatorForeach' => ['BaseFullParam'],
        'OperatorSwitch' => ['BaseFullParam'],
        'OperatorCase' => ['BaseCut'],
        'OperatorDefault' => ['Base'],
        'OperatorBreak' => ['Base'],
        'OperatorContinue' => ['Base'],
        'Special' => ['Out'],
        'Simple' => ['Out'],
        'Csrf' => ['Base'],
        'Error' => ['BaseFullParam'],
    ],
    'before' => [
        'Inc',
        'Define',
    ],
    'after' => [
        'In',
    ],
    'finish' => [
        'Code',
        'Error',
        'OperatorIf',
        'OperatorElseif',
        'OperatorElse',
        'OperatorSwitch',
        'OperatorCase',
        'OperatorDefault',
        'OperatorForeach',
        'OperatorFor',
        'OperatorWhile',
        'OperatorBreak',
        'OperatorContinue',
        'Csrf',
        'Special',
        'Simple',
    ],
];
