#!/bin/bash
cwd=`pwd`
if (( $# > 0 )); then
    cmd="/usr/bin/php -S 0.0.0.0:"$1" -c /etc/php.ini.default -t "$cwd" router.php"
    $cmd > $cwd/logs 2>&1 &
    echo 'started'
else
    echo 'port required';
fi