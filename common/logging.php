<?php

/*
    logging.php

    (c) Dean Elwood 2019

    Simple logging function to syslog...
*/

define("_DEBUG", LOG_DEBUG);
define("_INFO",  LOG_INFO);
define("_WARN",  LOG_WARNING);
define("_ERROR", LOG_ERR);
define("_FATAL", LOG_EMERG);

$textLevels              = array();
$textLevels[LOG_DEBUG]   = "[DEBUG]";
$textLevels[LOG_INFO]    = "[INFO]";
$textLevels[LOG_WARNING] = "[WARNING]";
$textLevels[LOG_ERR]     = "[ERROR]";
$textLevels[LOG_EMERG]   = "[CRITICAL]";

function logThis($message, $logLevel = _ERROR) {
    $server = "["._SERVER."]";
    postToSlackChannel("CHOPS", $server." ".$textLevels[$logLevel]." ".$message, _SLACK_WEB_HOOK_URL);
    return syslog($logLevel, "[CHOPS] $message");
}

?>
