<?php
# Дополнительные блоки данных
# Добавляйте сколько угодно. Не забудьте вставить переменную в design.inc.php или на страницу в папке content/

$reviews = <<<reviews
<h3>Отзывы</h3>
<div class="well well-small">
<p>CMS действительно проста и понятна. Быстро разворачивается и так же шустро работает, что меня особо радует...</p>
<p class="pagination-right"><em>Александр Адамович, предприниматель</em></p>
<p>Крайне простой двиг) То, что нужно для тех, кому не надо запариваться!</p>
<p class="pagination-right"><em>Андрей Гурылёв (дизайнер)</em></p>
<p>Я протестировал microText у себя на хостинге и был просто в восторге от невероятной скорости загрузки сайта!</p>
<p class="pagination-right"><em>Сергей (веб-мастер, автор bloginru.ru)</em></p>
<p>Этот движок должен стать must have для каждого вебмастера! (:</p>
<p class="pagination-right"><em>Проходимец (блоггер, автор npoxodumetc.com)</em></p>
<br />
<h4 class="pagination-centered"><a title="Читать другие отзывы пользователей" href="http://microtext.info/reviews.html">Читать больше отзывов!</a></h4>
</div>
<!--/well -->
reviews;
$donate = <<<donate
<h3>Поддержка производителя</h3>
<div class="well well-small">
<p>microText бесплатен и разрабатывается на добровольных началах. Будем рады, если вы захотите поддержать проект. Спасибо заранее.</p>
<p>Перечислите любую сумму на представленные ниже кошельки:</p>
<p>WM: Z593240971916, R979929899568, U666249758398</p>
<p>ЯД: 41001349642337</p>
</div>
<!--/well -->
donate;
$sidebar_nav = <<<sidebar_nav
<div class="well"><nav class="sidebar-nav">
<ul class="nav nav-list">{$get_menu_items_u($this_page, $sidemenu)}</ul>
</nav></div>
<!--/well -->
sidebar_nav;
