<?php
/**
 * @author Tomas Opekar <tomas.opekar@golemos.com>
 * @copyright Golemos s.r.o. 02.4.2017
 */


namespace Sing\Commands;


class Singonline extends Command_manager
{
    public function run()
    {
        $stream_data = $this->get_api_request();
        if ($this->is_online($stream_data)) {
            $this->send_payload("SingSing is currently streaming!",
                [["url" => "https://twitch.tv/sing_sing", "title" => "Watch on Twitch"]]);
        } else {
            $this->send_message("No, SingSing is currently not streaming");
        }
    }

    public function is_online($stream_data)
    {
        if ($stream_data->stream === NULL) {
            return FALSE;
        }
        return TRUE;
    }

    public function get_stream_start_time($stream_data)
    {
        if ($this->is_online($stream_data)) {
            return new \DateTime($stream_data->stream->created_at);
        }
        return FALSE;
    }

    public function get_api_request()
    {
        return json_decode(file_get_contents('https://api.twitch.tv/kraken/streams/sing_sing?client_id=' . \Settings::TWITCH_CLIENT_ID));
    }
}
