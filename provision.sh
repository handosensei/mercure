echo "deb http://packages.dotdeb.org wheezy-php56 all" >> /etc/apt/sources.list.d/dotdeb.list
echo "deb-src http://packages.dotdeb.org wheezy-php56 all" >> /etc/apt/sources.list.d/dotdeb.list

wget http://www.dotdeb.org/dotdeb.gpg -O- |apt-key add –

apt-get update -y -f --force-yes
apt-get upgrade -y -f --force-yes
apt-get install -y -f --force-yes vim wget curl

debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'

apt-get install -y -f --force-yes php5 php5-dev apache2-mpm-prefork mysql-server mysql-client php5-cli php5-common php5-curl php5-intl php5-mcrypt php5-mysql

a2enmod php5 rewrite
sed -i 's/export APACHE_RUN_USER=www-data/export APACHE_RUN_USER=vagrant/g' /etc/apache2/envvars
sed -i 's/export APACHE_RUN_GROUP=www-data/export APACHE_RUN_GROUP=vagrant/g' /etc/apache2/envvars
sed -i 's#;date.timezone =#date.timezone = Europe/Paris#g' /etc/php5/apache2/php.ini
sed -i 's#;date.timezone =#date.timezone = Europe/Paris#g' /etc/php5/cli/php.ini
sed -i 's#DocumentRoot /var/www$#DocumentRoot /var/www/web#g' /etc/apache2/sites-available/default
sed -i 's#<Directory /var/www/>#<Directory /var/www/web>#g' /etc/apache2/sites-available/default
sed -i 's#Options Indexes FollowSymLinks MultiViews#Options -Indexes FollowSymLinks MultiViews#g' /etc/apache2/sites-available/default
sed -i 's#AllowOverride None#AllowOverride All#g' /etc/apache2/sites-available/default

chown -R vagrant:vagrant /var/lock/apache2/
echo "cd /var/www/" >> /home/vagrant/.bashrc
echo "alias ll='ls -l'" >> /home/vagrant/.profile

/etc/init.d/apache2 restart
/etc/init.d/mysql restart