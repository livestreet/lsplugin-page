<?php
/**
 * Таблица БД
 */
$config['$root$']['db']['table']['page_main_page'] = '___db.table.prefix___page';
/**
 * Роутинг
 */
$config['$root$']['router']['page']['page'] = 'PluginPage_ActionPage';
/**
 * Показывать на страницах блок со структурой страниц
 */
$config['show_block_structure'] = true;

return $config;