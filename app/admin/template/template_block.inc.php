# Дополнительные блоки данных
# Добавляйте сколько угодно. Не забудьте вставить переменную в design.inc.php или на страницу в папке content/

<? foreach ($blocks as $key => $block) { $block_name_rus = str2url($blocks[$key]['name']); ?>
$<?=$block_name_rus?> = <<<<?=$block_name_rus?>

<?php echo $blocks[$key]['content']?>

<?=$block_name_rus?>;
<?php } ?>
