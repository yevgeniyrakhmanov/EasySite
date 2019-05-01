<?php
# microText ver 0.6
# http://microText.info

# Функция обработки ошибки
function error404($pageout = false, $encoding = 'utf-8')
{
	header('Cache-Control: no-cache, no-store');
	header('Content-Type: text/html; charset=' . $encoding);
	header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
	if ($pageout)
		readfile('404.shtml');
	die;
}

# Генерация меню. По умолчанию ссылка активной страницы выделяется классом "active"
function GetMenuItems($page, $menu_items, $category = null)
{
	global $config;
	$menu = '';
	$category = ($category != null) ? $category . '/' : '';

	foreach ($menu_items as $i => $item)
	{
		if ($category . $page == $item[0])
			$menu .= '<li class="nav-item active"><a class="nav-link" href="' . $config['sitelink'] . $item[0] . '" title="' . $item[2] . '">' . $item[1] . '</a></li>';
		else
			$menu .= '<li class="nav-item"><a class="nav-link" href="' . $config['sitelink'] . $item[0] . '" title="' . $item[2] . '">' . $item[1] . '</a></li>';
	}

	return $menu;
}

# Генерация сложного меню из 2 уровней. По умолчанию ссылка активной страницы выделяется классом "active"
function GetComplexMenuItems($page, $menu_items, $category = null)
{
	global $config;
	$menu = '';
	$category = ($category != null) ? $category . '/' : '';

	foreach ($menu_items as $i => $item)
	{
		if (isset($item[3]) && is_array($item[3]))
		{
			if ($category . $page == $item[0])
				$menu .= '<li class="nav-item active"><a class="nav-link" href="' . $config['sitelink'] . $item[0] . '" title="' . $item[2] . '">' . $item[1] . '</a></li>';
			else
				$menu .= '<li class="nav-item"><a class="nav-link" href="' . $config['sitelink'] . $item[0] . '" title="' . $item[2] . '">' . $item[1] . '</a></li>';

			$menu .= '<ul class="nav flex-column">';

			foreach ($item[3] as $submenu_item)
			{
				if ($category . $page == $submenu_item[0])
					$menu .= '<li class="nav-item active"><a class="nav-link" href="' . $config['sitelink'] . $submenu_item[0] . '" title="' . $submenu_item[2] . '">' . $submenu_item[1] . '</a></li>';
				else
					$menu .= '<li class="nav-item"><a class="nav-link" href="' . $config['sitelink'] . $submenu_item[0] . '" title="' . $submenu_item[2] . '">' . $submenu_item[1] . '</a></li>';
			}

			$menu .= '</ul>';
		}
		else
		{
			if ($page == $item[0])
				$menu .= '<li class="active"><a class="nav-link" href="' . $config['sitelink'] . $item[0] . '" title="' . $item[2] . '">' . $item[1] . '</a></li>';
			else
				$menu .= '<li><a class="nav-link" href="' . $config['sitelink'] . $item[0] . '" title="' . $item[2] . '">' . $item[1] . '</a></li>';
		}
	}

	return $menu;
	
}
# Генерация сложного меню. По умолчанию ссылка активной страницы выделяется классом "active". Родительская ссылка выделяется также классом "parent".
function GetMenuItemsU($page, $menu_items, $category = null)
{
	global $config;
	$category = ($category != null) ? $category . '/' : '';
	$menu = '';	
	$s = 1;
	$k = $sort = 0;
	$level = $parent = $sort1 = array();
	$tmp_item[$k] = (isset($menu_items)) ? $menu_items : '';
	while (isset($tmp_item[$k]))
	{
		foreach ($tmp_item[$k] as $j => $item)
		{				
			if ($category . $page == $item[0])
			{
				$active[$sort] = true;
				if (isset($parent[$k]) && $parent[$k] >= 0)
					$active[$parent[$k]] = true;
			}
			else $active[$sort] = false;

			$temp_menu_item[$sort] = '<a class="nav-link" href="' . $config['sitelink'] . $item[0] . '" title="' . $item[2] . '">' . $item[1] . '</a>';
			#массив предков
			$temp_parent[$sort] = $k;
			#массив уровней 1
			if (!isset($lvl[$k]))
				$lvl[$k] = 0;
			#массив с элементами субменю для следующих итераций
			if (isset($item[3]) && is_array($item[3]))
			{
				$tmp_item[$s] = $item[3];
				$lvl[$s] = $lvl[$k] + 1;					
			}
			#массив уровней 2
			$level[$sort] = $lvl[$k];
			#определение предка элемента
			$parent[$s]	= (isset($tmp_item[$s])) ? $sort : 0;

			$s = (isset($tmp_item[$s])) ? $s + 1 : $s;
			#генерируем сортирующий массив
			if (isset($parent[$k]) && $parent[$k] >= 0)
			{			
				$off = array_search($parent[$k], $sort1) + $j + 1;
				array_splice($sort1, $off, 0, $sort);									
			}
			else
				$sort1[] = $sort;
			
			$sort++;
		}
		$k++;
	}
	$op = array();
	
	foreach($sort1 as $i => $key)
	{
		if ($i > 0 && $temp_parent[$sort1[$i]] > $temp_parent[$sort1[$i - 1]])
		{
			$menu .= '<ul class="nav flex-column mb-3">';
			$op[] = $sort1[$i - 1];
		}
		if ($active[$key])
			$menu .= '<li class="nav-item active">' . $temp_menu_item[$key] . '</li>';
		else
			$menu .= '<li class="nav-item">' . $temp_menu_item[$key] . '</li>';
		$j = $temp_parent[$sort1[$i]];
		$k = (isset($sort1[$i + 1])) ? $sort1[$i + 1] : $sort1[$i];
		$j = $level[$sort1[$i]];
		$k = (isset($sort1[$i + 1])) ? $sort1[$i + 1] : 0;
		$c = count($op);
		while ($j > $level[$k] || ($c > 0 && $i == count($sort1[$i]) - 1))
		{
			$menu .= '</ul>';				
			$j--;
			$c--;
			array_pop($op);
		}
	}
	return $menu;
}

