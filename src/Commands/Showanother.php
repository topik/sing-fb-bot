<?php
/**
 * @author Tomas Opekar <tomas.opekar@golemos.com>
 * @copyright Golemos s.r.o. 05.4.2017
 */


namespace Sing\Commands;


class Showanother
{
    public $bot;
    public $message;

    public function run()
    {
        $paste          = new Twitch_paste();
        $paste->command = "";
        $paste->bot     = $this->bot;
        $paste->message = $this->message;
        $paste->run();
    }
}
