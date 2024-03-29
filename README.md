# chops
DevOps chatbot tool for posting log file entries into Slack channels.

This is a PHP CLI based daemon that can tail a log file, look for REGEX patterns (like "WARN" or "ERROR") and post them into a Slack Channel when they occur.

I find myself more and more interacting with my team and with customers and partners on Slack Channels, and this often includes DevOps. I needed a way that I could push log file entries into a channel so that WARN and ERROR messages could be easily discussed across a group.

The longer term vision for this project is for a more interactive chatbot that can perform some basic command and control tasks. This initial version is just a case of "tail a file, catch REGEX patterns and drop matches into a channel".

## Dependencies

To install it, you'll need to satisfy the following dependencies:

* [PHP CLI](https://www.php.net/manual/en/features.commandline.php)
* [tail](https://en.wikipedia.org/wiki/Tail_(Unix))

PHP CLI is usually available on most common distributions. Installing this on a recent Fedora, for example, is very simple:

    yum install php-cli

On Ubuntu or Debian, it would require something like this:

    apt-get install php-cli

I've not yet come across a Linux distribution that does not have tail installed.

## Installation

Once you have installed the dependencies, get the code:

	git clone https://github.com/deanelwood/chops.git /usr/local/chops
	cd /usr/local/chops
  
## Create your Slack app and get a Web Hook URL

You will need a Web Hook URL to the Slack channel that you wish to post log messages into. I recommend that you start here:

* [Slack Incoming WebHooks] (https://api.slack.com/incoming-webhooks#getting-started)

Once you have created your app and Slack has given you a URL to use for the webhook you can configure CHOPS.

## Configuration

You will need to edit some values in /usr/local/chops/chops.conf, at least these:

	slackurl=
	logfile=
	warnpattern=
	errorpattern=

An example configuration that monitors the file /var/log/myapp.log might look like this:

	slackurl=https://hooks.slack.com/services/<uuid>/
	logfile=/var/log/myapp.log
	warnpattern=/WARN/
	errorpattern=/ERR/

With this example configuration, any lines in /var/log/myapp.log that are spotted containing the text "ERR" will be sent immediately to your Slack channel. Any lines that contain the text "WARN" will be counted and if more than 3 are seen in a space of 5 minutes a message will be posted into the Slack channel. You can change these presets by altering the values 3 and 5 for _warningsbeforealarm_ and _warningswindow_ accordingly in the configuration file.

## Launching

If you installed using the above path of /usr/local/ you can launch with php /user/local/chops.php &

When launched, CHOPS will post a message into your Slack channel like this:-

![CHOPS launch message](https://user-images.githubusercontent.com/942112/59548665-78e2eb80-8f4a-11e9-917d-7397b338b044.png)

## Contributing

You can contribute to the project by [forking](https://help.github.com/articles/fork-a-repo) and submitting a pull request. (If you are new to GitHub, you might start with a [basic tutorial](https://help.github.com/articles/set-up-git).)

All contributors retain the original copyright to their code, but by contributing to this project, grant a world-wide, royalty-free, perpetual, irrevocable, non-exclusive, transferable license to all users under the terms of the [MIT License](http://opensource.org/licenses/mit-license.php).

## License

This project constitutes an original work.

You may use this project under the [MIT License](http://opensource.org/licenses/mit-license.php).
