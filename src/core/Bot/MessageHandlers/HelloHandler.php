<?php


namespace Jallvar\core\Bot\MessageHandlers;

use Jallvar\core\Bot\MessageHandler;
use Telegram\Bot\Objects\Message;

class HelloHandler extends MessageHandler
{
    /**
     * Поприветствуем нового пользователя на команду /start
     * @param Message $message
     * @return mixed|string|null
     */
    public function handle(Message $message)
    {
        return ($message->getText() == "/start")? "Hello friend!" : parent::handle($message);
    }
}