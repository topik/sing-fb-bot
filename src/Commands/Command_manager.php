<?php
/**
 * @author Tomas Opekar <tomas.opekar@golemos.com>
 * @copyright Golemos s.r.o. 02.4.2017
 */


namespace Sing\Commands;


abstract class Command_manager
{
    /**
     * @var \pimax\FbBotApp
     */
    public $bot;
    public $message;

    public function me()
    {
        return "its me";
    }

    final function send_message($text)
    {
        $message = new \pimax\Messages\Message($this->message['sender']['id'], $text);
        $this->bot->send($message);
    }

    final function send_payload($text, $buttons)
    {
        $pixmax_buttons = [];
        foreach ($buttons as $button) {
            if (isset($button["url"])) {
                $pixmax_buttons[] = new \pimax\Messages\MessageButton(\pimax\Messages\MessageButton::TYPE_WEB,
                    $button["title"],
                    $button["url"]);
            } else {
                $pixmax_buttons[] = new \pimax\Messages\MessageButton(\pimax\Messages\MessageButton::TYPE_POSTBACK,
                    $button);
            }

        }
        $message = new \pimax\Messages\StructuredMessage($this->message['sender']['id'],
            \pimax\Messages\StructuredMessage::TYPE_BUTTON, [
                'text' => $text,
                'buttons' => $pixmax_buttons
            ]
        );
        $this->bot->send($message);
    }

    final function is_registered()
    {
        if (\dibi::fetchSingle("SELECT `id_user` FROM `fb_users` WHERE `id_user` = %i",
            $this->message['sender']['id'])
        ) {
            return TRUE;
        }
        return FALSE;
    }

    final function send_register_button()
    {
        $this->send_payload("You are not registered, do you want to register?", ["Register"]);
    }

    final function register_service($service, $service_status, $text)
    {
        $vals = [
            "id_user%i" => $this->message['sender']['id'],
            $service . "%i" => $service_status
        ];
        try {
            \dibi::query("INSERT INTO `fb_services`", $vals,
                "ON DUPLICATE KEY UPDATE %n = values(%n)", $service, $service);
            if ($service_status) {
                $this->send_message("All right, I will send you a notification when " . $text . ".");
            } else {
                $this->send_message("All right, notification for " . $text . " disabled.");
            }

        } catch (\Dibi\Exception $e) {
            $this->send_message("Error, try it again.");
        }
    }

    final function service_list()
    {
        return [
            "sing_online" => [
                "name" => "sing_online",
                "enable" => "Sing goes online",
                "disable" => "Sing goes online disable"
            ],
            "reddit" => [
                "name" => "reddit",
                "enable" => "Reddit patch updates",
                "disable" => "Reddit patch updates disable"
            ]
        ];
    }

    abstract function run();
}
