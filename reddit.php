<?php
/**
 * @author Tomas Opekar <tomas.opekar@golemos.com>
 * @copyright Golemos s.r.o. 02.4.2017
 */

include "vendor/autoload.php";
include "db-connect.php";

$last_reddit = dibi::fetch("SELECT * FROM `fb_reddit` ORDER BY `id_reddit` DESC LIMIT 1");

$m = \Atrox\Matcher::multi('//div[@id="siteTable"]/div[contains(@class, "thing")]', [
    'id' => '@data-fullname',
    'title' => './/p[@class="title"]/a',
    'url' => './/p[@class="title"]/a/@href',
    'date' => './/time/@datetime',
    'img' => 'a[contains(@class, "thumbnail")]/img/@src',
])->fromHtml();

$f = file_get_contents('https://www.reddit.com/user/SirBelvedere/');

$extractedData = $m($f);
foreach ($extractedData as $entry) {
    if ($entry["title"] === NULL) {
        continue;
    }
    if ($last_reddit["date"] == $entry["date"]) {
        break;
    }
    $vals = [
        "title%s" => $entry["title"],
        "url%s" => $entry["url"],
        "date%s" => $entry["date"]
    ];
    dibi::query("INSERT INTO `fb_reddit`", $vals);
    break;
}
