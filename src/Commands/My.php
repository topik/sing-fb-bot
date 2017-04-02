<?php
/**
 * @author Tomas Opekar <tomas.opekar@golemos.com>
 * @copyright Golemos s.r.o. 02.4.2017
 */


namespace Sing\Commands;


class My extends Command_manager
{
    public function run()
    {
        $result = \dibi::query("SELECT * FROM `fb_services` WHERE `id_user` = %i",
            $this->message['sender']['id'])->fetch();
        if ($result) {
            $buttons = [];
            foreach ($this->service_list() as $service_name => $service_buttons) {
                if ($result[$service_name] == 1) {
                    $buttons[] = $service_buttons["disable"];
                }
            }
            if (count($buttons)) {
                $this->send_payload("You can unsubscribe from this:", $buttons);
                return;
            }
        }
        $this->send_payload("You are not subscribed for any notifications.", ["Available services"]);

    }
}
