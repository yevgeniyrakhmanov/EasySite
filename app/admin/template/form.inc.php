<script type="text/javascript">
	function form_validator(form)
	{
        if (form.page.value == '')
		{
			alert('Страница должна иметь название!');
			form.page.focus();
			return false;
		}
        if (form.title.value == '')
		{
			alert('Страница осталась без заголовка!');
			form.title.focus();
			return false;
		}
		return true;
	}
</script>
<?=$bueditor?>
<form action="" method="post" onsubmit="return form_validator(this);">
	<p class="text-danger small">Двойных кавычек в полях быть не должно!</p>
	<div class="form-group">
		<input class="form-control" type="text" name="page" value="<?= (isset($form['page'])) ? $form['page'] : '';?>" placeholder="ЧПУ (имя файла и адрес страницы в строке браузера)">
		<span class="text-danger small">Только латинские буквы любого регистра, цифры, минус и подчёркивание</span>
	</div>
	<div class="form-group">
		<input class="form-control" type="text" name="title" value="<?= (isset($form['title'])) ? $form['title'] : '';?>" placeholder="Заголовок">
	</div>
	<div class="form-group">
		<input class="form-control" type="text" name="keywords" value="<?= (isset($form['keywords'])) ? $form['keywords'] : '';?>" placeholder="Ключевые слова">
	</div>
	<div class="form-group">
		<input class="form-control" type="text" name="description" value="<?= (isset($form['description'])) ? $form['description'] : '';?>" placeholder="Описание страницы">
	</div>
	<div class="form-group">
		<label for="exampleFormControlSelect1">Шаблон страницы:</label>
		<select class="form-control" id="exampleFormControlSelect1" name="template">
			<? foreach ($templates as $i => $tpl): ?>
				<option value="<?= $tpl ?>"<?=(isset($form['template']) && $tpl == $form['template'])?' selected="selected"':((!isset($form['template'])&& $tpl == $config['template'])?' selected="selected"':'')?>><?=$tpl?></option>
			<? endforeach ?>
		</select>
	</div>
	<? if (!empty($blocks)): ?>
		<div class="form-group">
			<label for="exampleFormControlSelect2">Блоки:</label>
			<select class="form-control" multiple id="exampleFormControlSelect2" name="page_blocks[]">
				<?foreach ($blocks as $i): ?>
					<?$tmp=false; if(isset($form['page_blocks'])) {
						foreach ($form['page_blocks'] as $j) {
							$tmp=($i!=$j && $tmp!=true)?false:true;
						}
					}?>
					<option value="<?=$i?>" <?=($tmp)?'selected="selected"':''?>><?=$i?></option>					
				<? endforeach ?>
			</select>
			<span class="text-danger small">Для выделения нескольких блоков зажмите Ctrl</span>				
		</div>
	<? endif ?>
	<div class="form-group">
		<textarea class="form-control editor-textarea" rows="10" name="content" id="text" placeholder="Текст страницы"><?= (!empty($form['content'])) ? $form['content'] : ''; ?></textarea>
		<span class="text-success small">Текст в HTML формате. Можно использовать переменные $page прямо в тексте. Элементы массива <code>{$config['sitelink']}</code> оборачивайте фигурными скобками. Можно добавлять блоки.</span>
	</div>
	<div class="form-group">
		<input type="hidden" name="oldpage" value="<?= (isset($form['oldpage'])) ? $form['oldpage'] : 'new';?>" >
		<input type="hidden" name="dir" value="<?= isset($_GET['dir']) ? $_GET['dir'] : '' ?>">
		<input type="submit" class="btn btn-success" name="save" value="Сохранить страницу" title="Сохранить/создать">
		<? if (isset($_GET['page'])): ?>
			<input type="submit" name="delete" class="btn btn-danger" value="Удалить страницу" class="delete" onclick="return confirm('Вы действительно хотите удалить страницу?')">
		<?endif?>
	</div>	
</form>
</div>
</div>
</div>
