#!/usr/bin/env bash


echo "en_GB.UTF-8 UTF-8" >> /etc/locale.gen

locale-gen

sudo apt-get update
sudo apt-get install -y apache2 php5 phpunit postgresql php5-pgsql php5-curl


sudo su --login -c "psql -c \"CREATE USER test WITH PASSWORD 'testpassword';\"" postgres
sudo su --login -c "psql -c \"CREATE DATABASE test WITH OWNER test ENCODING 'UTF8'  LC_COLLATE='en_GB.UTF-8' LC_CTYPE='en_GB.UTF-8'  TEMPLATE=template0 ;\"" postgres

sudo su --login -c "psql -c \"CREATE USER app WITH PASSWORD 'password';\"" postgres
sudo su --login -c "psql -c \"CREATE DATABASE app WITH OWNER app ENCODING 'UTF8'  LC_COLLATE='en_GB.UTF-8' LC_CTYPE='en_GB.UTF-8'  TEMPLATE=template0 ;\"" postgres


echo "xdebug.max_nesting_level=1000" >> /etc/php5/apache2/conf.d/20-xdebug.ini

mkdir /home/vagrant/bin
cd /home/vagrant/bin
wget -q https://getcomposer.org/composer.phar

cd /vagrant
php /home/vagrant/bin/composer.phar  install

cp /vagrant/vagrant/parameters_test.yml /vagrant/app/config/parameters_test.yml
cp /vagrant/vagrant/parameters.yml /vagrant/app/config/parameters.yml
cp /vagrant/vagrant/apache.conf /etc/apache2/sites-enabled/000-default.conf
cp /vagrant/vagrant/app_dev.php /vagrant/web/app_dev.php

mkdir /vagrant/app/cache/dev/
mkdir /vagrant/app/cache/prod/

touch /vagrant/app/logs/prod.log
touch /vagrant/app/logs/dev.log
chown -R www-data:www-data /vagrant/app/logs/prod.log
chown -R www-data:www-data /vagrant/app/logs/dev.log

rm -r /vagrant/app/cache/prod/*
rm -r /vagrant/app/cache/dev/*

a2enmod rewrite
/etc/init.d/apache2 restart

php app/console doctrine:migrations:migrate --no-interaction

chown -R www-data:www-data /vagrant/app/cache/prod/
chown -R www-data:www-data /vagrant/app/cache/dev/

