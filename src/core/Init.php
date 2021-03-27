<?php


namespace Jallvar\Core;

//Класс инцилизации бота
use Jallvar\Core\Bot\Bot;
use Jallvar\Core\Bot\FacadeBot;
use Jallvar\core\Bot\MessageHandlers\ByeHandler;
use Jallvar\core\Bot\MessageHandlers\HelloHandler;
use Jallvar\Core\Bot\UpdateTypes;

class Init
{

    /**
     * Инцилизируем объект бота
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function run()
    {
        $bot = new FacadeBot(new Bot(
            Config::getInstance()->get("tgKey"), //Ключ API
            Config::getInstance()->get("tgTypeUpdate") //Тип обновлений, во время тестирования оставлю на ручном
        ));

        //Данный способ обработки использую для изучения паттерна - Цепочки обязанностей
        //Создаю нужные мне обработчики
        $helloHandler = new HelloHandler();
        $byeHandler = new ByeHandler();

        //Задаю цепочку обработчиков
        $helloHandler->setHandler($byeHandler);
        //Добавляю цепочку обработчиков
        $bot->addHandle($helloHandler);
        //Получаю обновления и обрабатываю
        $bot->getUpdates();
    }

    public function grabber()
    {
        //Получаем доступ к фасаду и функции отправки сообщений
        $tg = new Bot(
            Config::getInstance()->get("tgKey"),
            UpdateTypes::$MANUAL
        );

        //Создадим класс граббера
        $grabber = new GroupsGrabber();

        //Создадим объект сохранения постов и сохраняем посты
        $ts = new TelegramSaver($tg, $grabber);
        $ts->loadPosts();
    }
}