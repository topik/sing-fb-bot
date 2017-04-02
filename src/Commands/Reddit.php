<?php
/**
 * @author Tomas Opekar <tomas.opekar@golemos.com>
 * @copyright Golemos s.r.o. 02.4.2017
 */


namespace Sing\Commands;


class Reddit extends Command_manager
{
    public function run()
    {
        $last_reddit = \dibi::fetch("SELECT `id_reddit`, `url`, `title` FROM `fb_reddit` 
                                         ORDER BY `id_reddit` DESC 
                                            LIMIT 1");
        $this->bot->send(
            new \pimax\Messages\StructuredMessage($this->message['sender']['id'],
                \pimax\Messages\StructuredMessage::TYPE_BUTTON, [
                    'text' => $last_reddit["title"],
                    'buttons' => [
                        new \pimax\Messages\MessageButton(\pimax\Messages\MessageButton::TYPE_WEB,
                            "Open on reddit",
                            "https://www.reddit.com" . $last_reddit["url"])
                    ]
                ]
            ));
    }

}
