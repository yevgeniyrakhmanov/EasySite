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
		# Выбор всех существующих переменных без меню
		$vars1 = array_keys(get_defined_vars());
		
		# Подключение меню
		include_once $path . '../template/menu.inc.php';

		# Выбор всех существующих переменных включая меню
		$vars2 = array_keys(get_defined_vars());
		
		# Выбор переменных меню
		foreach($vars2 as $i=>$var)
		{
			if(!in_array($var, $vars1) && $var!='vars1')
			{
				$menus[$var] = MenuHandling( $$var, 'set');
			}
		}
		unset($menus[$_POST['delete_menu']]);		
		
		# Обёртка данных шаблоном страницы
		ob_start();
		include_once $path . 'template/template_menu.inc.php';
		$content = ob_get_clean();

		# Сохранение страницы
		SavePHP($path . "../template/menu.inc.php", $content);
		
		header('Location: ' . $config['sitelink'] . 'admin/menu.php');
		die;
	}
	# Сохранение
	if (isset($_POST['save']))
	{
		# Обработка данных
		
		$new_menus = (isset($_POST['new_menu']))?$_POST['new_menu']:'';
			
		$new_menu_block = (isset($_POST['new_menu_block']))?$_POST['new_menu_block']:'';

		# Выбор всех существующих переменных без меню
		$vars1 = array_keys(get_defined_vars());
		
		# Подключение меню
		include_once $path . '../template/menu.inc.php';

		# Выбор всех существующих переменных включая меню
		$vars2 = array_keys(get_defined_vars());
		
		# Выбор переменных меню
		foreach($vars2 as $i=>$var)
		{
			if(!in_array($var, $vars1) && $var!='vars1')
			{
				if(isset($_POST['old_name']) && $var == $_POST['old_name']) {
					$menus[$_POST['new_name']] = MenuHandling( $_POST['menu'], 'set', $new_menus, $new_menu_block);
					unset($_POST['new_name']);
				}
				else
					$menus[$var] = MenuHandling( $$var, 'set');
			}
		}		
		
		if(isset($_POST['new_name']))
			$menus[$_POST['new_name']] = MenuHandling( $_POST['menu'], 'set', $new_menus, $new_menu_block);
		
		# Обёртка данных шаблоном страницы
		ob_start();
		include_once $path . 'template/template_menu.inc.php';
		$content = ob_get_clean();

		# Сохранение страницы
		SavePHP($path . "../template/menu.inc.php", $content);
	}
	
	# Перенаправление
	header('Location: ' . $config['sitelink'] . 'admin/menu.php');
	die;
}
else
{
	# Вывод меню
	if(isset($_GET['menu']))
	{
		# Выбор всех существующих переменных без меню
		$vars1 = array_keys(get_defined_vars());
		
		# Подключение меню
		include_once $path . '../template/menu.inc.php';

		# Выбор всех существующих переменных включая меню
		$vars2 = array_keys(get_defined_vars());
		
		# Выбор переменных меню
		foreach($vars2 as $i=>$var)
		{
			if(!in_array($var, $vars1) && $var!='vars1')
			{
				$vars[$var] = $$var;
			}
		}

		$menu_items = MenuHandling($vars[$_GET['menu']]);

		$content = '
			<p>
				<a class="btn btn-primary" href="' . $config['sitelink'] . 'admin/menu.php">
					<i class="fas fa-angle-left"></i> Вернуться к списку меню
				</a>
			</p>
			<div class="row">
				<div class="col-md-12">
					<div class="alert alert-success">
						<strong>Редактирование меню</strong>
		';
	}
	# Вывод списка меню
	else
	{
		$content = '
		<p class="text-center small">Здесь можно редактировать имеющиеся и создавать новые меню.</p>
		<div class="row">
			<div class="col-md-12">
				<div class="alert alert-success">
					<strong>Список меню</strong>
					<ul class="list-group">
		';
		
		# Выбор всех существующих переменных без меню
		$vars1 = array_keys(get_defined_vars());
		
		# Подключение меню
		include_once $path . '../template/menu.inc.php';

		# Выбор всех существующих переменных включая меню
		$vars2 = array_keys(get_defined_vars());
		
		# Выбор переменных меню
		foreach($vars2 as $i=>$var)
		{
			if(!in_array($var, $vars1) && $var!='vars1')
			{
				$vars[$var] = $$var;
				$content.= '
					<li class="list-group-item">
						Редактировать <a href="'.$config['sitelink'].'admin/menu.php?menu='.$var.'">'.$var.'</a>
					</li>
				';
			}
		}
		$content .= '
					</ul>
				</div>
			</div>
			<div class="col-md-12">
				<div class="alert alert-secondary">
					<strong>Добавить новое меню</strong>
		';
	}
# Шаблон формы
	ob_start();
	include_once $path . 'template/menu.inc.php';
	$content .= ob_get_clean();

	# Параметры страницы
	$title = 'Управление меню';

	# Вывод дизайна на экран
	ob_start();
	include_once $path . 'template/design.inc.php';
	ob_end_flush();
}