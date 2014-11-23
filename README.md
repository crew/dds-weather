DDS Weather Slide
===========

A Modern-Looking Weather Slide for DDS

*"Because anything is better than desktops showing The Weather Channel's mobile layout"*


Dependencies:

- Web Server (e.g. Apache)

- PHP

Usage:

3 Easy Steps:

1. Clone Repo (you probably want to do this into an http-accessible folder)

2. Create a `config.php` file and set `$GLOBALS['API-KEY']` to your WeatherUnderground API key. 
Feel free to ask Philip for his for you to use.

3. Recieve Weather

Copyright Northeastern University CCIS Crew 2014

For licensing, see [dds-client](https://github.com/crew/dds-client).

###TROUBLESHOOTING

> The weather page has the wrong dates!

Assuming you've already double-checked that your API key is in the right spot, check the top of the page for any whitespace. If there is any, try highlighting it to see if there is any text up there. If you see something about "Permission Denied" and "json<something>Response.txt", the issue can probably be fixed by doing the following:

1. Open a terminal and type `ps -axu | grep apache` (or whatever server you're running). At the far left, you should see things like `root` and your username. You should also see something like `www-data`. Whatever it is, put it where `www-data` is below.

2. Run the following: `sudo chown -R www-data /path/to/dds-weather`

3. Refresh the page and see if the problem persists. If it does, file a ticket.
