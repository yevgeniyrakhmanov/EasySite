<?php

# Данные о странице
$title = 'Подключение шаблона к microText';
$keywords = '';
$description = '';
$template = 'info';
$page_blocks = 'reviews, donate';

# Содержание страницы
$content = <<<EOF
<p>К движку microText можно очень просто и быстро подключить любой шаблон HTML+CSS. Все шаблоны дизайна лежат в папке <strong>template/</strong></p>

<h2>Основные шаблоны</h2>
<ul class="ul">
<li><strong>template/design.inc.php</strong> – основной файл дизайна.</li>
<li><strong>template/menu.inc.php</strong> – файл, описывающий все <a href="http://microtext.info/menu.html" title="Описание менюшек microText">меню</a> на сайте.</li>
<li><strong>template/blocks.inc.php</strong> – файл для дополнительных <a href="http://microtext.info/blocks.html" title="Дополнительные блоки microText">блоков</a>.</li>
</ul>

<h2>Пошаговая установка шаблона</h2>

<p>1. Скопируйте HTML код страницы в файл <strong>template/design.inc.php</strong>. Обычная комбинация <strong>Ctrl+C → Ctrl+V</strong>!</p>
<p>2. Вставьте основные переменные из <strong>template/config.inc.php</strong> на их места. По умолчанию есть всего 2 переменные <strong>\$config['sitelink']</strong> (ссылка на главную) и <strong>\$config['sitename']</strong> (название сайта).</p>
<p>3. Также установите вывод меню с помощью функции <strong>GetMenuItems(\$this_page, \$mainmenu)</strong>, где <strong>\$mainmenu</strong> – массив нужного меню (задаётся в файле <strong>template/menu.inc.php</strong>).</p>
<p>4. Правьте оформление меню в функции <strong>GetMenuItems()</strong> в файле <strong>func.inc.php</strong>. Если нужно задать разным менюшках разное оформление, клонируйте функцию, измените оформление элемента меню и назовите функцию по другому. И конечно вставьте вывод в шаблон.</p>
EOF;
