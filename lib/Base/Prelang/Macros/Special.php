<?php


namespace lib\Base\Prelang\Macros;


use lib\Base\Prelang\Macros;

class Special extends Macros
{
    public function name()
    {
        return '{';
    }

    public function before(&$page, &$fragment)
    {
        $str = '<?= htmlentities('.$fragment[3][0].') ?>';

        $page = substr_replace($page, $str, $fragment[0][1], strlen($fragment[0][0]));
    }

    public function after(&$previous, &$page, &$resultMatches, &$fragment) {}

    public function finish(&$page, &$fragment) {}
}