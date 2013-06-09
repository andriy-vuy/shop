README
======
IF DB shop.sql then site user: admin, password : 1, shop.data.sql - better

This directory should be used to place project specfic documentation including
but not limited to project notes, generated API/phpdoc documentation, or
manual files generated or hand written.  Ideally, this directory would remain
in your development environment only and should not be deployed with your
application to it's final production location.


Setting Up Your 
VHOST
====================================================


The following is a sample VHOST you might want to consider for your project.

<VirtualHost *:80>
   DocumentRoot "C:/server/htdocs/shop/public"
   ServerName .local

   # This should be omitted in the production environment
   SetEnv APPLICATION_ENV development

   <Directory "C:/server/htdocs/shop/public">
       Options Indexes MultiViews FollowSymLinks
       AllowOverride All
       Order allow,deny
       Allow from all
   </Directory>

</VirtualHost>


Настройки email===========================================




В /application/Bootstrap.php  информация SMTP 
В /library/Custom/mail.php адрес отправителя 
В /application/controllers/UserController.php
public function infoAction() адрес получателя сообщений
 из формы обратной связи.

Имя сайта можно изменить==================================

В /application/Bootstrap.php,
/application/controllers/IndexController.php
Ссылки надо изменить в файлах отправки почты==============
/application/views/scripts/mail/activation.phtml
/application/views/scripts/mail/order.phtml




