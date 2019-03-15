<? if ($_GET['help'] == 'install')
{
$title = 'Установка microText';

# Содержание страницы
$content		= <<<EOF
<div class="alert alert-secondary">
<p>Установить этот движок не просто, а очень просто. Несмотря на то, что нет ни инсталлятора, ни баз данных, ни админки.</p>
<h2>Полный процесс установки</h2>
<ol>
<li>1. <a href="http://microtext.info/download.html" title="Скачайте прямо сейчас, если ещё не сделали этого">Скачать дистрибутив</a> с данного сайта и распаковать.</li>
<li>2. Закачать файлы дистрибутива на сервер в папку установки.</li>
<li>3. Прописать в <code>config.inc.php</code> адрес главной страницы. Со слэшем на конце.</li>
<li>4. Прописать в <code>.htaccess</code> путь от корня сайта до папки, в которой он лежит. По умолчанию стоит <code>RewriteBase /</code>, то есть, предполагается, что движок будет ложиться в корень. Если бросаете движок в папку <code>test/</code>, то прописать следует <code>RewriteBase /test/</code>.</li>
</ol>
<p>Далее следует приступить к детальной <a href="{$config['sitelink']}/admin/help.php?help=config" title="Настройка скрипта">настройке</a>.</p>
<h2>Видео</h2>
<p>Смотрим на установку в реал-тайме.</p>
<p class="t-center">
<iframe width="640" height="360" src="http://www.youtube.com/embed/B7JAdg-w3sE?rel=0" frameborder="0" allowfullscreen></iframe>
</p>
</div>
EOF;
}

elseif ($_GET['help'] == 'config')
{
# Данные о странице
$title = 'Детальная настройка microText';

# Содержание страницы
$content = '
<div class="alert alert-secondary">
<p>На третьем шаге установки, вы уже прописали в файле <code>config.inc.php</code> адрес главной страницы сайта. Поздравляю. Вы сделали уже довольно большой кусок работы.</p>

<h2>Настройка вывода меню</h2>

<p>Нужно открыть файл <code>menu.inc.php</code> (находится в папке <code>template/</code>) и прописать нужные элементы меню в виде массивов.</p>
<p>Менюшек может быть сколько угодно. Не забудьте вставить переменную в шаблон дизайна.</p>

<h2>Натягиваем шаблон на движок</h2>

<p>Весь дизайн прописан в файле <code>design.inc.php</code> (также находится в папке <code>template/</code>). Просто замените дефолтный шаблон своим и поставьте на место основные переменные (<code>$config[\'sitelink\']</code> и <code>$config[\'sitename\']</code>), меню (пример, <code>GetMenuItems($this_page, $mainmenu)</code>) и дополнительные блоки.</p>
<p>Оформление меню можно изменить в файле <code>func.inc.php</code> (находится в корне). Смотрите функцию <code>GetMenuItems()</code>. По умолчанию ссылка активной страницы выделяется классом <code>selected</code>.</p>

<h2>Вставляем дополнительные блоки</h2>

<p>Открываем файл <code>blocks.inc.php</code> (также в папке <code>template/</code>) и добавляем содержимое переменных.Не забудьте вставить переменные в дизайн.</p>
<p>Можно приступать к <a href="' . $config['sitelink'] . 'admin/help.php?help=content" title="Наполнение сайта контентом">наполнению</a>.</p>
</div>
';
}
elseif ($_GET['help'] == 'content')
{
# Данные о странице
$title			= 'Наполнение сайта контентом';

# Содержание страницы
$content		= '
<link rel="stylesheet" href="http://yandex.st/highlightjs/7.3/styles/default.min.css">
<script src="http://yandex.st/highlightjs/7.3/highlight.min.js"></script>
<script>hljs.initHighlightingOnLoad();</script>

<div class="alert alert-secondary">
<p>Все данные сайта лежат в папке <code>content/</code>.</p>

<h2>Добавление страниц</h2>

<p>Добавить новые страницы очень просто. Сделайте копию любой страницы и замените содержимое переменных. Основные переменные страницы:</p>

<pre>
<code class="php">
$title = \'Заголовок\';
$keywords = \'ключевые слова\';
$description = \'Описание страницы\';
$template = \'info\';
$page_blocks = \'reviews, donate\';
$content = \'Тут контент страницы\';
</code>
</pre>

<p>Хотя переменными <code>$keywords</code> и <code>$description</code> можно смело пожертвовать.</p>

<p>В переменной <code>$content</code> нужно помещать содержание страницы уже в формате HTML.</p>

<p>Имя <code>*.inc.php</code> файла страницы – это адрес html страницы в браузере.</p>

<h2>Особенности наполнения</h2>

<p>Можете добавлять переменные. Только не забудьте их вывести в дизайн или где-нибудь использовать.</p>

<p>Можете наполнять переменные постепенно. Например, так.</p>

<pre>
<code class="php">
$content  = \'содержимое\';
$content .= "содержимое";
</code>
</pre>

<p>Переменные, заданные на контентной странице, могут участвовать в формировании блоков или меню, а не только контента. А также всячески влиять на отображение сайта. Используйте это.</p>

<p><strong>Внимание!</strong> Не забывайте экранировать одинарные кавычки (\') с помощью слэшей (\). Если таковых много, можете брать содержимое в двойные кавычки. Или наполнять переменные частями (в двойных и одинарных кавычках). Пример можете наблюдать чуть выше.</p>

<h2>Вывод переменных в контенте</h2>

<p>Если выводите в одинарных кавычках:</p>

<pre>
<code class="php">
$content = \'содержимое \' . $title . \' содержимое\';
</code>
</pre>

<p>Если в двойных:</p>

<pre>
<code class="php">
$content = "содержимое $title содержимое";
</code>
</pre>
</div>
';
}
elseif ($_GET['help'] == 'secret')
{
# Данные о странице
$title = 'Секретная страница на движке microText';

# Содержание страницы
$content = '

<link rel="stylesheet" href="http://yandex.st/highlightjs/7.3/styles/default.min.css">
<script src="http://yandex.st/highlightjs/7.3/highlight.min.js"></script>
<script>hljs.initHighlightingOnLoad();</script>

<div class="alert alert-secondary">
<p>Страница с ограниченным доступом на базе движка microText. Авторизация реализована на основе самого простого и надёжного метода – HTTP авторизации.</p>
<p>Проверка доступа происходит на сервере. Эта функция должна быть включена.</p>

<h2>Настройка доступа</h2>

<p>Если хотите задать логин и пароль из конфига, то добавьте в <code>config.inc.php</code>:</p>

<pre>
<code class="php">
# Настройки доступа
$config[\'access_login\'] = \'demo\';
$config[\'access_password\'] = \'demo\';
</code>
</pre>

<p>В самое начало страницы (например, <code>content/secret.inc.php</code>) сразу после <code>&lt;?php</code> нужно добавить код:</p>

<pre>
<code class="php">
# Ограничение доступа
if (!CheckLogin($config[\'access_login\'], $config[\'access_password\']))
	die(\'Доступ запрещён.\');
</code>
</pre>

<p>Если хотите задать отдельный логин/пароль для страницы, пропишите их в параметрах функции.</p>

<h2>Пример закрытой страницы</h2>

<p>Зайдите <a href="' . $config['sitelink'] . 'secret/auth.html" title="Не забудьте ввести пароль :)">сюда</a>. Для доступа введите логин/пароль: demo/demo.</p>
</div>
';
}