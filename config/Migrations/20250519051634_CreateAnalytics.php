<?php
declare(strict_types=1);

use  Phinx\Migration\AbstractMigration;

class CreateAnalytics extends AbstractMigration
{
    protected $config;
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     * @return void
     */
    public function setConfig($config)
    {
        $table = $this->table('analytics');
        $table->addColumn('Managemen', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->create();
        $this->config = $config;
    }
}
