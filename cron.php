<?php
/**
 * @author Tomas Opekar <tomas.opekar@golemos.com>
 * @copyright Golemos s.r.o. 02.4.2017
 */
include "vendor/autoload.php";
include "db-connect.php";

$bot = new \pimax\FbBotApp(Settings::TOKEN);

//reddit
$last_reddit = dibi::fetch("SELECT `id_reddit`, `url`, `title` FROM `fb_reddit` 
                                         ORDER BY `id_reddit` DESC 
                                            LIMIT 1");
$reddit      = new \Sing\Notifications("reddit", $last_reddit["id_reddit"]);
$user_list   = $reddit->select();
if (count($user_list)) {
    foreach ($user_list as $row) {
        if ($row["value"] === NULL) {
            //dont send anything, new user
            continue;
        }
        $bot->send(
            new \pimax\Messages\StructuredMessage($row["id_user"],
                \pimax\Messages\StructuredMessage::TYPE_BUTTON, [
                    'text' => "A new patch has been dispatched for the main client. " . $last_reddit["title"],
                    'buttons' => [
                        new \pimax\Messages\MessageButton(\pimax\Messages\MessageButton::TYPE_WEB,
                            "Open on reddit",
                            "https://www.reddit.com" . $last_reddit["url"])
                    ]
                ]
            ));
    }
    $reddit->update($user_list);
}

//sing
$sing_online = new \Sing\Commands\Singonline();
$api         = $sing_online->get_api_request();
$time        = $sing_online->get_stream_start_time($api)->getTimestamp();

$sing      = new \Sing\Notifications("sing_online", $time);
$user_list = $sing->select();
if (count($user_list)) {
    foreach ($user_list as $row) {
        if ($row["value"] === NULL) {
            //dont send anything, new user
            continue;
        }
        echo "sending" . $row["id_user"];
        $bot->send(
            new \pimax\Messages\StructuredMessage($row["id_user"],
                \pimax\Messages\StructuredMessage::TYPE_BUTTON, [
                    'text' => "Sing went live on Twitch",
                    'buttons' => [
                        new \pimax\Messages\MessageButton(\pimax\Messages\MessageButton::TYPE_WEB,
                            "Open Twitch",
                            "https://www.twitch.tv/sing_sing")
                    ]
                ]
            ));
    }
    $sing->update($user_list);
}
