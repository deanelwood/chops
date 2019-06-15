<?php

/*
    slack.php

    (c) Dean Elwood 2019

    Post a message to a Slack channel
*/


function postToSlackChannel($sender, $message, $webHook, $type=_SYSTEM_MESSAGE) {
    if ($message == "") return;

    switch ($type) {
        case _SYSTEM_MESSAGE :
            $prefix = "[$sender]";
            break;

        case _WARN_MESSAGE :
            $prefix = "[$sender] WARNing message threshold exceeded:\n";
            break;

        case _ERROR_MESSAGE :
            $prefix = "[$sender] ERROR message triggered:\n";
            break;

        default:
            $prefix = "[$sender]";

    }

    $opts = array(
        'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        ),

        'http' => array(
            'method' => 'POST',
            'header' => 'Content-type: application/json',
            'content' => '{"text":"'.$prefix.' `'.$message.'`"}'
        )
    );

    $context = stream_context_create($opts);

    $response = file_get_contents($webHook, false, $context);

    return ($response !== false);
}

?>
