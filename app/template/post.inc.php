
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="<?=$config['encoding']?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?=$title?></title>
		<meta name="keywords" content="<?=$keywords?>">
		<meta name="description" content="<?=$description?>">
		<link rel="stylesheet" href="<?=$config['sitelink']?>css/main.min.css">
	</head>
	<body>
		<header class="navbar navbar-expand-lg navbar-light bg-light">
			<a class="navbar-brand d-flex align-items-center" href="<?=$config['sitelink']?>">
				<img src="<?=$config['sitelink']?>img/logo/logo-small.png" alt="microText">
				<div class="d-none d-md-block ml-3">
					<div><?=$config['sitename']?></div>
					<div class="text-muted small"><?=$config['slogan']?></div>
				</div>
				
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<nav class="collapse navbar-collapse" id="navbarTogglerDemo01">
				<ul class="navbar-nav mr-0 ml-auto">
					<?=GetMenuItems($this_page, $mainmenu, $category)?>
				</ul>
			</nav>
		</header>
		<div class="container-fluid">
			<div class="row">
				<article class="col-lg-8 mt-3">
					<?php
						if(isset($category)){
							echo '<p class="text-muted small mb-0 mt-3">' . $category . '</p>';
						}
					?>
					<h1><?=$title;?></h1>
					<?php
						if(isset($date)){
							echo '<p class="text-muted small">' . $date . '</p>';
						}
					?>
					<?=$content;?>
				</article>
				<aside class="col-lg-4 mt-3 sticky-top">
					<?=$sidebar_nav?>
					<?=GetBlock($page_blocks, 'reviews', $reviews )?>
					<?=GetBlock($page_blocks, 'donate', $donate )?>
				</aside>
			</div>
		</div>
		<footer class="navbar navbar-expand-lg navbar-light bg-light">
			<div class="mr-0 ml-auto">
				<a href="http://microText.pp.ua" title="Суперлёгкий движок для сайтов microText">microText</a> © <a href="http://sitestroy.com" title="SITESTROY.COM - Удобные решения для онлайн бизнеса">sitestroy.com</a>, <?=date('Y')?>.
			</div>
		</footer>
		<script src="<?=$config['sitelink']?>js/scripts.min.js"></script>
	</body>
</html>