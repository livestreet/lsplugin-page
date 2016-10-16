<?php

class PluginPage_Update_CreateTable extends ModulePluginManager_EntityUpdate
{
    /**
     * Выполняется при обновлении версии
     */
    public function up()
    {
        if (!$this->isTableExists('prefix_page')) {
            /**
             * При активации выполняем SQL дамп
             */
            $this->exportSQL(Plugin::GetPath(__CLASS__) . '/update/2.0/dump.sql');
        }
    }

    /**
     * Выполняется при откате версии
     */
    public function down()
    {
        // $this->exportSQLQuery('DROP TABLE prefix_page;');
    }
}