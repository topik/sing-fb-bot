<?php
/**
 * @author Tomas Opekar <tomas.opekar@golemos.com>
 * @copyright Golemos s.r.o. 02.4.2017
 */


namespace Sing\Commands;


class Register extends Command_manager
{
    public function run()
    {
        $vals = [
            "id_user" => $this->message['sender']['id']
        ];
        try {
            \dibi::query("INSERT INTO `fb_users`", $vals);
            $message = "Done.";

        } catch (\Dibi\Exception $e) {
            $message = "You are already registered.";
        }
        $this->send_payload($message . " Do you want to be reminded when:",
            ["Sing goes online"]);

    }
}
