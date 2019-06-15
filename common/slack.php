<?php

/*
    slack.php

    (c) Dean Elwood 2019

    Post a message to a Slack channel
*/


function postToSlackChannel($sender, $message, $webHook) {
    if ($message == "") return;

    $opts = array(
        'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        ),

        'http' => array(
            'method' => 'POST',
            'header' => 'Content-type: application/json',
            'content' => '{"text":"['.$sender.'] '.$message.'"}'
        )
    );

    $context = stream_context_create($opts);

    $response = file_get_contents($webHook, false, $context);

    return ($response !== false);
}

?>
