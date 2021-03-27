<?php

//Подгружаем автозагрузчик
//Начинаю знакомится с PSR
//Самый простой способ реализации через composer autoload
//Стараюсь деласть согласно PSR-4
require "./vendor/autoload.php";

//Создаем и запускаем объект бота
$bot = new \Jallvar\Core\Init();
$bot->run();