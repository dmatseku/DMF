<?php


namespace   lib\Base\Database;


interface   Migration
{
    /**
     * Call in "setup migrate"
     *
     * @return void
     */
    public function init(): void;

    /**
     * Call in "setup destroy"
     *
     * @return void
     */
    public function destroy(): void;
}