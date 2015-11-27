#!/bin/bash

## run all the message sending  ########################################
if ps ax | grep -v grep | grep "MessageSender.php" > /dev/null; then
echo -n "MessageSender is Already Running....... :: "
date
echo -n " "
else
/usr/bin/php /var/www/html/web/cronjobs/MessageSender.php >> /tmp/message.log
fi

## clean the assets ########################################
if ps ax | grep -v grep | grep "AssetCleaner.php" > /dev/null; then
echo -n "AssetCleaner is Already Running....... :: "
date
echo -n " "
else
/usr/bin/php /var/www/html/web/cronjobs/AssetCleaner.php >> /tmp/Asset_cleaner.log
fi