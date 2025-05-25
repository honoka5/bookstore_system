<?php
namespace Migrations;
use  Phinx\Migration\AbstractMigration;

class BaseMigration extends AbstractMigration
{
    // 必要な処理を書く
    public function setConfig($config){


        $this->config = $config;
    }
}