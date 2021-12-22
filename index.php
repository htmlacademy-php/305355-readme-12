<?php

require_once('helpers.php');
require_once('my_functions.php');

$is_auth = rand(0, 1);

$user_name = 'Oleg'; // укажите здесь ваше имя

$con = mysqli_connect('localhost', 'root', 'root', 'readme');

$content_type_id = $_GET['content_type_id'] ?? '';

if ($con == false) {
  print('Ошибка подключения: ' . mysqli_connect_error());
}
else {
  // print('Соединение установлено');
  mysqli_set_charset($con, 'utf8');
  $content_types_sql = 'SELECT * FROM content_types';
  $posts_sql = $content_type_id ?
    'SELECT p.id AS id, p.title AS title, text_content, avatar, video_src, image_src, page_src, quote_author, u.name AS user_name, ct.class_name AS content_type
      FROM posts p JOIN users u ON p.user_id = u.id JOIN content_types ct ON p.content_type_id = ct.id WHERE ct.id = ' . $content_type_id . ' ORDER BY p.views_amount DESC'
    :
    'SELECT p.id AS id, p.title AS title, text_content, avatar, video_src, image_src, page_src, quote_author, u.name AS user_name, ct.class_name AS content_type
      FROM posts p JOIN users u ON p.user_id = u.id JOIN content_types ct ON p.content_type_id = ct.id ORDER BY p.views_amount DESC';
  
  $content_types_result = mysqli_query($con, $content_types_sql);
  $posts_result = mysqli_query($con, $posts_sql);

  if (!$content_types_result || !$posts_result) {
    $error = mysqli_error($con);
    print('Ошибка запроса: ' . $error);
  }
  else {
    // print('Успешный запрос');
    $content_types = mysqli_fetch_all($content_types_result, MYSQLI_ASSOC);
    $posts = mysqli_fetch_all($posts_result, MYSQLI_ASSOC);

    $main_content = include_template('main.php', ['posts' => $posts, 'content_types' => $content_types, 'content_type_id' => $content_type_id]);
    $layout = include_template('layout.php', [
        'is_auth' => $is_auth,
        'user_name' => $user_name,
        'main_content' => $main_content,
        'page_title' => 'readme: популярное',
      ]
    );
    echo $layout;
  }
}
?>
