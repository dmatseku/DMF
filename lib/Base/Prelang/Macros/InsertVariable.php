<?php


namespace lib\Base\Prelang\Macros;


use lib\Base\Prelang\Macros;

class InsertVariable extends Macros
{

    public function name()
    {
        return '';
    }

    public function before(&$page, &$fragment)
    {
        $var = $this->$fragment[3][0] ?? '';
        $var = trim($var, " \t\n\r\0\x0B'");

        $page = substr_replace($page, '$this->'.$var, $fragment[0][1], strlen($fragment[0][0]));
    }

    public function after(&$previous, &$page, &$resultMatches, &$fragment) {}

    public function finish(&$page, &$fragment) {}
}