<?php
# microText ver 0.6
# http://microText.info

# Общие настройки
$config							= array();
$config['sitelink']				= 'http://easysite/'; # URL сайта, со слэшем на конце
$config['sitename']				= 'microText'; # Заголовок сайта
$config['slogan']				= 'Идеальный движок для сайтов-визиток'; # Слоган
$config['encoding']				= 'utf-8'; # Кодировка

$config['template']				= 'page'; # Шаблон

# Настройки доступа
$config['login']				= 'demo'; # Логин админа
$config['password']				= 'demo'; # Пароль админа

# Настройки доступа в закрытую зону
$config['accesslogin']			= 'demo'; # Логин
$config['accesspassword']		= 'demo'; # Пароль

### ОТПРАВКА СООБЩЕНИЙ ###
$config['emailadmin']			= 'revadimov@gmail.com'; # E-mail адрес, на который отправляется сообщение
$config['emailsubject']			= 'Письмо с сайта'; # E-mail адрес, на который отправляется сообщение