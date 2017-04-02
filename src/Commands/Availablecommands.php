<?php
/**
 * @author Tomas Opekar <tomas.opekar@golemos.com>
 * @copyright Golemos s.r.o. 02.4.2017
 */


namespace Sing\Commands;


class Availablecommands extends Command_manager
{
    public function run()
    {

        $this->send_message(
            "Command list: \n\r" .
            "register - use it to be able to get notifications from me\n\r" .
            "hi \n\r" .
            "my - shows your subscribed services \n\r" .
            "available commands \n\r" .
            "available services \n\r" .
            "reddit - get informations about last patch from /user/SirBelvedere\n\r" .
            "sing online - tells you if Sing is streaming\n\r" .
            " \n\r"
        );
    }
}
