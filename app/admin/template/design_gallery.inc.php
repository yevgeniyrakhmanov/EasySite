<?php
$url= str_replace($config['sitelink'].'admin/','',strtolower (strtok($_SERVER['SERVER_PROTOCOL'],'/')).'://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="ru">
	<head>
	    <meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <title><?=$title?></title>
		<link rel="stylesheet" href="<?=$config['sitelink']?>admin/css/bootstrap.css">
		<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet"> 
		<link rel="stylesheet" href="<?=$config['sitelink']?>admin/css/icons.css">
		<link rel="stylesheet" href="<?=$config['sitelink']?>admin/css/style.css">
		<script src="<?=$config['sitelink']?>admin/js/jquery.min.js"></script>
		<script src="<?=$config['sitelink']?>admin/js/popper.min.js"></script>
		<script src="<?=$config['sitelink']?>admin/js/bootstrap.min.js"></script>

<link href="<?=$config['sitelink']?>admin/css/uploadfile.css" rel="stylesheet">
<script src="<?=$config['sitelink']?>admin/js/uploadfile.js"></script>

	</head>
	<body>
		<div class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
			<div class="container">
				<a class="navbar-brand d-flex align-items-center" href="<?=$config['sitelink']?>/admin">
					<i class="fas fa-home"></i>
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
					<ul class="navbar-nav">
						<li class="nav-item <?=($url=='pages.php')?'active':''?>">
							<a class="nav-link" href="<?=$config['sitelink'] . 'admin/pages.php'?>" title="Управление страницами">Страницы</a>
						</li>
						<li class="nav-item <?=($url=='products.php')?'active':''?>">
							<a class="nav-link" href="<?=$config['sitelink'] . 'admin/products.php'?>" title="Управление товарами">Товары</a>
						</li>
						<li class="nav-item <?=($url=='posts.php')?'active':''?>">
							<a class="nav-link" href="<?=$config['sitelink'] . 'admin/posts.php'?>" title="Управление публикациями">Публикации</a>
						</li>
						<li class="nav-item <?=($url=='gallery.php')?'active':''?>">
							<a class="nav-link" href="<?=$config['sitelink'] . 'admin/gallery.php'?>" title="Управление галереей">Галерея</a>
						</li>
						<li class="nav-item <?=($url=='menu.php')?'active':''?>">
							<a class="nav-link" href="<?=$config['sitelink'] . 'admin/menu.php'?>" title="Управление меню">Меню</a>
						</li>
						<li class="nav-item <?=($url=='block.php')?'active':''?>">
							<a class="nav-link" href="<?=$config['sitelink'] . 'admin/block.php'?>" title="Управление блоками">Блоки</a>
						</li>
						<li class="nav-item <?=($url=='settings.php')?'active':''?>">
							<a class="nav-link" href="<?=$config['sitelink'] . 'admin/settings.php'?>" title="Управление настройками">Настройки</a>
						</li>
						<li class="nav-item dropdown <?=($url=='help.php')?'active':''?>">
							<a class="nav-link dropdown-toggle" href="<?=$config['sitelink'] . 'admin/help.php?help=install'?>" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Справка">
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
							<a class="nav-link" href="<?=$config['sitelink']?>" target="_blank">Фронт</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="logout.php" onclick="return confirm('Вы действительно хотите выйти?')">Выйти</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<h1 class="text-center mt-5 bg-info text-white">
			<div class="container pt-4 pb-2">
				<?=$title?>
			</div>
		</h1>
		<div class="container">
			<?=$content?>

<div id="fileuploader">Upload</div>
<script>
$("#fileuploader").uploadFile({
url: "uploader_upload.php",
dragDrop: true,
fileName: "myfile",
returnType: "json",
showDelete: true,
showDownload:false,
// statusBarWidth:600,
// dragdropWidth:600,
maxFileSize:5000*1024,
showPreview:true,
previewHeight: "auto",
previewWidth: "175px",

onLoad:function(obj)
   {
   	$.ajax({
	    	cache: false,
		    url: "uploader_load.php",
	    	dataType: "json",
		    success: function(data) 
		    {
			    for(var i=0;i<data.length;i++)
   	    	{ 
       			obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
       		}
	        }
		});
  },
deleteCallback: function (data, pd) {
    for (var i = 0; i < data.length; i++) {
        $.post("uploader_delete.php", {op: "delete",name: data[i]},
            function (resp,textStatus, jqXHR) {
                //Show Message	
                alert("Файл удален");
            });
    }
    pd.statusbar.hide(); //You choice.

},
}); 
</script>


		</div>
		<hr class="mt-5">
		<div class="container">
			<p class="text-center small"><a href="https://github.com/yevgeniyrakhmanov/EasySite" title="Суперлёгкий движок для сайтов microText">microText</a> @ Создал <a href="http://neverlex.com/" title="Алексей Опанасенко">Алексей Опанасенко</a>. Доработал <a href="https://yevgeniy-rakhmanov.com" title="Евгений Рахманов">Евгений Рахманов</a>. <?=date('Y')?></p>
		</div>
		<script>
			var pass = $('#password-show');
			$('button.show-password').click(function() {
				pass.attr('type', pass.attr('type') === 'password' ? 'text' : 'password');
			});
		</script>
	</body>
</html>