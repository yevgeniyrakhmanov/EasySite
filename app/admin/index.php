<?php

# Вывод ошибок
error_reporting(E_ALL); // Уровень вывода ошибок
ini_set('display_errors', 'on'); // Вывод ошибок включён
ini_set('log_errors', 'on'); //Вкл логирование ошибок
ini_set('error_log', dirname(__FILE__). '/error_log.txt'); //Куда писать лог

# Абсолютный путь
$path = dirname(__FILE__) . '/';

# Подключение конфигов
include_once $path . '../config.inc.php';
include_once $path . 'func.inc.php';

#Извлечение
$templates = GetTemplates();
$blocks = GetBlocksNames();

# Заголовок кодировки
header('Content-type: text/html; charset=' . $config['encoding']);

# Ограничение доступа
if (!CheckLogin($config['login'], $config['password']))
	die('Доступ запрещён.');

else
{
	$content = '
		<div class="jumbotron text-center">
    		<h1>Добро пожаловать</h1>
    		<p>в панель управления сайтом</p>
  		</div>
	';
	$title = $config['sitename'];

	# Вывод дизайна на экран
	ob_start();
	include_once $path . 'template/design.inc.php';
	ob_end_flush();
}