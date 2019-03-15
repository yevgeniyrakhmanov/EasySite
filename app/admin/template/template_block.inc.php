# Дополнительные блоки данных
# Добавляйте сколько угодно. Не забудьте вставить переменную в design.inc.php или на страницу в папке content/

<? foreach ($blocks as $key => $block) { ?>
$<?=$blocks[$key]['name']?> = <<<<?=$blocks[$key]['name']?>

<?php echo $blocks[$key]['content']?>

<?=$blocks[$key]['name']?>;
<?php } ?>
