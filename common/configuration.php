<?php

/*
    configuration.php

    (c) Dean Elwood 2019

    Generally speaking we seek to divide log file entries into 2 types that we might want to be
    alerted to - WARNings and ERRORs

    WARNings we consider something that we need to draw attention to, but are non-critical. We
    might wish to see a number of them before we bother a human, eg, at night-time.

    ERRORs we consider to be unrecoverable and a real problem, so you might need to wake up and
    fix this.

    As at current version we don't do much more than post ERRORs into Slack and WARNings into
    Slack when they exceed a certain threshold in a particular time window.

*/

define("_SERVER", php_uname("n"));

/*
    Load up our config from chops.conf
*/


$config = parse_ini_file("chops.conf");

define("_SLACK_WEB_HOOK_URL",    $config[slackurl]);
define("_LOG_FILE_TAIL",         $config[logfile]);
define("_WARN_PATTERN",          $config[warnpattern]);
define("_ERROR_PATTERN",         $config[errorpattern]);
define("_WARNINGS_BEFORE_ALARM", $config[warningsbeforealarm]);
define("_WARNINGS_WINDOW",       $config[warningswindow]);

define("_MESSAGES_PER_SECOND", 2);

define("_WARN_MESSAGE",   0);
define("_ERROR_MESSAGE",  1);
define("_SYSTEM_MESSAGE", 2);

?>
