<script type="text/javascript">
	function form_validator(form)
	{
  //       if (form.page.value == '')
		// {
		// 	alert('Страница должна иметь название!');
		// 	form.page.focus();
		// 	return false;
		// }
        if (form.title.value == '')
		{
			alert('Страница осталась без заголовка!');
			form.title.focus();
			return false;
		}
		return true;
	}
</script>
<script src='<? $config['sitelink']; ?>tinymce/tinymce.min.js'></script>
<script>
	tinymce.init({
		selector: 'textarea',
		language: 'ru',

		plugins: [
		    "advlist autolink lists link charmap print preview anchor image code",
		    "searchreplace visualblocks code fullscreen",
		    "insertdatetime media table contextmenu paste wordcount"
		],
		toolbar: "preview | undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | code image",

		automatic_uploads: true,
		images_upload_url: 'postAcceptor.php',
		images_reuse_filename: true,
		//images_upload_base_path: '../img'

	});
</script>
<!-- 
  $timezone = "Europe/Kiev";
  date_default_timezone_set($timezone);
  $today = date("d.m.Y");
 -->
<form action="" method="post" onsubmit="return form_validator(this);">
<!--
 	<div class="form-group">
		<input class="form-control" type="hidden" name="page" value=" (isset($form['page'])) ? $form['page'] : ''; " placeholder="ЧПУ (имя файла и адрес страницы в строке браузера)">
		<span class="text-danger small">Только латинские буквы любого регистра, цифры, минус и подчёркивание</span>
	</div>
 -->
 	<div class="form-group">
		<input class="form-control" type="hidden" name="date" value="<?= (isset($form['date'])) ? $form['date'] : '';?>">
	</div>
 	<div class="form-group">
 		<label for="title" class="text-success">Заголовок</label>
		<input class="form-control" type="text" name="title" value="<?= (isset($form['title'])) ? $form['title'] : '';?>" placeholder="" id="title">
	</div>
	<div class="form-group">
		<label for="keywords" class="text-success">Ключевые слова</label>
		<input class="form-control" type="text" name="keywords" value="<?= (isset($form['keywords'])) ? $form['keywords'] : '';?>" placeholder="" id="keywords">
	</div>
	<div class="form-group">
		<label for="description" class="text-success">Краткое содержание</label>
		<input class="form-control" type="text" name="description" value="<?= (isset($form['description'])) ? $form['description'] : '';?>" placeholder="" id="description">
	</div>
	<div class="form-group d-none">
		<label for="exampleFormControlSelect1">Шаблон страницы:</label>
		<select class="form-control" id="exampleFormControlSelect1" name="template">
			<? foreach ($templates as $i => $tpl): ?>
				<option value="page"<?=(isset($form['template']) && $tpl == $form['template'])?' selected="selected"':((!isset($form['template'])&& $tpl == $config['template'])?' selected="selected"':'')?>><?=$tpl?></option>
			<? endforeach ?>
		</select>
	</div>
	<? if (!empty($blocks)): ?>
		<label class="text-success">Блоки:</label>
		<div class="d-md-flex alert alert-dark">
			<?foreach ($blocks as $i): ?>
				<?$tmp=false; if(isset($form['page_blocks'])) {
					foreach ($form['page_blocks'] as $j) {
						$tmp=($i!=$j && $tmp!=true)?false:true;
					}
				}?>
				<div class="custom-control custom-checkbox mr-3">
					<input class="custom-control-input" type="checkbox" value="<?=$i?>" <?=($tmp)?'checked':''?> id="<?=$i?>" name="page_blocks[]">
					<label class="custom-control-label" for="<?=$i?>"><?=lat2rus($i)?></label>
				</div>
			<? endforeach ?>
		</div>
	<? endif ?>
	<div class="form-group">
		<label for="text" class="text-success">Текст</label>
		<textarea class="form-control editor-textarea" rows="10" name="content" id="text"><?= (!empty($form['content'])) ? $form['content'] : ''; ?></textarea>
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

