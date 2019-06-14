<?php

/*
    CHOPS monitoring tool....

    (c) Dean Elwood 2019

    Tail a log and push ERRORS and cummulative WARNings into Slack channel
    Ignore DEBUG

*/

/*
    Config for your WebHook
*/
$webHookURL = "https://hooks.slack.com/services/*****************************";
$logFile    = "/var/log/********************";

/*
    Config for WARNing messages in logfiles
    In this current configuration, 3 WARNings in the space of 5 minutes will send an alarm
*/
$warningsBeforeAlarm = 3; // How many warnings in the window before we trigger an alarm
$warningsWindow      = 5; // Number of minutes window for warnings
$firstWarning        = 0;
$warningCounter      = 0;

$server = php_uname("n");

$handle = popen("tail -f -n 0 $logFile 2>&1", 'r');

while(!feof($handle)){
    $line = fgets($handle);
    
    // Lose any newlines before we POST to Slack....
    $line = preg_replace('/\n$/','',$line);

    if (strpos($line, 'DEBUG') !== false) {
        $line = "";
    }

    /*
        If it's a warning, see if we have exceeded our threshold
    */
    $timeNow = time();
    if (strpos($line, 'WARN') !== false) {
        // Probably a warning...

        if ($warningCounter == 0) {
            // First one, start the stopwatch...
            $firstWarning = time();
        }

        // Increment our counter
        $warningCounter++;

        if ($warningCounter < $warningsBeforeAlarm) {
            // eat it - no need to bother anyone
            $line = "";
        } else {
            if (time() < ($firstWarning + ($warningsWindow * 60))) {
                // We've had warningsBeforeAlarm number of warnings within warningsWindow, tell the team.
                // Nothing to do, $line will not be blank and message will be sent...
            } else {
                // Time exceeded, reset by treating this as if it were the first warning
                $firstWarning = time();
                $warningCounter = 1;
                $line = "";
            }
        }
    }

    if ($line != "") {
        $opts = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            ),

            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type: application/json',
                'content' => '{"text":"['.$server.'] '.$line.'"}'
            )
        );

        $context = stream_context_create($opts);

        $response = file_get_contents($webHookURL, false, $context);
    }

    flush();
    usleep(500000); // 0.5 second.... (so max 2 message per second to Slack)
}

pclose($handle);

?>
