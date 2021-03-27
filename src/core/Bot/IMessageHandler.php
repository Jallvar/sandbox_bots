<?php


namespace Jallvar\core\Bot;


use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

interface IMessageHandler
{
    /**
     * @param IMessageHandler $handler
     * @return IMessageHandler
     */
    public function setHandler(IMessageHandler $handler) : IMessageHandler;

    /**
     * @param Message $message
     * @return mixed
     */
    public function handle(Message $message);
}