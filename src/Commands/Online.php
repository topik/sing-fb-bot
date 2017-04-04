<?php
/**
 * @author Tomas Opekar <tomas.opekar@golemos.com>
 * @copyright Golemos s.r.o. 05.4.2017
 */


namespace Sing\Commands;


class Online extends Command_manager
{
    public $command;

    public function run()
    {
        $command = str_replace("online", "", $this->command);
        if ($this->is_online($command)) {
            $this->send_payload($command . " is currently streaming!",
                [["url" => "https://twitch.tv/" . $command, "title" => "Watch on Twitch"]]);
        } else {
            $this->send_message("No, " . $command . " is currently not streaming");
        }
    }

    private function is_online($user)
    {
        $api = json_decode(file_get_contents('https://api.twitch.tv/kraken/streams/' . $user . '?client_id=' . \Settings::TWITCH_CLIENT_ID));
        if ($api->stream === NULL) {
            return FALSE;
        }
        return TRUE;
    }
}
