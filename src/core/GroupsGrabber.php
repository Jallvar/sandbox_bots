<?php


namespace Jallvar\core;


use VK\Client\VKApiClient;

class GroupsGrabber implements IGrabber
{
    /**
     * @var VKApiClient
     */
    private $_client = null;

    /**
     * GroupsGrabber constructor.
     */
    public function __construct()
    {
        $this->_client = new VKApiClient();
    }

    /**
     * @return mixed
     * @throws \VK\Exceptions\Api\VKApiBlockedException
     * @throws \VK\Exceptions\VKApiException
     * @throws \VK\Exceptions\VKClientException
     */
    public function getPosts()
    {
        $config = Config::getInstance();

        $posts = $this->_client->wall()->get($config->get("vkApiKey"),
        [
            "owner_id" => $config->get("groupID"),
            "count" => 10
        ]);

        return $posts;
    }
}