# Функция HTTP авторизации. Логин и пароль задаются в параметрах
function CheckLogin($login, $password)
{
	$login_successful = false;	

	# Проверка логина и пароля
	if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']))
	{
		if ($_SERVER['PHP_AUTH_USER'] == $login && $_SERVER['PHP_AUTH_PW'] == $password)
		{
			$login_successful = true;
		}
	}

	# Если юзер не залогинен
	if (!$login_successful)
	{
		# Форма авторизации
		header('WWW-Authenticate: Basic realm="Enter login and password"');
		header('HTTP/1.0 401 Unauthorized');
	}
	else
	{
		return true;
	}
}

# Генерация антиспама
function GenerateAntispam($secret)
{
	return md5('s' . date("Y-m-d") . 'p' . date("d-m-Y") . 'a' . $secret . 'm');
}

# Проверка антиспама
function CheckSpam($antispam, $secret)
{
	return (md5('s' . date("Y-m-d") . 'p' . date("d-m-Y") . 'a' . $secret . 'm') == $antispam);
}

# Валидация формы обратной связи (обязательные поля)
function ValidateFeedbackForm($email, $name, $topic, $message)
{
	global $config;

	$name = filter_var($name, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW);
	$topic = filter_var($topic, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW);
	$message = filter_var($message, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW);

	if (empty($name))
		return $config['form']['emptyName'];
	elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false)
		return $config['form']['emptyEmail'];
	elseif (empty($topic) && $config['form']['feedback']['subject'] == true)
		return $config['form']['emptyTopic'];
	elseif (empty($message))
		return $config['form']['emptyMessage'];
	else
		return false;
}

# Подготовка письма обратной связи
function PrepareFeedbackEmail($fromEmail, $content, $subject, $fromName)
{
	ob_start();
	include_once dirname(__FILE__) . '/template/email/feedback.inc.php';
	return ob_get_clean();
}

# Отправка письма
function SendEmail($toEmail, $fromEmail, $subject, $content, $from = null, $encoding = 'utf-8')
{
	# Если от кого не указано, подставляем робота :)
	if ($from == null)
		$from = 'Robo';

	# Обработка темы
	$subject = "=?$encoding?b?" . base64_encode($subject) . "?=";
	# Формирование заголовков
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=$encoding\r\n";
	$headers .= "From: =?$encoding?b?" . base64_encode($from) . "?= <" . $fromEmail . ">";

	return (mail($toEmail, $subject, $content, $headers));
}

