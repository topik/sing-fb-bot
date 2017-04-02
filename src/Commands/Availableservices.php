<?php
/**
 * @author Tomas Opekar <tomas.opekar@golemos.com>
 * @copyright Golemos s.r.o. 02.4.2017
 */


namespace Sing\Commands;


class Availableservices extends Command_manager
{
    public function run()
    {
        $buttons = [];
        foreach ($this->service_list() as $service) {
            $buttons[] = $service["enable"];
        }
        $this->send_payload("Here is available services:", $buttons);
    }
}
