<?php

# HTML редактор BUEditor: http://drupal.org/project/bueditor
# Встраивается в ЛЮБУЮ страницу ЛЮБОГО сайта
# Оформление и доработка редактора: http://neverlex.com
# Скачать последнюю версию: http://microtext.info/download/bueditor.zip

# Необходимые настройки

  $site		= $config['sitelink']; # Реальный урл морды сайта
  $bueditor = 'admin/bueditor'; # Папка редактора BUEditor. Относительный адрес от корня
  $ifolder	= 'img'; # Папка для загрузки изображений. Относительный адрес от корня
  $ffolder	= 'files'; # Папка для загрузки файлов. Относительный адрес от корня
  $tmp		= 'admin/tmp'; # Папка временных файлов. Нужна для функции загрузки файлов на сервер. Относительный адрес от корня
  $isize	= '2097152'; # Максимальный размер изображения в байтах
  $fsize	= '2097152'; # Максимальный размер файла в байтах

# Далее следует изменять только функции кнопок

  $way = $site . $bueditor;
  
  $bueditor = <<<EOF
  
	<style type="text/css" media="all">@import "$way/bueditor.css";</style>
    <script type="text/javascript" src="$way/bueditor.js"></script>
    <script type="text/javascript" src="$way/library/default_buttons_functions.js"></script>
    <script type="text/javascript">
           editor.path="$way/"
           editor.buttons=[

  ['Жирный','<strong>%TEXT%</strong>','b.svg','B'],
  ['Курсив','<em>%TEXT%</em>','i.svg','I'],
  ['Подчёркнутый','<u>%TEXT%</u>','u.svg','U'],
  ['Зачёркнутый','<span class="s">%TEXT%</span>','s.svg','S'],
  ['Ссылка','<a href="" title="">%TEXT%</a>', 'link.svg', 'L'],
  ['Сcылка с nofollow','<a href="" title="" rel="nofollow">%TEXT%</a>','link_nofollow.svg',''],
  ['Изображение','<img src="" alt="">','picture_link.svg',''],
  ['Аплоад картинки','js: eDefUp("$way/up.php")','picture_up.svg',''],
  ['Аплоад файла','js: eDefUp2("$way/up2.php")','attach.svg',''],
  ['Параграф','<p>%TEXT%</p>','p.svg',''],
  ['Перенос строки','<br>','br.svg',''],
  ['Заголовок H2','<h2>%TEXT%</h2>','h2.svg',''],
  ['Нумерованный список','js: eDefSelProcessLines(\'<ol>\\\\n\',\'<li>\',\'</li>\',\'\\\\n</ol>\');','ol.svg',''],
  ['Ненумерованный список','js: eDefSelProcessLines(\'<ul>\\\\n\',\'<li>\',\'</li>\',\'\\\\n</ul>\');','ul.svg',''],
  ['Элемент списка','js: eDefSelProcessLines(\'\',\'<li>\',\'</li>\',\'\');','li.svg',''],
  ['По левому краю','<div class="t-left">%TEXT%</div>','text_align_left.svg',''],
  ['По центру','<div class="t-center">%TEXT%</div>','text_align_center.svg',''],
  ['По правому краю','<div class="t-right">%TEXT%</div>','text_align_right.svg',''],
  ['По ширине','<div class="t-justify">%TEXT%</div>','text_align_justify.svg',''],
  ['Горизонтальная линия','<hr>','hr.svg',''],
  ['Свой span','<span class="class_name">%TEXT%</span>','class.svg',''],
  ['Свой div','<div class="class_name">%TEXT%</div>','class_red.svg',''],
  ['Кавычки ёлочки','«%TEXT%»','noindex.svg',''],
  ['Граница анонса','<!--more-->','more.svg',''],
  ['Предпросмотр','js: eDefPreview();','preview.svg','P'],
  ['Помощь','js: eDefHelp();','h.svg','H']

              ];</script>
  
EOF;

?>