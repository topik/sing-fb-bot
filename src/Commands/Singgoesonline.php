<?php
/**
 * @author Tomas Opekar <tomas.opekar@golemos.com>
 * @copyright Golemos s.r.o. 02.4.2017
 */


namespace Sing\Commands;


class Singgoesonline extends Command_manager
{
    public function run()
    {
        if (!$this->is_registered()) {
            $this->send_register_button();
            return;
        }

        $this->register_service("sing_online", 1, "Sing starts to stream");
    }
}
