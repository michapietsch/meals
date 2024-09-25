#!/bin/bash

if grep -x -q "zend_extension=xdebug" ./php/xdebug.ini; then
    sed 's/zend_extension=xdebug/;zend_extension=xdebug/g' ./php/xdebug.ini > ./php/xdebug.ini.tmp && mv ./php/xdebug.ini.tmp ./php/xdebug.ini
    echo "Xdebug has been disabled."
else
    sed 's/;zend_extension=xdebug/zend_extension=xdebug/g' ./php/xdebug.ini > ./php/xdebug.ini.tmp && mv ./php/xdebug.ini.tmp ./php/xdebug.ini
    echo "Xdebug has been enabled."
fi

docker-compose restart php

echo "PHP container has been restarted."
