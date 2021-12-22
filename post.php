<?php

require_once('helpers.php');
require_once('my_functions.php');

$is_auth = rand(0, 1);
$user_name = 'Oleg';
$con = mysqli_connect('localhost', 'root', 'root', 'readme');
$post_id = $_GET['id'] ?? '';

if ($post_id) {
  if ($con == false) {
    print('Ошибка подключения: ' . mysqli_connect_error());
  }
  else {
    mysqli_set_charset($con, 'utf8');

    $post_sql = 'SELECT *, u.id AS user_id, u.name AS user_name, u.avatar AS user_avatar,
      ct.class_name AS content_type, p.title AS post_title
      FROM posts p JOIN users u ON p.user_id = u.id JOIN content_types ct ON p.content_type_id = ct.id
      WHERE p.id = ' . $post_id;
    $post_result = mysqli_query($con, $post_sql);

    if (!$post_result) {
      $error = mysqli_error($con);
      print('Ошибка запроса: ' . $error);
    }
    else {
      $post = mysqli_fetch_assoc($post_result);
      // $post = mysqli_fetch_all($post_result, MYSQLI_ASSOC);
      $user_subscriptions_sql = 'SELECT COUNT(s.follower_id) AS followers_count FROM users u
        LEFT JOIN subscriptions s ON u.id = s.user_id
        WHERE u.id = ' . $post['user_id'];
      $user_posts_sql = 'SELECT COUNT(p.id) AS posts_count FROM users u
        LEFT JOIN posts p ON u.id = p.user_id
        WHERE u.id = ' . $post['user_id'];
      $user_subscriptions_result = mysqli_query($con, $user_subscriptions_sql);
      $user_posts_result = mysqli_query($con, $user_posts_sql);

      if (!$user_subscriptions_result || !$user_posts_result) {
        $error = mysqli_error($con);
        print('Ошибка запроса: ' . $error);
      }
      else {
        $user_subscriptions = mysqli_fetch_assoc($user_subscriptions_result);
        $user_posts = mysqli_fetch_assoc($user_posts_result);
        
        $post_content = include_template('post/' . $post['content_type'] . '.php' , [
          'img_url' => '/img/' . $post['image_src'],
          'youtube_url' => $post['video_src'],
          'url' => $post['page_src'],
          'title' => $post['post_title'],
          'author' => $post['quote_author'],
          'text' => $post['text_content'],
          // 'img_url' => $post['image_src'],
          // 'img_url' => $post['image_src'],
        ]);
        $main_content = include_template('post.php', [
          'post' => $post,
          'post_content' => $post_content,
          'user_subscriptions_count' => $user_subscriptions['followers_count'],
          'user_posts_count' => $user_posts['posts_count'],
        ]);
        $layout = include_template('layout.php', [
          'is_auth' => $is_auth,
          'user_name' => $user_name,
          'main_content' => $main_content,
          'page_title' => 'readme: популярное',
        ]);
        echo $layout;
      }
    }
  }
}
else {
  http_response_code(404);
}
?>