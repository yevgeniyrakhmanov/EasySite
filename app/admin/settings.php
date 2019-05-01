<?php
# microText ver 0.6
# http://microText.info

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

# Заголовок кодировки
header('Content-type: text/html; charset=' . $config['encoding']);

# Ограничение доступа
if (!CheckLogin($config['login'], $config['password']))
	die('Доступ запрещён.');

$file = file_get_contents($path . '../config.inc.php');

# Обработка отправки формы
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{	
	# Сохранение
	if (isset($_POST['save']))
	{
		$settings = $_POST['settings'];

		$file = SetConfig($path, $file, 'config\[\'sitename\']', $settings['sitename']);				
		$file = SetConfig($path, $file, 'config\[\'slogan\']', $settings['slogan']);		
		$file = SetConfig($path, $file, 'config\[\'encoding\']', $settings['encoding']);		
		$file = SetConfig($path, $file, 'config\[\'template\']', $settings['template']);
		$file = SetConfig($path, $file, 'config\[\'login\']', $settings['login']);
		$file = SetConfig($path, $file, 'config\[\'password\']', $settings['password']);		
		$file = SetConfig($path, $file, 'config\[\'emailadmin\']', $settings['emailadmin']);		
		$file = SetConfig($path, $file, 'config\[\'emailsubject\']', $settings['emailsubject']);		
		SaveConfig($path, $file);
	}
	# Перенаправление на главную админки
	header('Location: ' . $config['sitelink'] . 'admin/settings.php');
	die;
}
else
{
	# Выбор конфига	
	$settings['sitename'] = GetConfig($file, 'config\[\'sitename\']');
	$settings['slogan'] = GetConfig($file, 'config\[\'slogan\']');
	$settings['encoding'] = GetConfig($file, 'config\[\'encoding\']');
	$settings['template'] = GetConfig($file, 'config\[\'template\']');
	$settings['login'] = GetConfig($file, 'config\[\'login\']');
	$settings['password'] = GetConfig($file, 'config\[\'password\']');
	$settings['emailadmin'] = GetConfig($file, 'config\[\'emailadmin\']');
	$settings['emailsubject'] = GetConfig($file, 'config\[\'emailsubject\']');

	# Шаблон формы
	ob_start();
	include_once $path . 'template/settings.inc.php';
	$content = ob_get_clean();

	# Параметры страницы
	$title = 'Управление настройками';

	# Вывод дизайна на экран
	ob_start();
	include_once $path . 'template/design.inc.php';
	ob_end_flush();
}