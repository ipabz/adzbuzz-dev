#!/usr/bin/env bash

# Use our own httpd.conf setup
sudo rm -f /etc/httpd/conf/httpd.conf
sudo cat /vagrant/stubs/httpd.conf.stub > /etc/httpd/conf/httpd.conf

# Use our own setup of php.ini
sudo rm -f /etc/php.ini
sudo cat /vagrant/stubs/php.ini.stub > /etc/php.ini

sudo rm -rf /etc/httpd/sites-available
sudo rm -rf /etc/httpd/sites-enabled
sudo mkdir /etc/httpd/sites-available
sudo mkdir /etc/httpd/sites-enabled

sudo php /vagrant/adzbuzz_init

# Start httpd
sudo service httpd start