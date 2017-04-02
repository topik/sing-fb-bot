<?php
/**
 * @author Tomas Opekar <tomas.opekar@golemos.com>
 * @copyright Golemos s.r.o. 02.4.2017
 */


namespace Sing\Commands;


class Hi extends Command_manager
{
    public function run()
    {
        $this->send_message("herro");
    }
}
