<?php

/*
    CHOPS monitoring tool....

    (c) Dean Elwood 2019

    Tail a log and push ERRORS and cummulative WARNings into Slack channel
*/

include_once("common/configuration.php");
include_once("common/logging.php");
include_once("common/slack.php");

$firstWarning        = 0;
$warningCounter      = 0;

$handle = popen("tail -f -n 0 "._LOG_FILE_TAIL." 2>&1", 'r');

$warning = false;
$error   = false;

logThis("I am now monitoring : `"._LOG_FILE_TAIL."` for patterns ".str_replace("/", "`", _WARN_PATTERN)." and ".str_replace("/", "`", _ERROR_PATTERN), _INFO);

while(!feof($handle)) {
    $line    = fgets($handle);

    $warning = preg_match(_WARN_PATTERN,  $line);
    $error   = preg_match(_ERROR_PATTERN, $line);

    // If don't have a match, move on...
    if (!$warning && !$error) {
        continue;
    }

    // Lose any newlines before we POST to Slack....
    $line = preg_replace('/\n$/', '', $line);

    /*
        If it's a warning, see if we have exceeded our threshold
    */
    $timeNow = time();

    if ($warning) {
        // Probably a warning...

        if ($warningCounter == 0) {
            // First one, start the stopwatch...
            $firstWarning = time();
        }

        // Increment our counter
        $warningCounter++;

        if ($warningCounter < _WARNINGS_BEFORE_ALARM) {
            // eat it - no need to bother anyone
            $line = "";
        } else {
            if (time() < ($firstWarning + (_WARNINGS_WINDOW * 60))) {
                // We've had warningsBeforeAlarm number of warnings within warningsWindow, tell the team.
                // Nothing to do, $line will not be blank and message will be sent...
            } else {
                // Time exceeded, reset by treating this as if it were the first warning
                $firstWarning   = time();
                $warningCounter = 1;
                //$line           = "";
                continue;
            }
        }
    }

    if (!postToSlackChannel(_SERVER, $line, _SLACK_WEB_HOOK_URL)) {
        logThis("Failed to post message into Slack channel : $line", _ERROR);
    }

    flush();

    usleep(1000000/_MESSAGES_PER_SECOND);
}

pclose($handle);

?>
