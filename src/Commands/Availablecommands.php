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
            "Command list: ( dont write [] into your requests) \n\r\n\r" .
            "register - use it to be able to get notifications from me\n\r" .
            "hi \n\r" .
            "my - shows your subscribed services \n\r" .
            "available commands \n\r" .
            "available services \n\r" .
            "reddit - get informations about last patch from /user/SirBelvedere\n\r" .
            "sing online - tells you if Sing is streaming\n\r" .
            "paste - get random copypaste \n\r" .
            "paste [person] - get random copypaste from [person] \n\r" .
            "paste list - get list of available persons\n\r" .
            "[person] online - tells you, if [person] is streaming on Twitch \n\r" .
            " \n\r"
        );
    }
}