# Обработка текста для сохранения в базу данных или отправки по почте
function ProcessText($text)
{
	$text = trim($text); # Удаляем пробелы по бокам
	$text = stripslashes($text); # Удаляем слэши, лишние пробелы и переводим html символы
	$text = htmlspecialchars($text); # Переводим HTML в текст
	$text = preg_replace("/ +/"," ", $text); # Множественные пробелы заменяем на одинарные
	$text = preg_replace("/(\r\n){3,}/","\r\n\r\n", $text); # Убираем лишние пробелы (больше 1 строки)
	$text = str_replace("\r\n","<br>", $text); # Заменяем переводы строк на тег

	return $text; # Возвращаем переменную
}

function GetBlock($page_blocks, $block_name, $block)
{	
	if (!empty($page_blocks) && !empty($block_name) && !empty($block))
	{		
		$tmp = explode(', ', $page_blocks);
		foreach ($tmp as $i)
		{
			if ($i == $block_name)
				return $block;
		}
	}
	return;
}
# Выборка шаблонов
function GetTemplates()
{
	$path = dirname(__FILE__) . '/../template/';
	$templates = array();

	# Парсим папку templates
	$handle = opendir($path);

	# Выбираем массив шаблонов
	if ($handle != false)
	{
		while (($file = readdir($handle)) !== false)
		{
			if ((strpos($file, '.')>0) && $file != '..' && $file != '.' && $file != 'blocks.inc.php' && $file != 'menu.inc.php')
			{
				$i = strtok($file, '.');
				$templates[] = $i;
			}
		}

		closedir($handle);
	}
	
	# Сортируем массив
	if(!empty($templates))
		natsort($templates);
	else
		$templates =false;
	return $templates;
}



# Д О П О Л Н И Т Е Л Ь Н Ы Е   М О Д У Л И

# Транслитерация с латиницы на русский
function lat2rus($string) {
    $converter = array(
        'а' => 'a',   'b' => 'б',   'v' => 'в',
        'g' => 'г',   'd' => 'д',   'je' => 'е',
        'jo' => 'ё',  'zh' => 'ж',  'z' => 'з',
        'i' => 'и',   'j' => 'й',   'k' => 'к',
        'l' => 'л',   'm' => 'м',   'n' => 'н',
        'o' => 'о',   'p' => 'п',   'r' => 'р',
        's' => 'с',   't' => 'т',   'u' => 'у',
        'f' => 'ф',   'h' => 'х',   'c' => 'ц',
        'ch' => 'ч',  'sh' => 'ш',  'shh' => 'щ',
        'w' => 'ь',  'y' => 'ы',   'q' => 'ъ',
        'e' => 'э',  'ju' => 'ю', 'ja' => 'я',
        '_'  => ' ',  '-' => '-', '/' => '',

        'A' => 'А',   'B' => 'Б',   'V' => 'В',
        'G' => 'Г',   'D' => 'Д',   'JE' => 'Е',
        'JO' => 'Ё',  'ZH' => 'Ж',  'Z' => 'З',
        'I' => 'И',   'J' => 'Й',   'K' => 'К',
        'L' => 'Л',   'M' => 'М',   'N' => 'Н',
        'O' => 'О',   'P' => 'П',   'R' => 'Р',
        'S' => 'С',   'T' => 'Т',   'U' => 'У',
        'F' => 'Ф',   'H' => 'Х',   'C' => 'Ц',
        'CH' => 'Ч',  'SH' => 'Ш',  'SHH' => 'Щ',
        'W' => 'Ь',  'Y' => 'Ы',   'Q' => 'Ъ',
        'E' => 'Э',  'JU' => 'Ю', 'JA' => 'Я',
    );
    return strtr($string, $converter);
}
function url2str($str) {
    # переводим в транслит
    $str = lat2rus($str);
    return $str;
}


# ----- Вывод публикаций и рубрик -----

# Выбор параметров публикации
function GetPosts($page, $var, $dir)
{
	$text = file_get_contents(dirname(__FILE__) . '/contentposts/'.$dir.'/'.$page);
	preg_match('|\$'.$var.'[^\n]*\'([^\n]*)\';|Uisu', $text, $matches);
	return (isset($matches[1])) ? $matches[1] : '';
}

