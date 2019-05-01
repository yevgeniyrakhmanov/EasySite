
<form action="" method="post" onsubmit="return form_validator(this);" class="alert alert-success">
	<div class="row">
		<div class="form-group col-md-6">
			<label for="page-parent">Заголовок сайта</label>
			<input type="text" class="form-control" name="settings[sitename]" value="<?= (isset($settings['sitename'])) ? $settings['sitename'] : '' ?>" >
		</div>
		<div class="form-group col-md-6">
			<label for="page-parent">Слоган</label>
			<input type="text" class="form-control" name="settings[slogan]" value="<?= (isset($settings['slogan'])) ? $settings['slogan'] : '' ?>" >
		</div>		
	</div>
	<hr>
	<div class="row d-none">
		<div class="form-group">
			<label for="page-parent">Кодировка</label>
			<input type="text" class="form-control" name="settings[encoding]" value="<?= (isset($settings['encoding'])) ? $settings['encoding'] : '' ?>" >
		</div>
		<div class="form-group">
			<label for="page-parent">Шаблон по умолчанию</label>
			<input type="text" class="form-control" name="settings[template]" value="<?= (isset($settings['template'])) ? $settings['template'] : '' ?>" >
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-6">
			<label for="page-parent">Логин</label>
			<input type="text" class="form-control" name="settings[login]" value="<?= (isset($settings['login'])) ? $settings['login'] : '' ?>" >
		</div>
		<div class="form-group col-8 col-md-4">
			<label for="page-parent">Пароль</label>
			<input type="password" class="form-control" name="settings[password]" value="<?= (isset($settings['password'])) ? $settings['password'] : '' ?>" id="password-show">
		</div>
		<div class="form-group col-4 col-md-2">
			<label for="page-parent">&nbsp;</label>
			<button type="button" class="form-control btn show-password"><i class="fas fa-eye"></i></button>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="form-group col-md-6">
			<label for="page-parent">E-mail, на который отправляется сообщение с контактной формы</label>
			<input type="text" class="form-control" name="settings[emailadmin]" value="<?= (isset($settings['emailadmin'])) ? $settings['emailadmin'] : '' ?>" >
		</div>
		<div class="form-group col-md-6">
			<label for="page-parent">Тема сообщения с контактной формы</label>
			<input type="text" class="form-control" name="settings[emailsubject]" value="<?= (isset($settings['emailsubject'])) ? $settings['emailsubject'] : '' ?>" >
		</div>
	</div>
	<hr>
	<div class="form-group form-actions type2">
		<input type="submit" class="btn btn-success" name="save" value="Сохранить" title="Сохранить/создать страницу">
	</div>	
</form>
