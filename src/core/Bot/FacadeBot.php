<?php


namespace Jallvar\Core\Bot;

/*
 * Было принято решение сделать Facade для открытия функций API телеграм
 * и не вносить их в основной функционал бота
 */
class FacadeBot
{
    protected $_bot = null;

    /**
     * FacadeBot constructor.
     * @param IBot $newBot
     */
    public function __construct(IBot $newBot)
    {
        $this->_bot = $newBot;
    }

    /**
     * Запускаем обновления и процесс обработки сообщений
     * @return mixed
     */
    public function getUpdates()
    {
        return $this->_bot->getUpdates();
    }

    /**
     * Добавляем обработчик сообщений
     * @param $handler
     */
    public function addHandle(IMessageHandler $handler)
    {
        $this->_bot->addHandle($handler);
    }

    /**
     * @param $userID
     * @param $text
     */
    public function sendMessage($userID, $text)
    {
        $this->_bot->getClient()->sendMessage([
            "chat_id" => $userID,
            "text" => $text,
        ]);
    }
}