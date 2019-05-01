<?php

# Данные о странице
$title = 'Контакты';
$keywords = 'ключевые слова';
$description = 'Описание страницы';
$template = 'page';
$page_blocks = '';

# Содержание страницы
$content = <<<EOF
<div id="contact_page">
	<form id="feedback" class="pb-3">
		<input type="hidden" name="project_name" value="{$config['sitename']}">
		<input type="hidden" name="admin_email" value="{$config['emailadmin']}">
		<input type="hidden" name="form_subject" value="{$config['emailsubject']}">
		<div class="form-group">
			<input class="form-control" type="text" id="name" name="Имя" placeholder="Your name *" required>
		</div>
		<div class="form-group">
			<input class="form-control" type="email" id="email" name="E-mail" placeholder="Your e-mail *" required>
		</div>
		<div class="form-group">
			<textarea class="form-control" id="message" name="Сообщение" placeholder="Your message *" required rows="7"></textarea>
		</div>
		<button class="btn btn-primary" id="send">Send</button>
	</form>
	<div id="feed-alert">
		<div><p>Thank You!</p></div>
	</div>
</div>
EOF;
