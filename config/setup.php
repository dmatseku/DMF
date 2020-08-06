#!/usr/bin/php

<?php

use lib\Base\Support\Config;

spl_autoload_register(function($class) {
    $class = '../'.str_replace('\\', '/', $class).'.php';

    if (file_exists($class)) {
        require_once $class;
    }
});


$destroy = false;
if (($destroy = in_array('destroy', $argv, true)) || in_array('migrate', $argv, true)) {
    $dbInfo = Config::get('database', 'MIGRATION', []);

    if ($destroy) {
        foreach ($dbInfo as $migrate) {
            if (class_exists($migrate = 'migration\\'.$migrate) &&
                ($mg = new $migrate) instanceof lib\Base\Database\Migration) {
                $mg->destroy();
            }
        }
    } else {
        foreach ($dbInfo as $migrate) {
            if (class_exists($migrate = 'migration\\'.$migrate) &&
                ($mg = new $migrate) instanceof lib\Base\Database\Migration) {
                $mg->init();
            }
        }
    }
}

$dirs = [
    'Controllers',
    'Models',
    'Rules',
    'Views',
    'Prelang',
    'Prelang/Macros',
    'Prelang/Handlers',
];

if (in_array('clean', $argv, true)) {
    clean('../app');

    foreach ($dirs as $dir) {
        $dir = '../app/'.$dir;

        if (!mkdir($dir, 0775) && !is_dir($dir)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $dir));
        }
    }

    file_put_contents('../app/routes.php', "<?php\n\nuse lib\Base\Routing\Router;");
}

if (in_array('restore', $argv, true)) {
    foreach ($dirs as $dir) {
        $dir = '../app/'.$dir;

        if (!file_exists($dir) || !is_dir($dir)) {
            if (!mkdir($dir, 0775) && !is_dir($dir)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $dir));
            }
        }
    }

    if (!file_exists('../app/routes.php') || !is_file('../app/routes.php')) {
        file_put_contents('../app/routes.php', "<?php\n\nuse lib\Base\Routing\Router;");
    }
}

function clean() {
    $path = '../app';
    if (file_exists($path)) {

        $objects = new RecursiveIteratorIterator (
            new RecursiveDirectoryIterator($path),
            RecursiveIteratorIterator::SELF_FIRST);
        $directories = array();

        foreach ($objects as $name => $object) {
            if (is_file($name)) {
                unlink($name);
            } elseif (is_dir($name) && !preg_match('/^.*\/(\.\.)|\.$/', $name)) {
                $directories[] = $name;
            }
        }

        arsort($directories);
        foreach ($directories as $name) {
            rmdir($name);
        }
    }
}