<?php


namespace lib\Base\Prelang\Macros;


use Prelang\Fragment;
use Prelang\Macro;

class Csrf extends Macro
{

    public function name(): string
    {
        return 'csrf';
    }

    public function before(Fragment $fragment) {}

    public function after(Fragment $fragment) {}

    public function finish(Fragment $fragment) {
        return "<input type=hidden name=\"__csrf\" value=\"".\lib\Base\Http\Csrf::generate()."\">";
    }

    public function clean(Fragment $fragment): void {}
}