<?php


namespace migration;


use lib\Base\Database\DB;
use lib\Base\Database\Migration;

class test implements Migration
{

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        DB::query('
            CREATE OR REPLACE TABLE `admin_dmf`.`test` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `tmp1` VARCHAR(45) NOT NULL,
              `tmp2` VARCHAR(45) NULL,
              PRIMARY KEY (`id`));
            ')->execute();
    }

    /**
     * @inheritDoc
     */
    public function destroy(): void
    {
        DB::query('DROP TABLE IF EXISTS `admin_dmf`.`test`');
    }
}