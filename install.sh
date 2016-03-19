cp * /var/www/html/ -R
cd /var/www/html/judge
g++ -o compile compile.cpp
g++ -o judge_main judge_main.cpp syscall_checker.cpp
chmod 777 -R /var/www/html
cd ..
cd judgeserver
sudo nohup php server.php start
cd ..
cd judge
sudo nohup php client.php
mysql -u root -p<<EOF
CREATE DATABASE oj;
USE oj;
source db.sql;
EOF


