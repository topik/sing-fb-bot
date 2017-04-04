<?php
/**
 * @author Tomas Opekar <tomas.opekar@golemos.com>
 * @copyright Golemos s.r.o. 02.4.2017
 */


namespace Sing\Commands;


class Error_command extends Command_manager
{
    public function run()
    {
        $this->send_payload("Here is few options for you", ["Available commands", "Available services"]);
    }

    public function welcome()
    {
        $this->send_payload("Hi. I'am Dota Updates bot. I can help you to get updates about new dota patches and lot of other stuffs.",
            ["Available commands", "Available services"]);
    }
}
