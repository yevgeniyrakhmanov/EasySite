
# Данные о странице
$link = '<?=$page_content['link']?>';
$date = '<?=$page_content['date']?>';
$category = '<?=$page_content['category']?>';
$title = '<?=$page_content['title']?>';
$keywords = '<?=$page_content['keywords']?>';
$description = '<?=$page_content['description']?>';
$template = '<?=$page_content['template']?>';
$page_blocks = '<?=$page_content['page_blocks']?>';

# Содержание страницы
$content = <<<EOF
<?=$page_content['content']?>

EOF;
