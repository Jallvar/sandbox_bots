<?php


namespace Jallvar\Core;

class Config
{
    //Храним ссылки на объекты
    private static $instances = null;
    //Параметры конфигурации
    private static $config = null;

    //Загружаем конфиг
    protected function __construct() {
        self::$config = include("./config.php");
    }

    //Запрещаем клонировать и десириализировать класс
    protected function __clone() {}
    protected function __wakeup() {}

    //Создаем объект или возвращаем ссылку
    public static function getInstance() : Config
    {
        if(is_null(self::$instances))
            self::$instances = new static();
        return self::$instances;
    }

    //Вернем значение из конфига по ключу
    public function get($key)
    {
        return self::$config[$key];
    }
}