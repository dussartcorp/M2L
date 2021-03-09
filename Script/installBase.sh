sudo -i
apt-get update && apt-get –yes –force-yes –fix-missing –auto-remove
apt-get upgrade
apt-get install apache2
apt -y install lsb-release apt-transport-https ca-certificates 
wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | sudo tee /etc/apt/sources.list.d/php.list
apt update
apt -y install php7.4
apt install libapache2-mod-php7.4
a2dismod php7.3
a2enmod php7.4
service apache2 restart
apt purge php7.3 libapache2-mod-php7.3
apt-cache policy php7.4
apt -y install composer
adduser developpeur