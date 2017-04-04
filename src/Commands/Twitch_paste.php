<?php
/**
 * @author Tomas Opekar <tomas.opekar@golemos.com>
 * @copyright Golemos s.r.o. 04.4.2017
 */


namespace Sing\Commands;


class Twitch_paste extends Command_manager
{
    public $command;

    public function run()
    {
        $command = str_replace("Paste", "", $this->command);
        $where   = NULL;
        if (strlen($command)) {
            //random selection
            $where = ["name%~like~" => $command];
        }
        $paste   = $this->find_paste($where);
        $buttons = ["Show another"];
        if (strlen($command) and $paste) {
            $buttons[] = "Paste " . $command;
        }
        if (!$paste) {
            $paste = $this->find_paste();
        }
        $buttons[] = "Paste list";
        $this->send_payload($paste["paste"], $buttons);
    }

    private function find_paste($where = NULL)
    {
        if ($where === NULL) {
            $where = ["name" => ""];
        }

        return \dibi::query("SELECT * FROM `fb_twitch_paste`
                                    WHERE %and", $where, "
                                    ORDER BY RAND() LIMIT 1")->fetch();
    }
}
