#!/bin/sh
if [ "$TESTING_FRAMEWORK" = "PHPUnit" ]; then
  phpunit --coverage-text
elif [ "$TESTING_FRAMEWORK" = "Behat" ]; then
  if [ ! -f behat.phar ]; then
    wget https://github.com/downloads/Behat/Behat/behat.phar
  fi
  php behat.phar
fi

exit $?
