<?php


namespace Jallvar\core;


use Jallvar\Core\Bot\IBot;

class TelegramSaver
{
    private $tgBot = null;
    private $grabber = null;

    public function __construct(IBot $newBot, IGrabber $newGrabber)
    {
        $this->tgBot = $newBot;
        $this->grabber = $newGrabber;
    }

    //Грязный вариант. Дальше это нужно будет разделить. TG API дать доступ через Facade
    public function loadPosts()
    {
        $posts = null;

        try {
            $posts = $this->grabber->getPosts();
        }
        catch (\Exception $ex)
        {
            $this->tgBot->sendMessage(Config::getInstance()->get("tgAdminID"), $ex->getMessage());
        }

        if(!$posts) return false;

        foreach ($posts["items"] as $post)
        {
            if(!$post["attachments"]) continue;

            foreach($post["attachments"] as $attachment) {
                if($attachment["type"] !== "photo") continue;

                $sizes = $attachment["photo"]["sizes"];
                file_put_contents("uploadFile.jpg", file_get_contents($sizes[count($sizes)-1]["url"]));
                $this->tgBot->getClient()->sendPhoto([
                    "chat_id" => Config::getInstance()->get("tgAdminID"),
                    "photo" => "uploadFile.jpg",
                ]);
                unlink("uploadFile.jpg");
            }

            $this->tgBot->getClient()->sendMessage([
                "chat_id" => Config::getInstance()->get("tgAdminID"),
                "text" => $post["text"],
            ]);
        }
    }
}