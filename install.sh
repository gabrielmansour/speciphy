if [ ! -f composer.phar ]; then
  wget http://getcomposer.org/composer.phar -O composer.phar
  chmod +x composer.phar
fi
php composer.phar install
