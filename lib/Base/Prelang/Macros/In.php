<?php


namespace lib\Base\Prelang\Macros;


use lib\Base\Prelang\Macros;

class In extends Macros
{
    public function name()
    {
        return 'in';
    }

    public function before(&$page, &$fragment){}

    public function after(&$previous, &$page, &$resultMatches, &$fragment)
    {
        $contentNames = explode(',', trim($fragment[3][0], " \t\n\r\0\x0B'"));

        foreach ($contentNames as $name) {
            foreach ($resultMatches as $resultMatch) {
                if ($resultMatch[2] === 'section' &&
                    trim($resultMatch[3][0], " \t\n\r\0\x0B'") === trim($name, " \t\n\r\0\x0B'")) {
                    $previous = substr_replace($previous, $fragment[4][0], $resultMatch[0][1], strlen($resultMatch[0][0]));
                }
            }
        }
    }

    public function finish(&$page, &$fragment){}
}