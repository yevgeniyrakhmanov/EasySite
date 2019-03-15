<?php
$url= str_replace($config['sitelink'].'admin/','',strtolower (strtok($_SERVER['SERVER_PROTOCOL'],'/')).'://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="ru">
	<head>
	    <meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <title><?=$title?></title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<div class="navbar navbar-expand-lg navbar-dark bg-dark">
			<div class="container">
				<a class="navbar-brand d-flex align-items-center" href="<?=$config['sitelink']?>/admin">
					<img src="<?=$config['sitelink']?>img/logo/logo-small.png" alt="microText">
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
					<ul class="navbar-nav">
						<li class="nav-item <?=($url=='index.php')?'active':''?>">
							<a class="nav-link" href="<?=$config['sitelink'] . 'admin/'?>" title="Управление страницами">Страницы</a></li>
						<li class="nav-item <?=($url=='menu.php')?'active':''?>">
							<a class="nav-link" href="<?=$config['sitelink'] . 'admin/menu.php'?>" title="Управление меню">Меню</a>
						</li>
						<li class="nav-item <?=($url=='block.php')?'active':''?>">
							<a class="nav-link" href="<?=$config['sitelink'] . 'admin/block.php'?>" title="Управление блоками">Блоки</a>
						</li>
						<li class="nav-item <?=($url=='settings.php')?'active':''?>">
							<a class="nav-link" href="<?=$config['sitelink'] . 'admin/settings.php'?>" title="Управление блоками">Настройки</a>
						</li>
						<li class="nav-item dropdown <?=($url=='help.php')?'active':''?>">
							<a class="nav-link dropdown-toggle" href="<?=$config['sitelink'] . 'admin/help.php?help=install'?>" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Управление блоками">
								Справка
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="<?=$config['sitelink'] . 'admin/help.php?help=install'?>">Установка</a>
								<a class="dropdown-item" href="<?=$config['sitelink'] . 'admin/help.php?help=config'?>">Настройка</a>
								<a class="dropdown-item" href="<?=$config['sitelink'] . 'admin/help.php?help=content'?>">Наполнение</a>
								<a class="dropdown-item" href="<?=$config['sitelink'] . 'admin/help.php?help=secret'?>">Ограничение доступа</a>
							</div>
						</li>
					</ul>
					<ul class="navbar-nav mr-0 ml-auto">
						<li class="nav-item">
							<a class="nav-link" href="<?=$config['sitelink']?>" target="_blank">Фронтенд</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="logout.php" onclick="return confirm('Вы действительно хотите выйти?')">Выйти</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="container">
			<h1 class="text-center mt-3 mb-3"><?=$title?></h1>
			<?=$content?>
		</div>
		<hr class="mt-5">
		<div class="container">
			<p class="text-right"><a href="http://microText.pp.ua" title="Суперлёгкий движок для сайтов microText">microText</a> @ <a href="http://sitestroy.com" title="Удобные решения для интернет бизнеса">sitestroy.com</a>, <?=date('Y')?>.</p>
		</div>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<script>
			var pass = $('#password-show');
			$('button.show-password').click(function() {
				pass.attr('type', pass.attr('type') === 'password' ? 'text' : 'password');
			});
		</script>
	</body>
</html>