# chops
DevOps chatbot tool for posting log file entries into Slack channels.

This is a PHP CLI based daemon that can tail a log file, look for REGEX patterns (like "WARN" or "ERROR") and post them into a Slack Channel when they occur.

I find myself more and more interacting with my team and with customers and partners on Slack Channels, and this often includes DevOps. I needed a way that I could push log file entries into a channel so that WARN and ERROR messages could be easily discussed across a group.

The longer term vision for this project is for a more interactive chatbot that can perform some basic command and control tasks. This initial version is just a case of "tail a file, catch REGEX patterns and drop matches into a channel".

# installation

