<?php


namespace   lib\Base\Database;


interface   Migration
{
    public function init();
    public function destroy();
}