# Сортировка публикаций по дате создания файлов ( вывод на страницу: {$get_post_list('Nazvanie_papki/')} )
function GetPostList($dir) {

	global $config;

	$postlist = '';
	$postmarkup = '';

	$path = dirname(__FILE__) . '/contentposts/' . $dir;

	$pages = array();

	# Парсим папку contentposts
	$handle = opendir($path);

	# Выбираем массив публикаций
	if ($handle != false)
	{
		while (($file = readdir($handle)) !== false)
		{
			if (is_file($path . $file))
			{
				$i = filemtime($path . $file) . ',' . $file;
				$pages[$i] = $file;
			}
		}
		closedir($handle);
	}

	# Сортируем массив по дате создания файлов
	krsort($pages);

	// $rudir = url2str($dir);
	$postmarkup .= '
	<div class="rubrics">
		<ul class="posts nav flex-column">';

    foreach ($pages as $i => $page)
    {
		# Выбираем, какие параметры публикации хотим видеть
		$title = GetPosts($page, 'title', $dir);
		$date = GetPosts($page, 'date', $dir);
		$caterory = GetPosts($page, 'category', $dir);
		$description = GetPosts($page, 'description', $dir);

		# Убираем расширение файла и формируем урл публикации
		$fileaddon = strpos($page, ".");
		$filename = substr($page, 0, $fileaddon);
		$posturl = $config['sitelink'].$dir.$filename;

		# Верстаем шаблон вывода списка публикаций
		$postmarkup .= '
			<li>
				<h3><a href="'.$posturl.'" title="'.$title.'">'.$title.'</a></h3>
				<p class="text-small">'.$caterory.' | '.$date.' </p>
				<p>'.$description.' <a href="'.$posturl.'" title="'.$title.'"> Подробнее </a></p>
			</li>
		';
    }

	if (empty($pages))
	$postlist .= '
			<li>В этой рубрике нет страниц.</li>';

    $postlist .= $postmarkup;

    # Выводим список публикаций, отсортированный по дате создания файлов
    return 
    		$postlist.'
		</ul>
	</div>';
}

# Вывод списка рубрик
function GetRubric() {

	global $config;

	$dirlist = '';
	$dirmarkup = '';

	$path = dirname(__FILE__) . '/contentposts/';
	$dirs = array();


	# Парсим папку content
	$handle = opendir($path);

	# Выбираем массив файлов
	if ($handle != false)
	{
		while (($dir = readdir($handle)) !== false)
			if (is_dir($path . $dir) && $dir != '..' && $dir != '.')
				$dirs[] = $dir;

		closedir($handle);
	}

	foreach ($dirs as $i => $dir){
		$rudir = url2str($dir);
		$rubriclink = $config['sitelink'].$dir;
		$dirmarkup .= '
			<li><a href="'.$rubriclink.'">'.$rudir.'</a></li>';
	}

	$dirlist .= $dirmarkup;

	return $dirlist;

}

# Вывод всех публикаций, но пока только отсортированных по рубрикам
function GetAllPosts()
{
	$path = dirname(__FILE__) . '/contentposts/';
	$readdirectory = dir($path);
	while(false !== ($dir = $readdirectory->read()))
	{
		if($dir != "." && $dir != "..")
		{
			$subpages = GetPostList($dir.'/');
			print $subpages;
		}
	}
}


# ----- Вывод товаров и категорий -----

# Выбор параметров товара
function GetProducts($page, $var, $dir)
{
	$text = file_get_contents(dirname(__FILE__) . '/contentproducts/'.$dir.'/'.$page);
	preg_match('|\$'.$var.'[^\n]*\'([^\n]*)\';|Uisu', $text, $matches);
	return (isset($matches[1])) ? $matches[1] : '';
}

