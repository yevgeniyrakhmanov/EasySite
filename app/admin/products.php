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

#Извлечение
$templates = GetTemplates();
$blocks = GetBlocksNames();

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
		// unlink($path . '../contentproducts/' . $_POST['dir'] . $_POST['oldpage'] . '.inc.php');
		rename($path . '../contentproducts/' . $_POST['dir'] . $_POST['oldpage'] . '.inc.php', $path . '../backup/contentproducts/' . trim($_POST['dir'], '/') . '_' . $_POST['oldpage'] . '_' . date("d_m_Y_H_i_s") . '.inc.php');


	# Сохранение
	if (isset($_POST['save']))
	{
		$page_content = array();
		# Обработка данных

		$page = trim(str2url(htmlspecialchars($_POST['title']), ENT_QUOTES));
		$dir = trim($_POST['dir']);

		$page_content['category'] = lat2rus($dir);

		$filename = $page . '.inc.php';
		$page_content['link'] = $filename;

		# если файл есть, оставляем дату, когда он был создан, а если файл новый - присваиваем сегодняшнюю дату.
		$root = $_SERVER['DOCUMENT_ROOT'];
		$filelink = $root . '/contentproducts/' . $dir . $filename;
		if (file_exists($filelink)) {
			$page_content['date'] = trim($_POST['date']);
		}
		else {
			$timezone = "Europe/Kiev";
			date_default_timezone_set($timezone);
			$today = date("d.m.Y");
			$page_content['date'] = $today;
		}

		$page_content['title'] = trim(delquotes($_POST['title']));
		$page_content['keywords'] = (isset($_POST['keywords'])) ? trim($_POST['keywords']) : '';
		$page_content['description'] = (isset($_POST['description'])) ? trim($_POST['description']) : '';
		$page_content['content'] = trim($_POST['content']);
		$page_content['template'] = $_POST['template'];
		$page_content['page_blocks'] = '';
		if (isset($_POST['page_blocks']) && is_array($_POST['page_blocks']))
		{
			foreach($_POST['page_blocks'] as $i => $block)
			{
			if($i!=0)
				$page_content['page_blocks'] .=	', ';
			$page_content['page_blocks'] .= $block;	
			}
		}
		
		if ($_POST['oldpage'] == 'new')
		{
			# Обёртка данных шаблоном страницы
			ob_start();
			include_once $path . 'template/template_page.inc.php';
			$content = ob_get_clean();
			# Сохранение новой страницы
			SavePHP($path . "../contentproducts/$dir$page.inc.php", $content);
		}
		else
		{
			$oldpage = ($_POST['oldpage'] != $page) ? $_POST['oldpage'] : $page;
			# Сохранение существующей страницы
			SavePHP1products($path, $page_content, $oldpage, $page, $dir);
			# При переименовании файла, старая страница удаляется
			if ($_POST['oldpage'] != $page)
				unlink($path . '../contentproducts/' . $dir . $_POST['oldpage'] . '.inc.php');
				// rename($path . '../contentproducts/' . $dir . $_POST['oldpage'] . '.inc.php', $path . '../backup/contentproducts/' . $dir . $_POST['oldpage'] . '.inc.php');
		}
		
		
	}
	# Перенаправление на страницу раздела
	$dir_dir = (isset($_POST['dir']) && $_POST['dir'] != '/' && $_POST['dir'] != '') ? '?dir=' . $_POST['dir'] : '';
	header('Location: ' . $config['sitelink'] . 'admin/products.php' . $dir_dir);
	die;
}
else
{

	# Создание раздела
	if (isset($_GET['new_dir']))
	{
		$_GET['new_dir'] = str2url($_GET['new_dir']);
		if (!is_dir($path . '/../contentproducts/' . $_GET['new_dir']))
			mkdir($path . '/../contentproducts/' . $_GET['new_dir']);

			# Автоматическое создание страницы в разделе SHOP при создании рубрики

			$page_content = array();

			$page_cat = trim(str2url($_GET['new_dir']));

			$page_content['category'] = '';

			$filename = $page_cat . '.inc.php';
			$page_content['link'] = $filename;

			$root = $_SERVER['DOCUMENT_ROOT'];
			$filelink = $root . '/content/' . $filename;

			$page_content['date'] = '';

			$rusnamedir = lat2rus($_GET['new_dir']);

			$page_content['title'] = $rusnamedir;
			$page_content['keywords'] = $rusnamedir;
			$page_content['description'] = $rusnamedir;
			$page_content['content'] = '{$get_product_list(\''.$page_cat.'/\')}';
			$page_content['template'] = 'page';
			$page_content['page_blocks'] = '';

			ob_start();
			include_once $path . 'template/template_page.inc.php';
			$content = ob_get_clean();
			# Сохранение новой страницы
			SavePHP($path . "../content/shop/$page_cat.inc.php", $content);

			# Окончание автоматического создания страницы в разделе SHOP при создании рубрики

		header ('Location: ' . $config['sitelink'] . 'admin/products.php');
		die;
	}

	# Удаление раздела (перемещение в папку backup/contentproducts для бэкапа)
	if (isset($_GET['delete_dir']))
	{
		// CleanDir($path . '/../contentproducts/' . $_GET['delete_dir']);
		// rmdir($path . '/../contentproducts/' . $_GET['delete_dir']);

		$delete_dir = trim($_GET['delete_dir'], '/');
 
		rename($path . '/../contentproducts/' . $_GET['delete_dir'], $path . '/../backup/contentproducts/' . $delete_dir.'_'.date("d_m_Y_H_i_s").'/');

		header ('Location: ' . $config['sitelink'] . 'admin/products.php');
		die;
	}

	# Вывод страницы
	if (isset($_GET['page']))
	{
		$page = $_GET['page'] . '.inc.php';
		$dir = (isset($_GET['dir']) && $_GET['dir'] != '/') ? trim($_GET['dir'], '/') . '/' : '';
		$form['oldpage'] = $form['page'] = $_GET['page'];

		$form['link'] = GetContentProducts($page, 'link', $dir);
		$form['date'] = GetContentProducts($page, 'date', $dir);
		$form['category'] = GetContentProducts($page, 'category', $dir);
		$form['title'] = GetContentProducts($page, 'title', $dir);
		$form['keywords'] = GetContentProducts($page, 'keywords', $dir);
		$form['description'] = GetContentProducts($page, 'description', $dir);
		$form['template'] = GetContentProducts($page, 'template', $dir);
		$form['row'] = file_get_contents($path . '../contentproducts/' . $dir . $form['oldpage'] . '.inc.php');

		$page_blocks = GetContentProducts($page, 'page_blocks', $dir);
		if ($page_blocks!='')
		{
			$tmp_bolcks = explode(', ', $page_blocks);
			foreach($tmp_bolcks as $i=>$block)
			{
				$form['page_blocks'][$i] = $block;
			}
		}
		$dir_dir = ($dir != '') ? '?dir=' . $dir : '';
		$content = '<p><a class="btn btn-primary" href="' . $config['sitelink'] . 'admin/products.php' . $dir_dir . '"><i class="fas fa-angle-left"></i> Вернуться к списку товаров</a></p>
			<div class="row">
				<div class="col-md-12">
					<div class="alert alert-success">
						<h2>Редактирование товара</h2>';

		$file = file_get_contents($path . '../contentproducts/' . $dir . $form['oldpage'] . '.inc.php');
		$form['content'] = GetContentFromEOF($file);
	}
	elseif (isset($_GET['dir']))
	{
		$dir = trim($_GET['dir'], '/') . '/';
		$rudir = url2str($dir);
		# Выбор всех страниц в папке contentproducts/
		$pages = GetProducts($dir);
		
		# Описание страницы
		$page_content = '
			<h2 class="text-center">Категория <span class="text-uppercase">«' . $rudir . '»</span></h2>
			<div class="row">
				<div class="col-md-12">
					<div class="alert alert-success">
						<div class="d-flex justify-content-between mt-3 mb-3">
							<a class="btn btn-primary" href="' . $config['sitelink'] . 'admin/products.php"><i class="fas fa-angle-left"></i> Вернуться к списку категорий</a>
							<form method="get">
								<input type="hidden" name="delete_dir" value="' . $dir . '">
								<button type="submit" class="btn btn-danger" onclick="return confirm(\'Вы действительно хотите удалить категорию со всеми товарами?\')">Удалить категорию</button>
							</form>
						</div>
						<strong>Товары категории</strong>
						<ul class="list-group">
		';

		# Вывод списка страниц с учётом исключений
		foreach ($pages as $i => $page)
		{
			$title = GetContentProducts($page, 'title', $dir);
			$page_content .= "<li class='list-group-item'><a href='?page=$i&dir=$dir'>$title</a></li>";
		}
		
		if (empty($pages))
			$page_content .= '<li class="list-group-item">В этой категории нет товаров.</li>';
		
		$content = $page_content . '
						</ul>
					</div>
				</div>
			</div>
			<p><a class="btn btn-success" data-toggle="collapse" href="#addproduct">Добавить новый товар в категорию «' . $rudir . '»</a></p>
			<div class="row collapse" id="addproduct">
				<div class="col-md-12">
					<div class="alert alert-secondary">
						<strong>Добавить новый товар в категорию «' . $rudir . '»</strong>';
	}
	# Вывод списка страниц
	else
	{
		# Выбор всех страниц и разделов в папке contentproducts/
		$pages = GetProducts();
		$dirs = GetCategories();

		# Описание страницы
		$dir_content = '
		<p class="d-none text-center small">Здесь можно редактировать и удалять существующие товары, а также добавлять новые.</p>
		<p class="d-none text-center small">Страницы товаров категории будут иметь адреса второй вложенности вроде <code>http://site.ru/<strong>Category</strong>/Product</code>.</p>
		<div class="row">
			<div class="col-md-4">
				<div class="alert alert-success">
					<strong>Категории</strong>
					<ul class="list-group">';
		
		# Вывод разделов
		if (!empty($dirs))
		{
			foreach ($dirs as $i => $dir){
				$rudir = url2str($dir);
				$dir_content .= "
					<li class='list-group-item'><a href='?dir=$dir/'>$rudir</a></li>";
			}
		}
		else
			$dir_content .= '<li class="list-group-item">Категорий нет.</li>';
			
		$dir_content .= '
					</ul>
				</div>
			</div>
			<div class="col-md-8">
				<div class="alert alert-secondary">
					<strong>Добавить новую категорию</strong>
					<form mathod="get">
						<div class="form-group">
							<input class="form-control form-control" type="text" name="new_dir" placeholder="Название категории" required>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-success">Создать категорию</button>
						</div>
					</form>
				</div>
			</div>
		</div>';

		# Вывод списка страниц с учётом исключений
		$page_content = '
			<div class="row d-none">
			<hr>
				<div class="col-md-4">
					<div class="alert alert-success">
						<strong>Товары без категории</strong>
						<ul class="list-group">';
		
		foreach ($pages as $i => $page)
		{
			$title = GetContentProducts($page, 'title');
			$page_content .= "<li class='list-group-item'><a href='?page=$i'>$title</a></li>";
		}
		
		$content = $dir_content . $page_content . '
						</ul>
					</div>
				</div>
				<div class="col-md-8">
					<div class="alert alert-secondary">
						<strong>Добавить новый товар без категории</strong>
		';
	}
	
	// # Подключение редактора
	// include_once $path . 'bueditor/bueditor.php';

	# Шаблон формы
	ob_start();
	include_once $path . 'template/form_product.inc.php';
	$content .= ob_get_clean();

	# Параметры страницы
	$title = 'Управление товарами';

	# Вывод дизайна на экран
	ob_start();
	include_once $path . 'template/design.inc.php';
	ob_end_flush();
}