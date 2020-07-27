<?php

use lib\Base\Support\Config;

?>
<html lang="en">
<head>
    <title>Error</title>
    <meta charset="utf-8">
    <style>
        body {
            background-color: #EDF2F4;
        }
        h1 {
            font-size: 18rem;
            color: #98C1D9;
            margin-top: 3rem;
            margin-bottom: 1rem;
            margin-block-end: 0;
            text-align: center;
        }
        #error {
            font-size: 5rem;
            color: #3D5A80;
            text-align: center;
            margin-block-start: 0;
            margin-block-end: 0;
        }
        #trace {
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }
        #trace h2, #trace p {
            color: #293241;
        }
        #trace h2 {
            margin-top: 1rem;
        }
        #trace p {
            text-wrap: normal;
        }
    </style>
</head>
<body>
    <h1><?= $code ?></h1>
    <p id="error"><?= $error ?></p>
    <?php if (Config::get('app', 'devmode', false)): ?>
        <div id="trace">
            <?php if (isset($trace)): ?>
                <div>
                    <h2>Trace:</h2>
                    <?php foreach ($trace as $value): ?>
                        <p><?= 'File: '.$value['file'].'; line: '.$value['line'] ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</body>
</html>