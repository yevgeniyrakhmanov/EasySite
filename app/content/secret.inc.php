<?php

# Данные о странице
$title = 'Секретная страница на движке microText';
$keywords = 'ключевые слова';
$description = 'Описание страницы';
$template = 'info';
$page_blocks = 'reviews, donate';

# Содержание страницы
$content = <<<EOF
<p>Страница с ограниченным доступом на базе движка microText. Авторизация реализована на основе самого простого и надёжного метода – HTTP авторизации.</p>

<p>Проверка доступа происходит на сервере. Эта функция должна быть включена.</p>

<h2>Настройка доступа</h2>

<p>Если хотите задать логин и пароль из конфига, то добавьте в <strong>config.inc.php</strong>:</p>

<pre>
<code class="php">
# Настройки доступа
\$config['access_login'] = 'demo';
\$config['access_password'] = 'demo';
</code>
</pre>

<p>В самое начало страницы (например, <strong>content/secret.inc.php</strong>) сразу после <strong>	&lt;?php</strong> нужно добавить код:</p>

<pre>
<code class="php">
# Ограничение доступа
if (!CheckLogin(\$config['access_login'], \$config['access_password']))
	die('Доступ запрещён.');
</code>
</pre>

<p>Если хотите задать отдельный логин/пароль для страницы, пропишите их в параметрах функции.</p>

<h2>Пример закрытой страницы</h2>

<p>Зайдите <a href="{$config['sitelink']}secret/auth.html" title="Не забудьте ввести пароль :)">сюда</a>. Для доступа введите логин/пароль: demo/demo.</p>
EOF;

$highlight_enabled = true;