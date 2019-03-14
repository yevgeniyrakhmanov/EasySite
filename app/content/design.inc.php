<?php

# Данные о странице
$title = 'Подключение шаблона к microText';
$keywords = '';
$description = '';
$template = 'info';
$page_blocks = 'reviews, donate';

# Содержание страницы
$content = <<<EOF
<p>К движку microText можно очень просто и быстро подключить любой шаблон HTML+CSS. Все шаблоны дизайна лежат в папке <code>template/</code></p>

<h2>Основные шаблоны</h2>
<ul class="ul">
<li><code>template/design.inc.php</code> – основной файл дизайна.</li>
<li><code>template/menu.inc.php</code> – файл, описывающий все <a href="http://microtext.info/menu.html" title="Описание менюшек microText">меню</a> на сайте.</li>
<li><code>template/blocks.inc.php</code> – файл для дополнительных <a href="http://microtext.info/blocks.html" title="Дополнительные блоки microText">блоков</a>.</li>
</ul>

<h2>Пошаговая установка шаблона</h2>

<p>1. Скопируйте HTML код страницы в файл <code>template/design.inc.php</code>. Обычная комбинация <code>Ctrl+C → Ctrl+V</code>!</p>
<p>2. Вставьте основные переменные из <code>template/config.inc.php</code> на их места. По умолчанию есть всего 2 переменные <code>\$config['sitelink']</code> (ссылка на главную) и <code>\$config['sitename']</code> (название сайта).</p>
<p>3. Также установите вывод меню с помощью функции <code>GetMenuItems(\$this_page, \$mainmenu)</code>, где <code>\$mainmenu</code> – массив нужного меню (задаётся в файле <code>template/menu.inc.php</code>).</p>
<p>4. Правьте оформление меню в функции <code>GetMenuItems()</code> в файле <code>func.inc.php</code>. Если нужно задать разным менюшках разное оформление, клонируйте функцию, измените оформление элемента меню и назовите функцию по другому. И конечно вставьте вывод в шаблон.</p>
EOF;
