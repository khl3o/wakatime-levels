# What it is ?

Use the Wakatime API to create a "RPG like" badge of your coding activity

![2021](README/img/badge-2021.png "2021")

# Install

- Create a config.php from config.php.sample
- Configure a web server and call badge.php to get the badge

# Get a badge as a png

You can use Phantomjs (https://phantomjs.org/quick-start.html) to create a png from the web server.

Create a script called phantom.js

    var page = require('webpage').create();
    var date = new Date();
    page.open('http://wakatime.local/badge.php', function() {
      page.render('badge.png');
      phantom.exit();
    });

and call `phantomjs phantom.js` in cli

