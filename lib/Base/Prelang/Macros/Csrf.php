<?php


namespace lib\Base\Prelang\Macros;


use Prelang\Fragment;
use Prelang\Macro\Macro;

class Csrf extends Macro
{

    public function name(): string
    {
        return 'csrf';
    }

    public function before(Fragment $fragment): ?string {return null;}

    public function after(Fragment $fragment): ?string {return null;}

    public function finish(Fragment $fragment): ?string {
        return "<input type=hidden name=\"__csrf\" value=\"".\lib\Base\Http\Csrf::generate()."\">";
    }

    public function clean(string &$result): void {}
}