<?php
/**
 * @author Tomas Opekar <tomas.opekar@golemos.com>
 * @copyright Golemos s.r.o. 02.4.2017
 */
include "vendor/autoload.php";
include "db-connect.php";

$request = filter_var_array($_REQUEST);
$webhook = new \Sing\Webhook(Settings::TOKEN, Settings::VERIFY_TOKEN, $request);
