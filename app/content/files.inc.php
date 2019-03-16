<?php

# Данные о странице
$title = 'Файловая структура microText';
$keywords = '';
$description = '';
$template = 'info';
$page_blocks = 'reviews, donate';

# Содержание страницы
$content = <<<EOF
<p>Все страницы хранятся в папке <strong>сontent/</strong>, а дизайн в папке <strong>template/</strong>. Изображения предполагается хранить в папке <strong>i/</strong>.</p>

<p>Если хочется добавить функции, то дописывайте их в <strong>func.inc.php</strong>. А также можно добавлять настройки в <strong>config.inc.php</strong>.</p>

<p>И конечно важнейшие файлы: основной индексный файл <strong>index.php</strong> и специальный файл для конфигурации сервера <strong>.htaccess</strong>.</p>

<h2>Файлы дистрибутива</h2>

<pre>
<code>
<strong>admin</strong>/ # папка с файлами админки
<strong>content</strong>/index.inc.php	# файлы контента
<strong>content</strong>/install.inc.php
<strong>content</strong>/config.inc.php
<strong>content/folder</strong>/file.inc.php # также могут быть папки разделов с файлами контента
...
<strong>i</strong>/ # папка с изображениямм
<strong>js</strong>/ # папка со скриптами
<strong>files</strong>/	# папка с файлами
<strong>template</strong>/blocks.inc.php # все контентные блоки сайта
<strong>template</strong>/design.inc.php # шаблон дизайна (может быть несколько)
<strong>template</strong>/menu.inc.php # все меню сайта
<strong>template/email</strong>/form.inc.php # форма обратной связи
<strong>template/email</strong>/feedback.inc.php # шаблон письма, приходящего при отправке формы
.htaccess # служебный файл
config.inc.php # файл конфигурации
func.inc.php # библиотека функций
index.php # главный файл
</code>
</pre>

<h2>Ограничение доступа</h2>

<p>Если вы хотите, чтобы файл был доступен в браузере напрямую, то давайте ему расширение <strong>*.php</strong>. Иначе <strong>*.inc.php</strong>.</p>
EOF;

$highlight_enabled = true;