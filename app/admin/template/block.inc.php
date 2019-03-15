
<?=$bueditor?>

<form action="" method="post">
	<?php foreach ($vars as $i => $var) : ?>
		<div class="form-group<?=(!isset($_GET['block']) || $_GET['block']!=$i)?' hide':''?>">
			<input class="form-control" type="text" name="block[<?= $i?>][name]" value="<?= $i?>" placeholder="Название блока">
			<p class="text-danger small">Только латинские буквы любого регистра, цифры, минус и подчёркивание</p>
		</div>
		<div class="form-group">
			<textarea class="form-control editor-textarea" name="block[<?= $i?>][content]" <?=(!isset($_GET['block']) || $_GET['block']!=$i)?'':' rows="10"'?> id="text_<?= $i?>" placeholder="Текст блока"><?= $var ?></textarea>
			<p class="text-success small">Текст в HTML формате. Элементы массива <code>{$config['sitelink']}</code> оборачивайте фигурными скобками. Можно добавлять меню с помощью конструкции <code>{$get_menu_items($this_page, $название меню)}</code></p>
		</div>
	<?endforeach?>
	<?if(!isset($_GET['block'])):?>
		<div class="form-group">
			<input class="form-control" type="text" name="block[add_new_block][name]" value="" placeholder="Название блока">
			<p class="text-danger small">Только латинские буквы любого регистра, цифры, минус и подчёркивание</p>
		</div>
		<div class="form-group">
			<textarea class="form-control editor-textarea" rows="10" name="block[add_new_block][content]" id="text" placeholder="Текст блока"></textarea>
			<p class="text-success small">Текст в HTML формате. Элементы массива <code>{$config['sitelink']}</code> оборачивайте фигурными скобками. Можно добавлять меню с помощью конструкции <code>{$get_menu_items($this_page, $название меню)}</code></p>
		</div>
	<?endif?>
	<div class="form-actions type2">		
		<input type="submit" class="btn btn-success" name="save" value="Сохранить" title="Сохранить/создать страницу">
		<?if(isset($_GET['block'])):?>
		<input type="hidden" name="delete_block" value="<?=$_GET['block']?>" >
		<input type="submit" name="delete" class="btn btn-danger" value="Удалить" class="delete" onclick="return confirm('Вы действительно хотите удалить блок?')">
		<?endif?>
	</div>
</form>