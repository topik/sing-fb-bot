<?php
/**
 * @author Tomas Opekar <tomas.opekar@golemos.com>
 * @copyright Golemos s.r.o. 02.4.2017
 */


namespace Sing;


class Webhook
{
    private $token;
    private $verify_token;
    private $request;
    /**
     * @var \pimax\FbBotApp
     */
    public $bot;
    private $message;
    private $command;

    function __construct($token, $verify_token, $request)
    {
        $this->token        = $token;
        $this->verify_token = $verify_token;
        $this->request      = $request;
        $this->bot          = new \pimax\FbBotApp($this->token);
        $this->run();
    }

    private function run()
    {
        if ($this->is_verify_request()) {
            echo $this->request['hub_challenge'];
            die;
        }
        $this->parse_data_from_php_input();

        $this->save_command();
        if ($_REQUEST["test"]) {
            $this->command = $_REQUEST["test"];
        }
        http_response_code(200);
        $this->command_switch();
    }

    private function command_switch()
    {
        $command = ucfirst(strtolower($this->command));
        $command = preg_replace('/\s+/', '', $command);
        $method  = 'Sing\\Commands\\' . $command;
        if (!class_exists($method)) {
            $this->send_error_message();
            return;
        }
        $function          = new $method;
        $function->bot     = $this->bot;
        $function->message = $this->message;
        $function->run();

    }

    private function send_error_message()
    {
        $error          = new \Sing\Commands\Error_command();
        $error->bot     = $this->bot;
        $error->message = $this->message;
        $error->run();
    }

    private function save_command()
    {
        // When bot receive message from user
        if (!empty($this->message['message'])) {
            $this->command = $this->message['message']['text'];
        } // When bot receive button click from user
        elseif (!empty($this->message['postback'])) {
            $this->command = $this->message['postback']['payload'];
        }
    }

    /**
     * Verify request from facebook
     *
     * @return bool
     */
    private function is_verify_request()
    {
        return (!empty($this->request['hub_mode']) &&
                $this->request['hub_mode'] == 'subscribe' &&
                $this->request['hub_verify_token'] == $this->verify_token);
    }

    private function parse_data_from_php_input()
    {
        $data = json_decode(file_get_contents("php://input"), TRUE, 512, JSON_BIGINT_AS_STRING);
        $vals = ["log%s" => print_r($data, TRUE)];
        \dibi::query("INSERT INTO fb_log", $vals);
        if (!empty($data['entry'][0]['messaging'])) {
            foreach ($data['entry'][0]['messaging'] as $message) {
                $this->message = $message;
            }
        }
    }
}
