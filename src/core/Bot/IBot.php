<?php


namespace Jallvar\Core\Bot;


use Telegram\Bot\Api;

interface IBot
{
    /**
     * IBot constructor.
     * @param $apiKey
     * @param $typeUpdate
     */
    public function __construct($apiKey, $typeUpdate);

    /**
     * @return mixed
     */
    public function getUpdates();

    /**
     * @return Api
     */
    public function getClient();

    /**
     * @param IMessageHandler $handler
     * @return mixed
     */
    public function addHandle(IMessageHandler $handler);

}