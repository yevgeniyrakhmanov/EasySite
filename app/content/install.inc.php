<?php

# Данные о странице
$title = 'Установка microText';
$keywords = 'ключевые слова';
$description = 'Описание страницы';
$template = 'info';
$page_blocks = 'reviews, donate';

# Содержание страницы
$content = <<<EOF
<p>Установить этот движок не просто, а очень просто. Несмотря на то, что нет ни инсталлятора, ни баз данных, ни админки.</p>
<h2>Полный процесс установки</h2>
<ol>
<li>1. <a href="{$config['sitelink']}download.html" title="Скачайте прямо сейчас, если ещё не сделали этого">Скачать дистрибутив</a> с данного сайта и распаковать.</li>
<li>2. Закачать файлы дистрибутива на сервер в папку установки.</li>
<li>3. Прописать в <strong>config.inc.php</strong> адрес главной страницы. Со слэшем на конце.</li>
<li>4. Прописать в <strong>.htaccess</strong> путь от корня сайта до папки, в которой он лежит. По умолчанию стоит <strong>RewriteBase /</strong>, то есть, предполагается, что движок будет ложиться в корень. Если бросаете движок в папку <strong>test/</strong>, то прописать следует <strong>RewriteBase /test/</strong>.</li>
</ol>
<p>Далее следует приступить к детальной <a href="{$config['sitelink']}config.html" title="Настройка скрипта">настройке</a>.</p>
<h2>Видео</h2>
<p>Смотрим на установку в реал-тайме.</p>
<p class="t-center">
<iframe width="640" height="360" src="http://www.youtube.com/embed/B7JAdg-w3sE?rel=0" frameborder="0" allowfullscreen></iframe>
</p>
EOF;