# Сортировка товаров по дате создания файлов ( вывод на страницу: {$get_product_list('Nazvanie_papki/')} )
function GetProductList($dir) {

	global $config;

	$postlist = '';
	$postmarkup = '';

	$path = dirname(__FILE__) . '/contentproducts/' . $dir;

	$pages = array();

	# Парсим папку contentproducts
	$handle = opendir($path);

	# Выбираем массив публикаций
	if ($handle != false)
	{
		while (($file = readdir($handle)) !== false)
		{
			if (is_file($path . $file))
			{
				$i = filemtime($path . $file) . ',' . $file;
				$pages[$i] = $file;
			}
		}
		closedir($handle);
	}

	# Сортируем массив по дате создания файлов
	krsort($pages);

	$rudir = url2str($dir);
	$postmarkup .= '
	<div class="categories">
		<ul class="products nav flex-column">';

    foreach ($pages as $i => $page)
    {
		# Выбираем, какие параметры товара хотим видеть
		$title = GetProducts($page, 'title', $dir);
		$caterory = GetProducts($page, 'category', $dir);
		$description = GetProducts($page, 'description', $dir);

		# Убираем расширение файла и формируем урл товара
		$fileaddon = strpos($page, ".");
		$filename = substr($page, 0, $fileaddon);
		$posturl = $config['sitelink'].$dir.$filename;

		# Верстаем шаблон вывода списка товаров
		$postmarkup .= '
			<li>
				<h3><a href="'.$posturl.'" title="'.$title.'">'.$title.'</a></h3>
				<p class="text-small">'.$caterory.'</p>
				<p>'.$description.' <a href="'.$posturl.'" title="'.$title.'"> Подробнее </a></p>
			</li>
		';
    }

	if (empty($pages))
	$postlist .= '
			<li>В этой категории нет товаров.</li>';

    $postlist .= $postmarkup;

    # Выводим список товаров, отсортированный по дате создания файлов
    return 
    		$postlist.'
		</ul>
	</div>';
}

# Вывод товаров в категории
function GetCategories() {

	global $config;
	
	$dirlist = '';
	$dirmarkup = '';

	$path = dirname(__FILE__) . '/contentproducts/';
	$dirs = array();


	# Парсим папку contentproducts
	$handle = opendir($path);

	# Выбираем массив файлов
	if ($handle != false)
	{
		while (($dir = readdir($handle)) !== false)
			if (is_dir($path . $dir) && $dir != '..' && $dir != '.')
				$dirs[] = $dir;

		closedir($handle);
	}

	foreach ($dirs as $i => $dir){
		$rudir = url2str($dir);
		$categorylink = $config['sitelink'].'shop/'.$dir;
		$dirmarkup .= '
			<li><a href="'.$categorylink.'">'.$rudir.'</a></li>';
	}

	$dirlist .= 
		'<ul class="products nav flex-column">'
			. $dirmarkup .
		'</ul>';

	return $dirlist;

}

# Вывод всех товаров, но пока отсортированных по категориям
function GetAllProducts()
{
	$path = dirname(__FILE__) . '/contentproducts/';
	$readdirectory = dir($path);
	while(false !== ($dir = $readdirectory->read()))
	{
		if($dir != "." && $dir != "..")
		{
			$subpages = GetProductList($dir.'/');
			print $subpages;
		}
	}
}









































function GetGallery()
{
	$wimg = "";
	$fimg = "";
	$path = "/img/gallery/"; // задаем путь до сканируемой папки с изображениями
	$images = scandir(__DIR__ . $path); // сканируем папку
	if ($images !== false) { // если нет ошибок при сканировании
		$images = preg_grep("/\.(?:png|gif|jpe?g)$/i", $images); // через регулярку создаем массив только изображений
		if (is_array($images)) { // если изображения найдены
			foreach($images as $image) { // делаем проход по массиву
				$pathinfo = pathinfo($image, PATHINFO_FILENAME);
				$imgname = lat2rus($pathinfo);
				$fimg .= '
					<a href="'.$path.htmlspecialchars(urlencode($image)).'" title="'.$imgname.'" class="media">
						<img src="'.$path.htmlspecialchars(urlencode($image)).'" alt="'.$imgname.'">
					</a>';
				}
				$wimg .= $fimg;
		} else { // иначе, если нет изображений
			$wimg .= "<p>Не обнаружено изображений в директории!</p>";
		}
	} else { // иначе, если директория пуста или произошла ошибка
		$wimg .= "<p>Директория пуста или произошла ошибка при сканировании.</p>";
	}
    return $wimg; // выводим полученный результат
}

