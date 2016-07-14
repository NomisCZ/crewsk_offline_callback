<?php
/**
 * @author NomisCZ <nomiscz@outlook.com>
 * @version 1.1
**/

/*
 * INCLUDE FILES
 */
require_once('includes/config.php');
require_once('includes/core.class.php');
require_once('includes/crew.class.php');
require_once('includes/rcon.class.php');

$hydra = new hydra();

$parameters = array(
    'action',
    'method',
    'price',
    'currency',
    'days',
    'variables',
    'key',
    'code'
);

$commands = array();

if (REMOTE_ADDR === $config['crewIP']) {

    foreach ($parameters as $parameter) {

        if (isset($_GET[$parameter]))
            $parameters[$parameter] = $_GET[$parameter];
        else
            exit(core::status_msg('error','missing_parameter: '.$parameter));
    }

    if ($parameters['key'] === $config['apiKey']) {

        if ($parameters['action'] === 'activate' OR $parameters['action'] === 'deactivate' ) {

            if ($parameters['action'] === 'activate') {
                switch($parameters['code']){
                    case 'startVIP':
                        $commands[] = "pex group vip user add :nick";
                        $commands[] = "say Hrac :nick si koupil startVIP. Dekujeme.";
                        break;
                    case 'silverVIP':
                        $commands[] = "pex group vip user add :nick";
                        $commands[] = "say Hrac :nick si koupil silverVIP. Dekujeme.";
                        break;
                    default:
                        exit(core::status_msg('error','unknown_code'));
                }
            }

            if ($parameters['action'] === 'deactivate') {
                switch($parameters['code']){
                    case 'startVIP':
                        $commands[] = "pex group vip user add :nick";
                        $commands[] = "say Hrac :nick si koupil startVIP. Dekujeme.";
                        break;
                    case 'silverVIP':
                        $commands[] = "pex group vip user add :nick";
                        $commands[] = "say Hrac :nick si koupil silverVIP. Dekujeme.";
                        break;
                    default:
                        exit(core::status_msg('error','unknown_code'));
                }
            }


            if (count($commands)) {
                if ($config['webConsole']) {
                    if ($hydra->testConn($config['serverID'], $config['serverPassv'])) {
                        foreach($commands as $command) {
                            $command = hydra::command($command, $parameters['variables']);
                            $sendCMD = $hydra->sendCmd($config['serverID'], $command, $config['serverPass']);
                            if ($sendCMD['success'] == "true")
                                echo core::status_msg('success','web_console_cmd');
                            else
                                echo core::status_msg('error','failed_to_sent: '.$command);
                        }
                    } else
                        exit(core::status_msg('error','web_console_failed_to_connect'));
                } else {
                    $r = new rcon($config['serverIP'],$config['serverPort'],$config['serverPass']);
                    if($r->Auth()) {
                        foreach($commands as $command) {
                            $command = hydra::command($command, $parameters['variables']);
                            $r->rconCommand($command);
                            echo core::status_msg('success','rcon_cmd_sent: '.$command);
                        } 
                    } else
                        exit(core::status_msg('error','rcon_failed_to_connect'));
                 }
            } else
                exit(core::status_msg('warning','no_cmds'));

        } else
            exit(core::status_msg('error','wrong_action'));

    } else
        exit(core::status_msg('error','wrong_api_key'));

} else
    exit(core::status_msg('error','ip_not_allowed'));
