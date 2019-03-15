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

# Обработка отправки формы
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	# Удаление
	if (isset($_POST['delete']))
	{
		# Обработка данных
		$blocks = $_POST['block'];
		unset($blocks[$_POST['delete_block']]);

		# Обёртка данных шаблоном страницы
		ob_start();
		include_once $path . 'template/template_block.inc.php';
		$content = ob_get_clean();

		# Сохранение страницы
		SavePHP($path . "../template/blocks.inc.php", $content);
		
		# Перенаправление
		header('Location: ' . $config['sitelink'] . 'admin/block.php');
		die;
	}
		
	# Сохранение
	elseif (isset($_POST['save']))
	{
		# Обработка данных
		$blocks = $_POST['block'];
		
		if(!empty($blocks["add_new_block"]["name"]) || isset($blocks[$_POST['delete_block']]))
		{
			# Обёртка данных шаблоном страницы
			ob_start();
			include_once $path . 'template/template_block.inc.php';
			$content = ob_get_clean();

			# Сохранение страницы
			SavePHP($path . "../template/blocks.inc.php", $content);
		}
	}
	
	# Перенаправление
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	die;
}

else
{
	# Вывод блока
	if(isset($_GET['block']))
	{
		$names = GetBlocksNames();
		
		foreach ($names as $name)
		{
			$vars[$name] = GetBlockContent($name);
		}

		$content = '
		<a href="' . $config['sitelink'] . 'admin/block.php">Вернуться к списку блоков</a>
		<strong>Редактирование блока</strong>';
	}
	# Вывод списка блоков блока
	else
	{		
		$names = GetBlocksNames();
		
		$content ='
			<p class="text-center small">Здесь можно редактировать Блоки.</p>
			<div class="row">
				<div class="col-md-12">
					<div class="alert alert-success">
						<strong>Список блоков</strong>
						<ul class="list-group">
		';
		
		foreach ($names as $name)
		{
			$vars[$name] = GetBlockContent($name);
			$content .= '
							<li class="list-group-item"><a href="'.$config['sitelink'].'admin/block.php?block='.$name.'">'.$name.'</a></li>
			';
		}
			
		$content .= '
						</ul>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="alert alert-secondary">
						<strong>Добавить новый блок</strong>
		';
	}
# Подключение редактора
include_once $path . 'bueditor/bueditor.php';

# Шаблон формы
ob_start();
include_once $path . 'template/block.inc.php';
$content .= ob_get_clean();

# Параметры страницы
$title = 'Управление блоками';

# Вывод дизайна на экран
ob_start();
include_once $path . 'template/design.inc.php';
ob_end_flush();
	
}