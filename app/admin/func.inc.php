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
		readfile('../404.shtml');
	die;
}
# Функция HTTP авторизации. Логин и пароль задаются в параметрах
function CheckLogin($login, $password)
{		
	#Стартуем или восстанавливаем сессию
	session_start();
	
	$login_successful = false;

	$logedout = (isset($_SESSION['logout'])) ? $_SESSION['logout'] : false;

	# Проверка логина и пароля
	if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']))
	{
		if ($_SERVER['PHP_AUTH_USER'] == $login && $_SERVER['PHP_AUTH_PW'] == $password  && $logedout != true)
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
	
		exit;
	}
	else
	{		
		return true;
	}
}
# Сохранение контента новой страницы в файл
function SavePHP($file, $content)
{
	return (file_put_contents($file, '<' . "?php\n" . stripslashes($content)));
}
# Сохранение контента существующей страницы в файл
function SavePHP1($path, $page_content, $oldpage, $page, $dir)
{
	$content = file_get_contents($path . "../content/$dir$oldpage.inc.php");

	foreach ($page_content as $name => $var)
	{
		if ($name == 'content')
		{
			$repl = '$content = <<<EOF'."\n".$var."\n".'EOF;';
			$content = preg_replace('|\$'.$name.'\s*=\s*<<<EOF.*EOF;|Uisu', $repl, $content);
		}
		else
		{
			$repl = "$".$name." = '".$var."';\n"; 
			$content = preg_replace('|\$'.$name.'\s*=\s*.[^\n]*\n|Uisu', $repl, $content);
		}
	}
	return (file_put_contents($path . "../content/$dir$page.inc.php", stripslashes($content)));
}
# Выборка всех страниц контента
function GetPages($dir = null)
{
	$path = dirname(__FILE__) . "/../content/$dir";
	$pages = array();

	# Парсим папку content
	$handle = opendir($path);

	# Выбираем массив страниц
	if ($handle != false)
	{
		while (($file = readdir($handle)) !== false)
		{
			if (is_file($path . $file))
			{
				$i = strtok($file, '.');
				$pages[$i] = $file;
			}
		}

		closedir($handle);
	}

	# Сортируем массив
	natsort($pages);

	return $pages;
}
# Выборка всех подпапок
function GetDirs($dir = null)
{
	$path = dirname(__FILE__) . '/../content/';
	$dirs = array();

	# Парсим папку content
	$handle = opendir($path);

	# Выбираем массив страниц
	if ($handle != false)
	{
		while (($dir = readdir($handle)) !== false)
			if (is_dir($path . $dir) && $dir != '..' && $dir != '.')
				$dirs[] = $dir;

		closedir($handle);
	}

	# Сортируем массив
	natsort($dirs);

	return $dirs;
}
# Выбор текста из EOF
function GetContentFromEOF($text)
{
	preg_match('|EOF(.*)EOF;|Uisu', $text, $matches);

	return (isset($matches[1])) ? $matches[1] : '';
}
# Выбор параметров страницы
function GetContent($page, $var, $dir = '')
{
	$text = file_get_contents(dirname(__FILE__) . "/../content/$dir$page");
	preg_match('|\$'.$var.'[^\n]*\'([^\n]*)\';|Uisu', $text, $matches);
	return (isset($matches[1])) ? $matches[1] : '';
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
# Извлечение названий блоков
function GetBlocksNames()
{
	$text = file_get_contents(dirname(__FILE__) . '/../template/blocks.inc.php');
	preg_match_all('|\$([^\s]*)\s=\s<<<[^\s]*\n|Uisu', $text, $matches);
	return (isset($matches[1])) ? $matches[1] : 'error';
}
# Извлечение текста блоков
function GetBlockContent($block)
{
	$text = file_get_contents(dirname(__FILE__) . '/../template/blocks.inc.php');
	preg_match('|<<<'. $block.'(.*)'. $block.';\n|Uisu', $text, $matches);
	return (isset($matches[1])) ? trim($matches[1]) : 'error';
}
# Извлечение блока скриптов
function GetScript($page)
{
	$text = file_get_contents(dirname(__FILE__) . "/../content/$page");
	preg_match('|#script start(.*)#script end|Uisu', $text, $matches);
	return (isset($matches[1])) ? $matches[1] : '';
}
# Извлечение значения переменной в конфиге
function GetConfig($text, $var)
{		
	preg_match('|\$'.$var.'[\s]*=\s\'*?([^\n]*)\'?;\s#|Uisu', $text, $matches);
	
	return (isset($matches[1])) ? $matches[1] : '';
}
# Определение значений переменных конфига
function SetConfig($path, $file, $var_name, $var)
{	
	preg_match('|(\$'.$var_name.'[\s]*=\s\'*?)[^\n]*(\'*?;\s#)|Uisu', $file, $matches);

	$repl = $matches[1] . $var . $matches[2];
	
	return preg_replace('|\$'.$var_name.'[\s]*=\s\'*?([^\n]*)\'?;\s#|Uisu', $repl, $file);	
}
# Сохранение файла конфигов
function SaveConfig($file, $content)
{
	return (file_put_contents($file . '../config.inc.php', stripslashes(trim($content))));
}

# Работа с многоуровневым меню
function MenuHandling($menu_items, $action='get', $new_menus='', $new_menu_block='')
{	
	$menu = '';		
	$s=1;
	$k=0;
	$sort = 0;
	$level = array();
	$tmp_item[$k] = (isset($menu_items)) ? array_values($menu_items) : '';
	while (isset($tmp_item[$k]))
	{
		if (isset($new_menus[$k])){
			$add = 0;
			foreach($new_menus[$k]['offset'] as $i => $new_menu)
			{
				if (!empty($new_menus[$k][0][$i]))
				{
					if(isset($tmp_item[$k][$new_menu + $add]))
					{
						array_splice($tmp_item[$k], $new_menu + $add, 0, $new_menus[$k][0][$i]);
						$tmp_item[$k][$new_menu + $add] = array();
						$tmp_item[$k][$new_menu + $add][0] = $new_menus[$k][0][$i];
						$tmp_item[$k][$new_menu + $add][1] = $new_menus[$k][1][$i];
						$tmp_item[$k][$new_menu + $add][2] = $new_menus[$k][2][$i];

						$add++;
					}
					else
					{
						$tmp_item[$k][$new_menu + $add] = array();
						$tmp_item[$k][$new_menu + $add][0] = $new_menus[$k][0][$i];
						$tmp_item[$k][$new_menu + $add][1] = $new_menus[$k][1][$i];
						$tmp_item[$k][$new_menu + $add][2] = $new_menus[$k][2][$i];

						$add++;
					}
				}
			}
			unset($new_menus[$k]);
		}
		foreach ($tmp_item[$k] as $j => $item){											
			if (!empty($item[0])) {								
				if (isset($new_menu_block[$k]) && isset($new_menu_block[$k][$j])){

					foreach ($new_menu_block[$k][$j][0] as $i => $new_menu) {					
						if (!empty($new_menu_block[$k][$j][0][$i])) {

							$item[3][$i][0] = $new_menu_block[$k][$j][0][$i];
							$item[3][$i][1] = $new_menu_block[$k][$j][1][$i];
							$item[3][$i][2] = $new_menu_block[$k][$j][2][$i];
							$tmp_item[$k][$j] = $item;							
						}
					}
				}
							
				#массив итераций
				$temp_parent[$sort] = $k;
				#массив уровней 1
				if (!isset($lvl[$k])) $lvl[$k] = 0;
				#массив с элементами субменю для следующих итераций
				if (isset($item[3]) && is_array($item[3])){					
					$tmp_item[$s] = $item[3];
					$lvl[$s] = $lvl[$k]+1;					
				}
				#массив уровней 2
				$level[$sort] = $lvl[$k];
				#определение предка элемента
				$parent[$s]	= (isset($tmp_item[$s])) ? $sort : 0;
				#сборка индексов
				if (!isset($parent[$k]))
					$index_pre[$sort] = '[' . $j . ']';
				elseif
					($j == 0) $index_pre[$sort] = $index_pre[$parent[$k]] . $index[$parent[$k]] . '[3]';
				else
					$index_pre[$sort] = $index_pre[$sort - 1];					
				$index[$sort] = ($k == 0) ? '' : '[' . $j . ']';					
				$temp_index[$sort] = $j;
				#временный масив с пунктами меню
				$temp_menu_item[$sort] = $item;
				#инкремент индекса массива итераций
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
		}		
		$k++;
	}	
	$op = array();	
	#GET
	if ($action == 'get') {	
		foreach($sort1 as $i => $key)
		{
			$style = (is_int($level[$sort1[$i]] / 2)) ? 'style="background-color:white;"' : '';
			
			if ($i > 0 && $temp_parent[$sort1[$i]] > $temp_parent[$sort1[$i - 1]])
			{
				$menu .= '<div class="row" ' . $style . '>';
				$op[] = $key;
			}			

			$menu .= '<div class="form-group"><a class="add_inputs btn btn-warning" href="#" onclick="return moreInputs(' . $temp_parent[$sort1[$i]] . ', ' . $temp_index[$sort1[$i]] . ', (this))">Добавить ещё пункт</a></div>';
						
			$tmp_index = $index_pre[$key] . $index[$key];

			$style = (empty($style)) ? 'style="background-color:white;"' : '';
			$menu .= '
			<div class="row"' . $style . '>
				<div class="col-md-2 form-group">	
					<input type="text" name="menu' . $tmp_index . '[0]" class="form-control" value="' . $temp_menu_item[$key][0] . '" />
				</div>
				<div class="col-md-3 form-group">
					<input type="text" name="menu' . $tmp_index . '[1]" class="form-control" value="' . $temp_menu_item[$key][1] . '" />
				</div>
				<div class="col-md-3 form-group">
					<input type="text" name="menu' . $tmp_index . '[2]" class="form-control" value="' . $temp_menu_item[$key][2] . '" />
				</div>
				<div class="col-md-1 form-group">
					<a href="#" title="Удалить пункт меню" onclick="return deleteInputs(this);" class="btn btn-danger"><i class="fas fa-times"></i></a>
				</div>
			';
			$menu .= (isset($temp_menu_item[$key][3])) ? '' : 
			'<div class="col-md-3 form-group"><a class="add_blocks btn btn-info" href="#" onclick="return moreBlocks(' . $temp_parent[$sort1[$i]] . ', ' . $temp_index[$sort1[$i]] . ', (this))">Добавить дочернее меню</a></div></div>';
			if (!isset($temp_menu_item[$key][3]))
			{
				$j = $level[$sort1[$i]];
				$k = (isset($sort1[$i + 1])) ? $sort1[$i + 1] : 0;
				$c = count($op);
				while ($j > $level[$k] || ($c > 0 && $i == count($sort1[$i]) - 1))
				{
					$last = $c - 1;
					$menu .= '<div class="form-group"><a class="add_inputs btn btn-warning" href="#" onclick="return moreInputs(' . $temp_parent[$op[$last]] . ', ' . count($tmp_item[$temp_parent[$op[$last]]]) . ', (this))">Добавить ещё пункт</a></div>';
					$menu .= '</div>';

					$j--;
					$c--;
					array_pop($op);
				}
			}
			
		}
		$menu .= '<div class="form-group"><a class="add_inputs btn btn-warning" href="#" onclick="return moreInputs(0, ' . count($tmp_item[0]) . ', (this))">Добавить ещё пункт</a></div>';
	}
	#SET
	else {	
	$menu .= 'array (';
		foreach ($sort1 as $i => $key)
		{			
			if ($key > 0 && $temp_parent[$key]>0 && $temp_parent[$sort1[$i]]>$temp_parent[$sort1[$i - 1]])
			{
				$menu .= 'array (';
				$op[] = $i - 1;				
			}
			$coma = ($temp_index[$key] == count($tmp_item[$temp_parent[$key]]) - 1) ? '' : ',';
			$tmp_index = $index_pre[$key] . $index[$key];
			$menu .= "
			array ('{$temp_menu_item[$key][0]}', '{$temp_menu_item[$key][1]}', '{$temp_menu_item[$key][2]}'";
			if (isset($temp_menu_item[$key][3]))
			{
				$menu .= ', ';
			}
			else
			{
				$menu .= "){$coma}";
			}
			if (!isset($temp_menu_item[$key][3]))
			{
				$j = $level[$sort1[$i]];
				$k = (isset($sort1[$i + 1])) ? $sort1[$i + 1] : 0;
				$c = count($op);
				while ($j > $level[$k] || ($c > 0 && $i == count($sort1[$i]) - 1))
				{	
					$last = $c - 1;
					$menu .= ((isset($op[$last]) && $temp_index[$sort1[$op[$last]]] == count($tmp_item[$temp_parent[$sort1[$op[$last]]]])) || $i== count($sort1) - 1) ? ")\n)" : ")\n),";
					
					$j--;
					$c--;
					array_pop($op);
				}
			}
		}
	$menu .= "\n);";
	}

	return $menu;
}

// Функция очищает заданную директорию от файлов
function CleanDir($folder)
{
	$handle = opendir($folder);
	// Удаляем все файлы
	if ($handle != false)
	{
		while (($file = readdir($handle)) !== false)
		{
			if ($file != '..' && $file != '.')
			{
				unlink($folder . '/' . $file);
			}
		}

		closedir($handle);
	}
	return true;
}


# Дополнительные модули

# Транслитерация с русского на латинницу
function rus2lat($string) {
    $converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'jo',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'j',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'shh',
        'ь' => '\'',  'ы' => 'y',   'ъ' => 'q',
        'э' => 'e`',   'ю' => 'ju',  'я' => 'ja',
        
        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'JO',   'Ж' => 'ZH',  'З' => 'Z',
        'И' => 'I',   'Й' => 'J',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'CH',  'Ш' => 'SH',  'Щ' => 'SHH',
        'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => 'Q',
        'Э' => 'E`',   'Ю' => 'JU',  'Я' => 'JA',
    );
    return strtr($string, $converter);
}
function str2url($str) {
    # переводим в транслит
    $str = rus2lat($str);
    # в нижний регистр
    $str = strtolower($str);
    # заменям все ненужное нам на "-"
    $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
    # удаляем начальные и конечные '-'
    $str = trim($str, "-");
    return $str;
}

# Транслитерация с латинницы на русский
function lat2rus($string) {
    $converter = array(
        'а' => 'a',   'b' => 'б',   'v' => 'в',
        'g' => 'г',   'd' => 'д',   'e' => 'е',
        'jo' => 'ё',   'zh' => 'ж',  'z' => 'з',
        'i' => 'и',   'j' => 'й',   'k' => 'к',
        'l' => 'л',   'm' => 'м',   'n' => 'н',
        'o' => 'о',   'p' => 'п',   'r' => 'р',
        's' => 'с',   't' => 'т',   'u' => 'у',
        'f' => 'ф',   'h' => 'х',   'c' => 'ц',
        'ch' => 'ч',  'sh' => 'ш',  'shh' => 'щ',
        '\'' => 'ь',  'y' => 'ы',   'q' => 'ъ',
        'e`' => 'э',   'ju' => 'ю',  'ja' => 'я',
        '_' => ' ', '/' => '',

        'A' => 'А',   'B' => 'Б',   'V' => 'В',
        'G' => 'Г',   'D' => 'Д',   'E' => 'Е',
        'JO' => 'Ё',   'ZH' => 'Ж',  'Z' => 'З',
        'I' => 'И',   'J' => 'Й',   'K' => 'К',
        'L' => 'Л',   'M' => 'М',   'N' => 'Н',
        'O' => 'О',   'P' => 'П',   'R' => 'Р',
        'S' => 'С',   'T' => 'Т',   'U' => 'У',
        'F' => 'Ф',   'H' => 'Х',   'C' => 'Ц',
        'CH' => 'Ч',  'SH' => 'Ш',  'SHH' => 'Щ',
        'Y' => 'Ы',   'Q' => 'Ъ',
        'E`' => 'Э',   'JU' => 'Ю',  'JA' => 'Я',
    );
    return strtr($string, $converter);
}
function url2str($str) {
    # переводим в транслит
    $str = lat2rus($str);
    return $str;
}