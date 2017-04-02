<?php
/**
 * @author Tomas Opekar <tomas.opekar@golemos.com>
 * @copyright Golemos s.r.o. 02.4.2017
 */


namespace Sing;


class Notifications
{
    private $service;
    private $last_id;

    public function __construct($service, $last_id)
    {
        $this->service = $service;
        $this->last_id = $last_id;
    }

    public function select()
    {
        return \dibi::query("SELECT `fb_users`.`id_user`, `fb_notifications`.`value` FROM `fb_users`
                   LEFT OUTER JOIN `fb_notifications` 
                                ON `fb_users`.`id_user` = `fb_notifications`.`id_user` 
                               AND `fb_notifications`.`service` = %s", $this->service, "
                             WHERE `fb_notifications`.`value` < %i", $this->last_id, "
                                OR `fb_notifications`.`value` IS NULL")->fetchAll();
    }

    public function update($user_list)
    {
        if (count($user_list)) {
            $update = [];
            foreach ($user_list as $row) {
                $update["id_user%i"][] = $row["id_user"];
                $update["service%s"][] = $this->service;
                $update["value%i"][]   = $this->last_id;
            }
            \dibi::query("INSERT INTO `fb_notifications` %m", $update, "
                    ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)");
        }
    }
}
