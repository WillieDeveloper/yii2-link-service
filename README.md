<p align="center">
    <a href="https://github.com/WillieDeveloper/yii2-link-service.git" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii2 Link Service</h1>
    <br>
</p>

REQUIREMENTS
------------

PHP 7.4 
MySQL 8.0
Git
Composer

INSTALLATION
------------

### Install via Composer

1. Клонирование проекта:

`git clone https://github.com/WillieDeveloper/yii2-link-service.git`

2. Выполните установку необходимых расширений, выполнив команду:

`composer install`

3. Создайте базу данных, а также пользователя и пароль в MySQL, соответственно отредактируйте файл конфигурации db.php

4. Перед накаткой миграций убедитесь, что настройка MySQL log_bin_trust_function_creators установлена в 1 (требуется 
для миграции создания триггера m250605_122552_create_trigger_after_insert_clicks_table):

`set global log_bin_trust_function_creators=1;`

5. Выполните накатку миграций командой:

`php yii migrate`

6. Убедитесь, что у apache включен модуль rewrite, выполнив команду:

`sudo a2enmod rewrite`

Также, проверьте, чтобы в файле конфигурации apache, расположенного по пути 
/etc/apache2/sites-available/000-default.conf, содержался следующий блок внутри блока <VirtualHost *:80>:

`<Directory /var/www/html>
Options Indexes FollowSymLinks MultiViews
AllowOverride All
Order allow,deny
allow from all
</Directory>`

При необходимости, перезапустите apache:

`sudo systemctl restart apache2`

7. Откройте в браузере основную страницу проекта:

http://localhost/yii2-link-service/web/
