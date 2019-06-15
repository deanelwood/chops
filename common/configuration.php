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

    But we expect this to evolve....
*/

define("_SERVER", php_uname("n"));

/*
    Your Slack web hook URL. To set this up you first need to create a Slack chatbot application, then
    add the webhook for it in this define.

    To create Slack web hooks, see : https://api.slack.com/incoming-webhooks#create_a_webhook
*/

define("_SLACK_WEB_HOOK_URL",    "");



/*
    Define here the logfile that you wish to monitor and have CHOPS sent alerts into the Channel for.
*/

define("_LOG_FILE_TAIL",         "/var/log/test.log");



/*
    WARN ing REGEX pattern
*/
define("_WARN_PATTERN", "/WARN/");





/*
    ERROR ing REGEX pattern
*/
define("_ERROR_PATTERN", "/ERROR/");




/*
    How many WARN messages before we POST a message into Slack.
    Generally, when you're monitoring an application WARN-ings will occur. You probably don't want to
    be woken up unless there's a few of them...
*/

define("_WARNINGS_BEFORE_ALARM", 3);



/*
    This is the window of time that works in conjunction with _WARNINGS_BEFORE_ALARM
    If it is non-zero, then _WARNINGS_BEFORE_ALARM must occur within this many minutes.

    EG : you can use this to say "send a message to my Slack channel if you see 3 WARN-ings in the
    space of 5 minutes.

    To do that you would set _WARNINGS_BEFORE_ALARM to 3, and _WARNINGS_WINDOW to 5
*/

define("_WARNINGS_WINDOW",       5); // Number of minutes window for warnings



/*
    We are allowed to send this many messages per second into a Slack Channel
*/

define("_MESSAGES_PER_SECOND", 2);

?>
