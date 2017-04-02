<?php
/**
 * @author Tomas Opekar <tomas.opekar@golemos.com>
 * @copyright Golemos s.r.o. 02.4.2017
 */


namespace Sing\Commands;


class Redditpatchupdatesdisable extends Command_manager
{
    public function run()
    {
        if (!$this->is_registered()) {
            $this->send_register_button();
            return;
        }

        $this->register_service("reddit", 0, "new game updates (reddit)");

    }
}
