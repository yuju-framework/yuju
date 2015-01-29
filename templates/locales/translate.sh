#!/bin/sh

API=$1
PROJECT=$2

php -q php.php $API > gtAPI.php
php -q php.php $PROJECT > gtPROJECT.php

if [ -f "messages.pot" ]
then
    touch messages.pot
fi

find $API -iname "*.php" | xargs xgettext --from-code=utf-8 --language=PHP -o messages.pot
find $PROJECT -iname "*.php" | xargs xgettext --from-code=utf-8 --language=PHP -o messages.pot -j

rm gtAPI.php
rm gtPROJECT.php

echo "File messages.po created successfully!"