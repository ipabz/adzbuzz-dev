#!/usr/bin/env bash

echo "export LANG=en_PH" >> ~/.bashrc
echo "export LANG=en_PH" >> /home/vagrant/.bashrc

# Use our own httpd.conf setup
sudo rm -f /etc/httpd/conf/httpd.conf
sudo cat /vagrant/stubs/httpd.conf.stub > /etc/httpd/conf/httpd.conf

# Use our own setup of php.ini
sudo rm -f /etc/php.ini
sudo cat /vagrant/stubs/php.ini.stub > /etc/php.ini

# Create sites container
sudo rm -rf /etc/httpd/sites-available
sudo rm -rf /etc/httpd/sites-enabled
sudo mkdir /etc/httpd/sites-available
sudo mkdir /etc/httpd/sites-enabled

# Set mysql config
sudo rm -f /etc/my.cnf
sudo cp /vagrant/stubs/my.cnf /etc/my.cnf
sudo service mysqld restart


# Initialize settings
sudo php /vagrant/adzbuzz_init

# Start httpd
sudo service httpd start