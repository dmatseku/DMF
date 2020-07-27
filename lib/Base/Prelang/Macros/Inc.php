<?php


namespace lib\Base\Prelang\Macros;


use lib\Base\Prelang\Macros;
use lib\Base\Prelang\Prelang;

class Inc extends Macros
{

    public function name()
    {
        return 'include';
    }

    public function before(&$page, &$fragment)
    {
        $file = Prelang::getPage(trim($fragment[3][0], " \t\n\r\0\x0B'"));
        if (!$file) {
            $file = '';
        }

        $page = substr_replace($page, $file, $fragment[0][1], strlen($fragment[0][0]));
    }

    public function after(&$previous, &$page, &$resultMatches, &$fragment) {}

    public function finish(&$page, &$fragment) {}
}