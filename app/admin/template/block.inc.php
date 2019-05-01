<script src='<? $config['sitelink']; ?>tinymce/tinymce.min.js'></script>
<form action="" method="post" class="alert alert-success">
<?php foreach ($vars as $i => $var) : ?>
	<div class="well well-inverse<?=(!isset($_GET['block']) || $_GET['block']!=$i)?' d-none':''?>">
		<script>
			tinymce.init({
				selector: '#text_<?= $i?>',
				language: 'ru',

				plugins: [
				    "advlist autolink lists link image charmap print preview anchor",
				    "searchreplace visualblocks code fullscreen",
				    "insertdatetime media table contextmenu paste image imagetools wordcount"
				],
				toolbar: "preview | undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image",

			});
		</script>
		<p class="text-center mb-0">Редактирование блока</p>
		<h2 class="text-center mt-0">«<?= url2str($i)?>»</h2>		
		<div class="form-group d-none">
			<label for="page-parent">Название блока:</label>
			<input type="text" class="form-control" name="block[<?= $i?>][name]" value="<?= $i?>" readonly>
			
		</div>
		<div class="control-group">
			<label for="page-parent">Текст блока:</label>
			<textarea name="block[<?= $i?>][content]" <?=(!isset($_GET['block']) || $_GET['block']!=$i)?'':'class="span8 editor-textarea" rows="10"'?> id="text_<?= $i?>"><?= $var ?></textarea>
		</div>
	</div>
<?endforeach?>
<?if(!isset($_GET['block'])):?>
	<script>
		tinymce.init({
			selector: '#text',
			language: 'ru',

			plugins: [
			    "advlist autolink lists link image charmap print preview anchor",
			    "searchreplace visualblocks code fullscreen",
			    "insertdatetime media table contextmenu paste image imagetools wordcount"
			],
			toolbar: "preview | undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image",

		});
	</script>
	<div class="form-group">
		<label for="page-parent">Название блока:</label>
		<input type="text" class="form-control" name="block[add_new_block][name]" value="" required>
	</div>
	<div class="form-group">
		<label for="page-parent">Текст блока</label>
		<textarea rows="10" name="block[add_new_block][content]" id="text"></textarea>
	</div>
<?endif?>
	<div class="mt-3">
		<input type="submit" class="btn btn-success" name="save" value="Сохранить" title="Сохранить/создать страницу">
<?if(isset($_GET['block'])):?>
		<input type="hidden" name="delete_block" value="<?=$_GET['block']?>" >
		<input type="submit" name="delete" class="btn btn-danger" value="Удалить" onclick="return confirm('Вы действительно хотите удалить блок?')">
<?endif?>
	</div>
</form>


	</div>
</div>





