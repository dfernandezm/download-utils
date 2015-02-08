#!/bin/sh

cd %SYMFONY_APP_ROOT%
php app/console %COMMAND_NAME% -e prod --no-debug



