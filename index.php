<?php

require_once('helpers.php');
require_once('my_functions.php');
require_once('init.php');
require_once('models.php');

$content_type_id = $_GET['content_type_id'] ?? '';

$content_types = get_content_types($con);
$posts = get_posts($con, $content_type_id);

$main_content = include_template('main.php', ['posts' => $posts, 'content_types' => $content_types, 'content_type_id' => $content_type_id]);
$layout = include_template('layout.php', [
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'main_content' => $main_content,
    'page_title' => 'readme: популярное',
  ]
);
echo $layout;

?>
