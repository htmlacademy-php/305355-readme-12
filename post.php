<?php

require_once('helpers.php');
require_once('my_functions.php');
require_once('init.php');
require_once('models.php');

$post_id = $_GET['id'] ?? '';

if (!$post_id) {
  http_response_code(404);
  exit();
}

$post = get_post($con, $post_id);
$user_posts = get_user_posts($con, $post);
$user_subscriptions = get_user_subscriptions($con, $post);

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

?>