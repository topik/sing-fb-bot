<?php
/**
 * @author Tomas Opekar <tomas.opekar@golemos.com>
 * @copyright Golemos s.r.o. 05.4.2017
 */


namespace Sing\Commands;


class Pastelist extends Command_manager
{

    public function run()
    {
        $names   = \dibi::query("SELECT `name` FROM `fb_twitch_paste` 
                                     WHERE name != '' 
                                  GROUP BY `name`")->fetchAll();
        $message = ["Available paste players/persons (just send paste name, f.e.: paste arteezy):\r\n"];
        foreach ($names as $name) {
            $message[] = $name["name"];
        }
        $this->send_message(join("\r\n", $message));
    }
}
