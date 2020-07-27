<?php


namespace lib\Base\Prelang\Macros;


use lib\Base\Prelang\Macros;

class Code extends Macros
{
    public function name()
    {
        return 'php';
    }

    public function before(&$page, &$fragment) {}

    public function after(&$previous, &$page, &$resultMatches, &$fragment) {}

    public function finish(&$page, &$fragment)
    {
        $page = substr_replace($page, '<?php ', $fragment[1][1], strlen($fragment[1][0]));
        $page = substr_replace($page, ' ?>', $fragment[4][1], strlen($fragment[4][0]));
    }
}