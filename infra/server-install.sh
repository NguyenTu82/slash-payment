#!/bin/bash

# Install codedeploy agent
sudo yum update -y
sudo yum install ruby -y
sudo yum install wget -y
cd /home/ec2-user
# Resource kit bucket names by Region
# https://docs.aws.amazon.com/codedeploy/latest/userguide/resource-kit.html#resource-kit-bucket-names

sudo wget https://aws-codedeploy-ap-southeast-1.s3.amazonaws.com/latest/install
sudo chmod +x ./install
sudo ./install auto
sudo service codedeploy-agent start
sudo service codedeploy-agent status

# Install nginx and php8.1
sudo amazon-linux-extras install nginx1 -y
sudo amazon-linux-extras install epel -y
sudo yum install http://rpms.remirepo.net/enterprise/remi-release-7.rpm -y
sudo yum remove php-common -y
sudo yum install php81 -y
sudo yum install  php81-php-bcmath -y
sudo yum install  php81-php-redis -y
sudo yum install  php81-php-pdo -y
sudo yum install  php81-php-cli -y
sudo yum install  php81-php-xml -y
sudo yum install  php81-php-json -y
sudo yum install  php81-php-mbstring -y
sudo yum install  php81-php-process -y
sudo yum install  php81-php-zip -y
sudo yum install  php81-php-fpm -y
sudo yum install  php81-php-mysqlnd -y
sudo alternatives --install /usr/bin/php php /usr/bin/php81 1

# Install composer
sudo php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
sudo php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
sudo php composer-setup.php
sudo php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/local/bin/composer

sudo sed -i -e "s/^user = apache/user = nginx/g" /etc/opt/remi/php81/php-fpm.d/www.conf
sudo sed -i -e "s/^group = apache/group = nginx/g" /etc/opt/remi/php81/php-fpm.d/www.conf
sudo sed -i -e "s/^;listen.owner = nobody/listen.owner = nginx/g" /etc/opt/remi/php81/php-fpm.d/www.conf
sudo sed -i -e "s/^;listen.group = nobody/listen.group = nginx/g" /etc/opt/remi/php81/php-fpm.d/www.conf
sudo sed -i -e "s/^;listen.mode = 0660/listen.mode = 0660/g" /etc/opt/remi/php81/php-fpm.d/www.conf
sudo sed -i -e "s/^listen.acl_users = apache/;listen.acl_users = nginx/g" /etc/opt/remi/php81/php-fpm.d/www.conf
pattern='listen = 127.0.0.1:9000'
replacement='listen = /var/opt/remi/php81/run/php-fpm/www.sock'
sudo sed -i -e "s|$pattern|$replacement|g" /etc/opt/remi/php81/php-fpm.d/www.conf

# Todo must edit server_name
echo '
server {
    listen 80;
    listen [::]:80;
    server_name 10.0.4.4;
    root /srv/slash_payment/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/opt/remi/php81/run/php-fpm/www.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}' | sudo tee /etc/nginx/conf.d/default.conf

sudo apachectl stop
sudo systemctl start nginx.service php81-php-fpm.service
#auto start
sudo systemctl enable nginx.service php81-php-fpm.service

# Install cloudwatch agent
sudo yum install amazon-cloudwatch-agent -y

# Install supervisor on AWS EC2 with Laravel
sudo amazon-linux-extras install epel -y
sudo yum install -y supervisor
pattern='files = supervisord.d/\*.ini'
replacement='files = supervisord.d/\*.conf'
sudo sed -i -e "s|$pattern|$replacement|g" /etc/supervisord.conf
# Todo must edit /srv/slash_payment to your project folder
echo '
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /srv/slash_payment/artisan queue:work --queue=emails,default --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=ec2-user
numprocs=8
redirect_stderr=true
stdout_logfile=/srv/slash_payment/storage/worker.log
stopwaitsecs=3600
' | sudo tee /etc/supervisord.d/supervisor.conf
kill $(ps -ef | grep supervisord | awk '{print $2}')
sudo supervisord -c /etc/supervisord.conf
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl status
#auto restart
sudo cp -f ./supervisord /etc/init.d/supervisord
sudo chmod +x /etc/init.d/supervisord
sudo update-rc.d supervisord defaults
sudo chkconfig --add supervisord
sudo service supervisord start
echo ""
sudo supervisorctl status
echo ""
sudo systemctl status nginx.service
echo ""
sudo systemctl status php81-php-fpm.service
