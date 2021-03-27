<?php


namespace Jallvar\Core\Bot;


use Jallvar\Core\Config;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

class Bot implements IBot
{
    /**
     * Содержит объект клиента тг
     * @var Api|null
     */
    private $_client = null;
    /**
     * Содержит тип обновления тг. вебхук или ручной
     * @var null
     */
    private $_typeUpdate = null;
    /**
     * Содержит массив обновлений от тг
     * @var Update[]
     */
    private $_updates = null;

    /**
     * Цепочка обработчиков сообщений
     * @var IMessageHandler
     */
    protected $_handlers = null;


    //Пытаюсь создать меньше зависимостей от объектов

    /**
     * Bot constructor.
     * @param string $apiKey
     * @param string $typeUpdate
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function __construct($apiKey, $typeUpdate)
    {
        $this->_client = new Api($apiKey);
        $this->_typeUpdate = $typeUpdate;
    }

    /**
     * Закладываю возможность обновления вручную
     * Бот будет работать через webhooks
     *
     * @throws \Exception
     */
    public function getUpdates()
    {
        switch ($this->_typeUpdate)
        {
            case UpdateTypes::$MANUAL:
                $this->_updates = $this->_client->getUpdates();
                break;

            case UpdateTypes::$WEBHOOKS:
                $this->_updates = $this->_client->getWebhookUpdates();
                break;

            default:
                throw new \Exception("Unknown type updates for api server");
                break;
        }

        $this->_handle();
    }

    /**
     * Разрешим вернуть объект клиента для работы Facade
     * @return Api
     */
    public function getClient()
    {
        return $this->_client;
    }

    /**
     * Добавляем нового обработчика сообщений
     * @param IMessageHandler $handler
     */
    public function addHandle(IMessageHandler $handler)
    {
        $this->_handlers = $handler;
    }

    /**
     * Обрабатываем входящие сообщения
     */
    private function _handle()
    {
        //var_dump($this->_updates);
        foreach ($this->_updates as $update)
        {
            $response = $this->_handlers->handle($update->getMessage());
            if($response)
                $this->_client->sendMessage([
                    "chat_id" => $update->getMessage()->getFrom()->getId(),
                    "text" => $response,
                ]);
        }
    }


}