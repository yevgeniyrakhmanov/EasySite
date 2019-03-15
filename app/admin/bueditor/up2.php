<?php

# абсолютный путь
$base_path = dirname(__FILE__) . '/';

# Подключение конфигов
include_once $base_path . '../../config.inc.php';
include_once $base_path . '../../func.inc.php';

# подключаем конфигурационный файл
include_once dirname(__FILE__) . '/bueditor.php';

# определяем пути
$path = dirname(__FILE__) . '/../../' . $ffolder;
$tmppath = dirname(__FILE__) . '/../../' . $tmp;

# Ограничение доступа
if (!CheckLogin($config['login'], $config['password']))
	die('Доступ запрещён.');

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if (isset($_POST['rename'])) ### переименование файла
	{
		if (@!copy($tmppath . '/' . $_POST['name'], $path . '/' . $_POST['newname']))
		{	# выводим ошибки
			$content = '<p><strong class="attention">Файл не был загружен! Попробуйте <a href="?">повторить попытку</a>!</strong></p>';
		}
		else
		{	# выводим форму
			$content = '
			<p class="t-center">
				<strong>Файл <span class="attention">' . $_POST['name'] . '</span> переименован в <span class="attention">' . $_POST['newname'] . '</span> и успешно загружен на сервер!</strong>
			</p>
			<hr>
			<p>
				Тип файла: <strong>' . $_POST['oldtype'] . '</strong><br>
				Размер файла: <strong>' . round($_POST['oldsize'] / 1024, 2) . ' кб.</strong><br>
				Адрес файла: <strong>' . $site . $ffolder . '/' . $_POST['newname'] . ' (<a href="' . $site . $ffolder . '/' . $_POST['newname'] . '" target="_blank">просмотр</a>)</strong>
			</p>
			<hr>
			<p class="t-center">
				<a href="javascript:toOpen(\'' . $site . $ffolder . '/' . $_POST['newname'] . '\')">Вставить ссылку на файл</a> <a href="?">Загрузить ещё один файл!</a>
			</p>';

			# удаляем файл из тэмпа
			unlink($tmppath . '/' . $_POST['name']);
		}
	}
	elseif (isset($_POST['replace'])) ### замена файла
	{

		if (@!copy($tmppath . '/' . $_POST['name'], $path . '/' . $_POST['name']))
		{	# выводим ошибки
			die('<p><strong class="attention">Файл не был загружен! Попробуйте <a href="?">повторить попытку</a>!</strong></p>');
		}
		else
		{	# выводим форму
			$content = '
			<p class="t-center">
				<strong>Файл <span class="attention">' . $_POST['name'] . '</span> успешно загружен на сервер! Старый файл заменён.</strong>
			</p>
			<hr>
			<p>
				Тип файла: <strong>' . $_POST['oldtype'] . '</strong><br>
				Размер файла: <strong>' . round($_POST['oldsize'] / 1024, 2) . ' кб.</strong><br>
				Адрес файла: <strong>' . $site . $ffolder . '/' . $_POST['name'] . ' (<a href="' . $site . $ffolder. '/' . $_POST['name'] . '" target="_blank">просмотр</a>)</strong>
			<p>
			<hr>
			<p class="t-center">
				<a href="javascript:toOpen(\'' . $site . $ffolder . '/' . $_POST['name'] . '\')">Вставить ссылку на файл</a> <a href="?">Загрузить ещё один файл!</a>
			</p>';

			# удаляем файл из тэмпа
			unlink($tmppath . '/' . $_POST['name']);
		}
	}
	else
	{
		if (!is_uploaded_file($_FILES['UserFile']['tmp_name']))
		{
			$content = '<p><strong class="attention">Файл не был загружен! Попробуйте <a href="?">повторить попытку</a>!</strong></p>';
		}
		else # проверка на существование файла в папке на сервере
		{
			if (file_exists($path . '/' . $_FILES['UserFile']['name']))
			{
				# загружаем файл во временную директорию
				copy ($_FILES['UserFile']['tmp_name'], $tmppath . '/' . $_FILES['UserFile']['name']);

				# выводим форму
				$content = '
				<form method="post">
				<p class="t-center">
					<strong class="attention">Файл с таким именем уже существует!</strong>
				</p>
				<hr>
				<p>
					Адрес файла: <strong>' . $site . $ffolder . '/' . $_FILES['UserFile']['name'] . ' <a href="' . $site . $ffolder . '/' . $_FILES['UserFile']['name'] . '" target="_blank">Ссылка</a></strong> 
				<input type="submit" name="replace" value="Заменить">
				<input type="hidden" name="name" value="' . $_FILES['UserFile']['name'] . '">
				<input type="hidden" name="oldtype" value="' . $_FILES['UserFile']['type'] . '">
				<input type="hidden" name="oldsize" value="' . $_FILES['UserFile']['size'] . '">
				</p>
				</form>
				<hr>
				<form method="post" enctype="multipart/form-data">
				<p>
					<input type="text" name="newname" value="' . $_FILES['UserFile']['name'] . '">
					<input type="hidden" name="name" value="' . $_FILES['UserFile']['name'] . '">
					<input type="hidden" name="oldtype" value="' . $_FILES['UserFile']['type'] . '">
					<input type="hidden" name="oldsize" value="' . $_FILES['UserFile']['size'] . '">
					<input type="submit" name="rename" value="Переименовать">
				</p>
				</form>
				<hr>
				<p class="t-center">
					<a href="?">Загрузить другой файл?</a>
				</p>';
			}
			else # если всё ок...
			{
				if (@!copy($_FILES['UserFile']['tmp_name'], $path . '/' . $_FILES['UserFile']['name']))
				{
					# вывод ошибки
					$content = '<p><strong class="attention">Файл не был загружен! Попробуйте <a href="?">повторить попытку</a>!</strong></p>';
				}
				else
				{
					# вывод результата
					$content = '
					<p class="t-center">
						<strong>Файл <span class="attention">' . $_FILES['UserFile']['name'] . '</span> успешно загружён на сервер!</strong>
					</p>
					<hr>
					<p>
						Тип файла: <strong>' . $_FILES['UserFile']['type'] . '</strong><br>
						Размер файла: <strong>' . round($_FILES['UserFile']['size'] / 1024, 2) . ' кб.</strong><br>
						Адрес файла: <strong>' . $site . $ffolder . '/' . $_FILES['UserFile']['name'] . ' (<a href="' . $site .  $ffolder . '/' . $_FILES['UserFile']['name'] . '" target="_blank">просмотр</a>)</strong>
					</p>
					<hr>
					<p class="t-center">
						<a href="javascript:toOpen(\'' . $site . $ffolder . '/' . $_FILES['UserFile']['name'] . '\')">Вставить ссылку на файл</a> <a href="?">Загрузить ещё один файл!</a>
					</p>';
				}
			}
		}
	}
}
else
{
	# проверка на существование папок
	if (!file_exists($path))
		$content = '<p><strong>Пожалуйста, создайте папку для загрузки файлов <span class="attention">' . $path . '</span> и <a href="?">повторите попытку загрузить файл</a>.</strong></p>';

	if (!file_exists($tmppath))
		$content = '<p><strong>Пожалуйста, создайте папку для временных файлов <span class="attention">' . $tmppath . '</span> и <a href="?">повторите попытку загрузить файл</a>.</strong></p>';
		
	# вывод формы
	if (empty($_FILES['UserFile']['tmp_name']))
	{
		$content = '
		<p class="t-center">
			<strong>Загрузка файлов на сервер</strong>
		</p>
		<hr>
		<form method="post" enctype="multipart/form-data">
			<input type="hidden" name="MAX_FILE_SIZE" value=' . $isize . '>
			Выберите файл: <input type="file" name="UserFile">
			<input type="submit" value="Отправить">
		</form>
		<hr>
		<p>
			Размер файла не должен превышать <strong>' . round($isize / 1024, 2) . '</strong> кб<br>
			Папка загрузки: <strong>' . $site . $ffolder.'</strong>
		</p>';
	}
}

# Вывод дизайна на экран
echo '
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<title>Загрузка файлов</title>
	<link rel="stylesheet" href="' . $config['sitelink'] . 'admin/style.css" type="text/css" media="screen, projection" />
	<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<script type="text/javascript">
	function toOpen(alias)
	{
		if (!opener)
			return;
		opener.document.getElementById("text").value += "<a href=\"" + alias + "\" title=\"\"></a>";
		self.close();
	}
	</script>
</head>
<body>
<div id="wrapper">
</div><!-- #wrapper -->
' . $content . '
</body>
</html>
';