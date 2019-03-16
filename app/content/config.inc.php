<?php

# Данные о странице
$title = 'Детальная настройка microText';
$keywords = 'ключевые слова';
$description = 'Описание страницы';
$template = 'info';
$page_blocks = 'reviews, donate';

# Содержание страницы
$content = <<<EOF
<p>На третьем шаге установки, вы уже прописали в файле <strong>config.inc.php</strong> адрес главной страницы сайта. Поздравляю. Вы сделали уже довольно большой кусок работы.</p>

<h2>Настройка вывода меню</h2>

<p>Нужно открыть файл <strong>menu.inc.php</strong> (находится в папке <strong>template/</strong>) и прописать нужные элементы меню в виде массивов.</p>

<p>Менюшек может быть сколько угодно. Не забудьте вставить переменную в шаблон дизайна.</p>

<h2>Натягиваем шаблон на движок</h2>

<p>Весь дизайн прописан в файле <strong>design.inc.php</strong> (также находится в папке <strong>template/</strong>). Просто замените дефолтный шаблон своим и поставьте на место основные переменные (<strong>\$config[sitelink]</strong> и <strong>\$config['sitename']</strong>), меню (пример, <strong>GetMenuItems(\$this_page, \$mainmenu)</strong>) и дополнительные блоки.</p>

<p>Оформление меню можно изменить в файле <strong>func.inc.php</strong> (находится в корне). Смотрите функцию <strong>GetMenuItems()</strong>. По умолчанию ссылка активной страницы выделяется классом <strong>selected</strong>.</p>

<h2>Вставляем дополнительные блоки</h2>

<p>Открываем файл <strong>blocks.inc.php</strong> (также в папке <strong>template/</strong>) и добавляем содержимое переменных.Не забудьте вставить переменные в дизайн.</p>

<p>Можно приступать к <a href="{$config['sitelink']}content.html" title="Наполнение сайта контентом">наполнению</a>.</p>
EOF;
