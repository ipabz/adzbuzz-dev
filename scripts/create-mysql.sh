#!/usr/bin/env bash

sudo cat > /root/.my.cnf << EOF
[client]
user = root
password = 00:secreT,@
host = localhost
EOF

cp /root/.my.cnf /home/vagrant/.my.cnf

DB=$1;

mysql -e "CREATE DATABASE IF NOT EXISTS \`$DB\` DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_unicode_ci";
