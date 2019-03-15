<script type="text/javascript">
	function moreInputs(depth, offset, mark)
	{
		$(mark).parent().after('<div class="col-md-2 form-group"><input type="text" name="new_menu['+depth+'][0][]" class="form-control" /></div><div class="col-md-3 form-group"><input type="text" name="new_menu['+depth+'][1][]" class="form-control" /></div><div class="col-md-3 form-group"><input type="text" name="new_menu['+depth+'][2][]"  class="form-control" /><input type="hidden" name="new_menu['+depth+'][offset][]" value="'+offset+'"/></div><div class="col-md-1 form-group"><a class="btn btn-danger" href="#" title="Удалить пункт меню" onclick="return deleteInputs(this);"><i class="fas fa-times"></i></a></div><div class="col-md-1 form-group"><a class="btn btn-success" href="#" onclick="return moreInputs('+depth+', '+offset+', (this))"><i class="fas fa-plus"></i></a></div>');
		
		$('.add_blocks').remove();
		
		return false;
	}
	function moreInputs1(depth, offset, mark)
	{
		$(mark).parent().after('<div class="col-md-2 form-group"><input type="text" name="new_menu_block['+depth+']['+offset+'][0][]" class="form-control" /></div><div class="col-md-3 form-group"><input type="text" name="new_menu_block['+depth+']['+offset+'][1][]" class="form-control" /></div><div class="col-md-3 form-group"><input type="text" name="new_menu_block['+depth+']['+offset+'][2][]" class="form-control" /></div><div class="col-md-1 form-group"><a class="btn btn-danger" href="#" title="Удалить пункт меню" onclick="return deleteInputs(this);"><i class="fas fa-times"></i></a></div><div class="col-md-1 form-group"><a class="btn btn-success" href="#" onclick="return moreInputs1('+depth+', '+offset+', (this))"><i class="fas fa-plus"></i></a></div>');
		
		return false;
	}	
	function moreBlocks(depth, offset, mark)
	{
		$(mark).parent().after('<div class="col-md-2 form-group"><input type="text" name="new_menu_block['+depth+']['+offset+'][0][]" class="form-control" /></div><div class="col-md-3 form-group"><input type="text" name="new_menu_block['+depth+']['+offset+'][1][]" class="form-control" /></div><div class="col-md-3 form-group"><input type="text" name="new_menu_block['+depth+']['+offset+'][2][]" class="form-control" /></div><div class="col-md-1 form-group"><a class="btn btn-danger" href="#" title="Удалить пункт меню" onclick="return deleteInputs(this);"><i class="fas fa-times"></i></a></div><div class="col-md-1 form-group"><a class="btn btn-success" href="#" onclick="return moreInputs1('+depth+', '+offset+', (this))"><i class="fas fa-plus"></i></a></div>');
		
		$(mark).remove();
		
		$('.add_inputs').remove();
		$('.add_blocks').remove();
		
		return false;
		
	}

	function deleteInputs(a)
	{
		if($($(a).parent().parent().children('div')).size()==1){
			$(a).parent().parent().remove();
		}
		else {					
			if($(a).parent().prev().is('p'))
				$(a).parent().prev().remove();
			$(a).parent().next().remove();
			$(a).parent().remove();
		}
								
		return false;
	}
</script>
<form action="" method="post">
	<? if (isset($_GET['menu'])): ?>
		<div class="form-group">
			<input class="form-control" type="text" name="new_name" value="<?=$_GET['menu']?>" placeholder="Название меню">
			<input type="hidden" name="old_name" value="<?=$_GET['menu']?>">		
			<p class="text-danger small">Только латинские буквы любого регистра, цифры, минус и подчёркивание. Первым символом ОБЯЗАТЕЛЬНО! должна быть буква латинского алфавита.</p>
		</div>
		<div class="form-actions type2">
			<input type="submit" class="btn btn-success" name="save" value="Сохранить" title="Сохранить/создать страницу">
			<? if (isset($_GET['menu'])): ?>
			<input type="hidden" name="delete_menu" value="<?=$_GET['menu']?>" >
			<input type="submit" name="delete" class="btn btn-danger" value="Удалить" onclick="return confirm('Вы действительно хотите удалить меню?')">
			<? endif ?>
		</div>
		<hr>
		<?=$menu_items?>
	<? endif ?>
	<?if(!isset($_GET['menu'])):?>
		<div class="form-group">
			<input class="form-control" type="text" name="new_name" value="" placeholder="Название меню">
			<input type="hidden" name="old_name" value="<?=$_GET['menu']?>">		
			<p class="text-danger small">Только латинские буквы любого регистра, цифры, минус и подчёркивание. Первым символом ОБЯЗАТЕЛЬНО! должна быть буква латинского алфавита.</p>
		</div>
		<? for ($j=0; $j<5; $j++): ?>
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<input class="form-control" type="text" name="menu[<?=$j?>][0]" value="" placeholder="адрес страницы"/>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<input class="form-control" type="text" name="menu[<?=$j?>][1]" value="" placeholder="анкор ссылки (текстовая часть ссылки)"/>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<input class="form-control" type="text" name="menu[<?=$j?>][2]" value="" placeholder="заголовок (всплывающая подсказка)"/>
					</div>
				</div>
				<div class="col-md-1">
					<div class="form-group">
						<a href="#" title="Удалить пункт меню" onclick="return deleteInputs(this);" class="btn btn-danger"><i class="fas fa-times"></i></a>
					</div>
				</div>		
			</div>
		<? endfor ?>
	<? endif ?>
	<div class="form-actions type2">
		<input type="submit" class="btn btn-success" name="save" value="Сохранить" title="Сохранить/создать страницу">
		<? if (isset($_GET['menu'])): ?>
		<input type="hidden" name="delete_menu" value="<?=$_GET['menu']?>" >
		<input type="submit" name="delete" class="btn btn-danger" value="Удалить" class="delete" onclick="return confirm('Вы действительно хотите удалить меню?')">
		<? endif ?>
	</div>
</form>
</div>
</div>
</div>
