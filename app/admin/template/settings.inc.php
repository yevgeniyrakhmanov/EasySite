
<form action="" method="post" onsubmit="return form_validator(this);" class="alert alert-success">
	<div class="form-group">
		<label for="page-parent">Заголовок сайта:</label>
		<textarea class="form-control" rows="1" name="settings[sitename]"><?= (isset($settings['sitename'])) ? $settings['sitename'] : '' ?></textarea>
	</div>
	<div class="form-group">
		<label for="page-parent">Слоган:</label>
		<input type="text" class="form-control" name="settings[slogan]" value="<?= (isset($settings['slogan'])) ? $settings['slogan'] : '' ?>" >
	</div>
	<div class="form-group">
		<label for="page-parent">Кодировка:</label>
		<input type="text" class="form-control" name="settings[encoding]" value="<?= (isset($settings['encoding'])) ? $settings['encoding'] : '' ?>" >
	</div>
	<div class="form-group">
		<label for="page-parent">Шаблон по умолчанию:</label>
		<input type="text" class="form-control" name="settings[template]" value="<?= (isset($settings['template'])) ? $settings['template'] : '' ?>" >
	</div>				
	<div class="form-group">
		<label for="page-parent">Логин:</label>
		<input type="text" class="form-control" name="settings[login]" value="<?= (isset($settings['login'])) ? $settings['login'] : '' ?>" >
	</div>
	<div class="row">
		<div class="form-group col-10">
			<label for="page-parent">Пароль:</label>
			<input type="password" class="form-control" name="settings[password]" value="<?= (isset($settings['password'])) ? $settings['password'] : '' ?>" id="password-show">
		</div>
		<div class="form-group col-2">
			<label for="page-parent">&nbsp;</label>
			<button type="button" class="form-control btn show-password"><i class="fas fa-eye"></i></button>
		</div>
	</div>
	<div class="form-group">
		<label for="page-parent">Секретное слово для генерации антиспама:</label>
		<input type="text" class="form-control" name="settings[secretWord]" value="<?= (isset($settings['secretWord'])) ? $settings['secretWord'] : '' ?>" >
	</div>
	<div class="form-group">
		<label for="page-parent">E-mail адрес, на который отправляется сообщение:</label>
		<input type="text" class="form-control" name="settings[email][receiver]" value="<?= (isset($settings['email']['receiver'])) ? $settings['email']['receiver'] : '' ?>" >
	</div>
	<div class="form-group">
		<label for="page-parent">Тема письма обратной связи:</label>
		<textarea class="form-control" rows="2" name="settings[email][subject]"><?= (isset($settings['email']['subject'])) ? $settings['email']['subject'] : '';?></textarea>
	</div>
	<div class="form-group">
		<label for="page-parent"> Обязательно ли поле «Тема письма»:</label>
		<select name="settings[form][feedback][subject]" class="span12">
			<option value="true" <?=($settings['form']['feedback']['subject']== 'true')?'selected="selected"':''?>>Да</option>
			<option value="false" <?=($settings['form']['feedback']['subject']== 'false')?'selected="selected"':''?>>Нет</option>
			</select>				
	</div>
	<div class="form-group">
		<label for="page-parent">Сообщение отправлено:</label>
		<textarea class="form-control" rows="2" name="settings[form][feedbackSent]"><?= (isset($settings['form']['feedbackSent'])) ? $settings['form']['feedbackSent'] : '';?></textarea>
	</div>
	<div class="form-group">
		<label for="page-parent">Неудачная отправка:</label>
		<textarea class="form-control" rows="2" name="settings[form][notSent]"><?= (isset($settings['form']['notSent'])) ? $settings['form']['notSent'] : '';?></textarea>
	</div>
	<div class="form-group">
		<label for="page-parent">СПАМ?!:</label>
		<textarea class="form-control" rows="2" name="settings[form][isSpam]"><?= (isset($settings['form']['isSpam'])) ? $settings['form']['isSpam'] : '';?></textarea>
	</div>
	<div class="form-group">
		<label for="page-parent">Нет мыла!:</label>
		<textarea class="form-control" rows="2" name="settings[form][emptyEmail]"><?= (isset($settings['form']['emptyEmail'])) ? $settings['form']['emptyEmail'] : '';?></textarea>
	</div>
	<div class="form-group">
		<label for="page-parent">Нет имени!:</label>
		<textarea class="form-control" rows="2" name="settings[form][emptyName]"><?= (isset($settings['form']['emptyName'])) ? $settings['form']['emptyName'] : '';?></textarea>
	</div>
	<div class="form-group">
		<label for="page-parent">Нет темы!:</label>
		<textarea class="form-control" rows="2" name="settings[form][emptyTopic]"><?= (isset($settings['form']['emptyTopic'])) ? $settings['form']['emptyTopic'] : '';?></textarea>
	</div>
	<div class="form-group">
		<label for="page-parent">Нет сообщения!:</label>
		<textarea class="form-control" rows="2" name="settings[form][emptyMessage]"><?= (isset($settings['form']['emptyMessage'])) ? $settings['form']['emptyMessage'] : '';?></textarea>
	</div>
	<?if(isset($file)):?>
		<div class="form-group">
			<label for="page-parent">Содержание файла config.ini.php:</label>
			<textarea class="form-control" rows="10"><?= (isset($file)) ? $file : ''; ?></textarea>
		</div>
	<?endif?>
	<div class="form-group form-actions type2">
		<input type="submit" class="btn btn-success" name="save" value="Сохранить" title="Сохранить/создать страницу">
	</div>	
</form>