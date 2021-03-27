<?php


namespace Jallvar\core\Bot;


use Telegram\Bot\Objects\Message;

abstract class MessageHandler implements IMessageHandler
{
    /**
     * @var IMessageHandler
     */
    protected $nextHandler = null;

    /**
     * Устанавливает новый обработчик
     * @param IMessageHandler $handler
     * @return IMessageHandler
     */
    public function setHandler(IMessageHandler $handler): IMessageHandler
    {
        $this->nextHandler = $handler;

        return $handler;
    }

    /**
     * Выполняем обработку или завершаем цепь обработки
     * @param Message $message
     * @return mixed|null
     */
    public function handle(Message $message)
    {
        return (is_null($this->nextHandler))? null : $this->nextHandler->handle($message);
    }
}