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
		<p><a class="btn btn-primary" href="' . $config['sitelink'] . 'admin/block.php"><i class="fas fa-angle-left mr-3"></i> Вернуться к списку блоков</a></p>
		<div>
			<div>
		';
	}
	# Вывод списка блоков блока
	else
	{		
		$names = GetBlocksNames();
		
		$content ='
			<div class="row">
				<div class="col-12">
					<ul class="list-group">';
		
		foreach ($names as $name)
		{
			$vars[$name] = GetBlockContent($name);
			$name_rus = lat2rus($name);
			$content .= '
						<li class="list-group-item input-group">
							<a class="d-flex justify-content-between btn text-primary" href="'.$config['sitelink'].'admin/block.php?block='.$name.'" title="Редактировать блок «'.$name_rus.'»">
								<span><i class="fas fa-angle-right mr-3"></i> '.$name_rus.'</span> <i class="fas fa-edit"></i>
							</a>
						</li>
			';
		}
			
		$content .= '</ul>
				</div>
			</div>
			<p><a class="btn btn-success mt-3" data-toggle="collapse" href="#addblock">Добавить новый блок <i class="fas fa-angle-down ml-3"></i></a></p>
			<div class="row collapse" id="addblock">
				<div class="col-12">';
	}

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