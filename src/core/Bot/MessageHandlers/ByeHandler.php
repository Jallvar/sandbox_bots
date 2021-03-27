<?php


namespace Jallvar\core\Bot\MessageHandlers;


use Jallvar\core\Bot\MessageHandler;
use Telegram\Bot\Objects\Message;

class ByeHandler extends MessageHandler
{
    /**
     * Прощается в ответ на команду /bye
     * @param Message $message
     * @return mixed|string|null
     */
    public function handle(Message $message)
    {
        return ($message->getText() == "/bye") ? "bye!" : parent::handle($message);
    }
}