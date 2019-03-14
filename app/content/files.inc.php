<?php

# Данные о странице
$title = 'Файловая структура microText';
$keywords = '';
$description = '';
$template = 'info';
$page_blocks = 'reviews, donate';

# Содержание страницы
$content = <<<EOF
<p>Все страницы хранятся в папке <code>сontent/</code>, а дизайн в папке <code>template/</code>. Изображения предполагается хранить в папке <code>img/</code>.</p>

<p>Если хочется добавить функции, то дописывайте их в <code>func.inc.php</code>. А также можно добавлять настройки в <code>config.inc.php</code>.</p>

<p>И конечно важнейшие файлы: основной индексный файл <code>index.php</code> и специальный файл для конфигурации сервера <code>.htaccess</code>.</p>

<h2>Файлы дистрибутива</h2>

<pre>
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
</pre>

<h2>Ограничение доступа</h2>

<p>Если вы хотите, чтобы файл был доступен в браузере напрямую, то давайте ему расширение <code>*.php</code>. Иначе <code>*.inc.php</code>.</p>
EOF;

$highlight_enabled = true;