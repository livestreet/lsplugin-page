<?php

/*
 * Описание настроек плагина для интерфейса редактирования
 */
$config['$config_scheme$'] = array(
    'show_block_structure' => array(
        /*
         * тип: integer, string, array, boolean, float
         */
        'type'        => 'boolean',
        /*
         * отображаемое имя параметра, ключ языкового файла
         */
        'name'        => 'config.show_block_structure.name',
        /*
         * отображаемое описание параметра, ключ языкового файла
         */
        'description' => 'config.show_block_structure.description',
    ),
);


/**
 * Описание разделов для настроек
 * Каждый раздел группирует определенные параметры конфига
 */
$config['$config_sections$'] = array(
    /**
     * Настройки раздела
     */
    array(
        /**
         * Название раздела
         */
        'name'         => 'config_sections.main',
        /**
         * Список параметров для отображения в разделе
         */
        'allowed_keys' => array(
            'show_block_structure',
        ),
    ),
);

return $config;